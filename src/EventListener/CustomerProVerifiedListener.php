<?php

declare(strict_types=1);

namespace Arobases\SyliusProfessionalCustomerPlugin\EventListener;

use Arobases\SyliusProfessionalCustomerPlugin\Model\CustomerInterface as ProfessionalCustomerInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Mailer\Sender\SenderInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webmozart\Assert\Assert;

final class CustomerProVerifiedListener
{
    public function __construct(
        private SenderInterface $emailSender,
        private ChannelContextInterface $channelContext,
        private LocaleContextInterface $localeContext,
    ) {
    }

    public function sendCustomerProVerifiedEmail(GenericEvent $event): void
    {
        $user = $event->getSubject();
        Assert::isInstanceOf($user, ShopUserInterface::class);

        $customer = $user->getCustomer();
        if (!$customer instanceof ProfessionalCustomerInterface || true !== $customer->isPro()) {
            return;
        }

        $channel = $this->channelContext->getChannel();
        Assert::isInstanceOf($channel, ChannelInterface::class);

        if (!$channel->isAccountVerificationRequired()) {
            return;
        }

        $this->sendEmail($user, 'user_registration_pro', (string) $user->getEmail());

        if (null !== $channel->getContactEmail()) {
            $this->sendEmail($user, 'admin_customer_pro_notification', $channel->getContactEmail());
        }
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
