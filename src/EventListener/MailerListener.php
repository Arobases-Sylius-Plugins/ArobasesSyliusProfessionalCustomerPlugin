<?php

declare(strict_types=1);

namespace Arobases\SyliusProfessionalCustomerPlugin\EventListener;

use Arobases\SyliusProfessionalCustomerPlugin\Model\CustomerInterface as ProfessionalCustomerInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Mailer\Sender\SenderInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webmozart\Assert\Assert;

/**
 * Decorates the Sylius user mailer listener: professional customers receive the professional
 * registration email (and the shop contact is notified) instead of the default welcome email.
 */
final class MailerListener
{
    public function __construct(
        private object $decoratedMailerListener,
        private SenderInterface $emailSender,
        private ChannelContextInterface $channelContext,
        private LocaleContextInterface $localeContext,
    ) {
    }

    public function sendResetPasswordTokenEmail(GenericEvent $event): void
    {
        $this->decoratedMailerListener->sendResetPasswordTokenEmail($event);
    }

    public function sendResetPasswordPinEmail(GenericEvent $event): void
    {
        $this->decoratedMailerListener->sendResetPasswordPinEmail($event);
    }

    public function sendVerificationTokenEmail(GenericEvent $event): void
    {
        $this->decoratedMailerListener->sendVerificationTokenEmail($event);
    }

    public function sendVerificationSuccessEmail(GenericEvent $event): void
    {
        $user = $event->getSubject();
        Assert::isInstanceOf($user, ShopUserInterface::class);

        // Professional customers are handled by CustomerProVerifiedListener
        if ($this->isProfessional($user->getCustomer())) {
            return;
        }

        $this->decoratedMailerListener->sendVerificationSuccessEmail($event);
    }

    public function sendUserRegistrationEmail(GenericEvent $event): void
    {
        $customer = $event->getSubject();
        Assert::isInstanceOf($customer, CustomerInterface::class);

        if (!$this->isProfessional($customer)) {
            $this->decoratedMailerListener->sendUserRegistrationEmail($event);

            return;
        }

        $channel = $this->channelContext->getChannel();
        Assert::isInstanceOf($channel, ChannelInterface::class);

        if ($channel->isAccountVerificationRequired()) {
            return;
        }

        $user = $customer->getUser();
        if (!$user instanceof ShopUserInterface || null === $customer->getEmail() || '' === $customer->getEmail()) {
            return;
        }

        $this->sendEmail($user, 'user_registration_pro', (string) $user->getEmail());

        if (null !== $channel->getContactEmail()) {
            $this->sendEmail($user, 'admin_customer_pro_notification', $channel->getContactEmail());
        }
    }

    private function isProfessional(mixed $customer): bool
    {
        return $customer instanceof ProfessionalCustomerInterface && true === $customer->isPro();
    }

    private function sendEmail(ShopUserInterface $user, string $emailCode, string $recipientEmail): void
    {
        $this->emailSender->send(
            $emailCode,
            [$recipientEmail],
            [
                'user' => $user,
                'channel' => $this->channelContext->getChannel(),
                'localeCode' => $this->localeContext->getLocaleCode(),
            ],
        );
    }
}
