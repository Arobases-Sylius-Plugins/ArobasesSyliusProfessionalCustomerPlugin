<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Arobases\SyliusProfessionalCustomerPlugin\EventListener;

use Sylius\Bundle\CoreBundle\Mailer\Emails as CoreBundleEmails;
use Sylius\Bundle\UserBundle\Mailer\Emails as UserBundleEmails;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Mailer\Sender\SenderInterface;
use Sylius\Component\User\Model\UserInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webmozart\Assert\Assert;

final class MailerListener
{
    private SenderInterface $emailSender;

    private ChannelContextInterface $channelContext;

    private LocaleContextInterface $localeContext;

    public function __construct(
        SenderInterface $emailSender,
        ChannelContextInterface $channelContext,
        LocaleContextInterface $localeContext
    ) {
        $this->emailSender = $emailSender;
        $this->channelContext = $channelContext;
        $this->localeContext = $localeContext;
    }

    public function sendResetPasswordTokenEmail(GenericEvent $event): void
    {
        $this->sendEmail($event->getSubject(), UserBundleEmails::RESET_PASSWORD_TOKEN,$event->getSubject()->getEmail());
    }

    public function sendResetPasswordPinEmail(GenericEvent $event): void
    {
        $this->sendEmail($event->getSubject(), UserBundleEmails::RESET_PASSWORD_PIN, $event->getSubject()->getEmail());
    }

    public function sendVerificationTokenEmail(GenericEvent $event): void
    {
        $this->sendEmail($event->getSubject(), UserBundleEmails::EMAIL_VERIFICATION_TOKEN, $event->getSubject()->getEmail());
    }

    public function sendUserRegistrationEmail(GenericEvent $event): void
    {
        $channel = $this->channelContext->getChannel();
        if ($channel->isAccountVerificationRequired()) {
            return;
        }

        $customer = $event->getSubject();

        Assert::isInstanceOf($customer, CustomerInterface::class);

        /** @var ShopUserInterface $user */
        $user = $customer->getUser();
        if (null === $user) {
            return;
        }

        $email = $customer->getEmail();
        if (empty($email)) {
            return;
        }

        Assert::isInstanceOf($user, ShopUserInterface::class);


        if ($customer->isPro()) {
            $this->sendEmail($user, 'user_registration_pro', $user->getEmail());
            if($channel->getContactEmail() !== null){
                $this->sendEmail($user, 'admin_customer_pro_notification', $channel->getContactEmail());
            }
        }else{
            $this->sendEmail($user, CoreBundleEmails::USER_REGISTRATION, $user->getEmail());
        }
    }

    private function sendEmail(UserInterface $user, string $emailCode, string $recipientEmail): void
    {
        $this->emailSender->send(
            $emailCode,
            [$recipientEmail],
            [
                'user' => $user,
                'channel' => $this->channelContext->getChannel(),
                'localeCode' => $this->localeContext->getLocaleCode(),
            ]
        );
    }
}
