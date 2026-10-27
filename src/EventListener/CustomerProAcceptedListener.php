<?php

declare(strict_types=1);

namespace Arobases\SyliusProfessionalCustomerPlugin\EventListener;

use Arobases\SyliusProfessionalCustomerPlugin\Model\CustomerInterface as ProfessionalCustomerInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Mailer\Sender\SenderInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webmozart\Assert\Assert;

final class CustomerProAcceptedListener
{
    public function __construct(
        private SenderInterface $emailSender,
        private ChannelContextInterface $channelContext,
        private LocaleContextInterface $localeContext,
    ) {
    }

    public function sendCustomerProAcceptedEmail(GenericEvent $event): void
    {
        $customer = $event->getSubject();
        Assert::isInstanceOf($customer, CustomerInterface::class);

        if (
            !$customer instanceof ProfessionalCustomerInterface ||
            true !== $customer->isPro() ||
            true !== $customer->isProVerified() ||
            $customer->isProVerifiedEmailSend()
        ) {
            return;
        }

        $channel = $this->channelContext->getChannel();
        Assert::isInstanceOf($channel, ChannelInterface::class);

        $user = $customer->getUser();
        if (!$channel->isAccountVerificationRequired() || null === $user || null === $user->getEmail()) {
            return;
        }

        $this->emailSender->send(
            'customer_pro_confirmation',
            [$user->getEmail()],
            [
                'user' => $user,
                'channel' => $channel,
                'localeCode' => $this->localeContext->getLocaleCode(),
            ],
        );

        $customer->setProVerifiedEmailSend(true);
    }
}
