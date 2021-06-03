<?php

declare(strict_types=1);

namespace Arobases\SyliusProfessionalCustomerPlugin\EventListener;

use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Mailer\Sender\SenderInterface;
use Sylius\Component\User\Model\UserInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webmozart\Assert\Assert;

final class CustomerProVerifiedListener
{
    /** @var SenderInterface */
    private $emailSender;

    /** @var ChannelContextInterface */
    private $channelContext;

    /** @var LocaleContextInterface */
    private $localeContext;

    public function __construct(
        SenderInterface $emailSender,
        ChannelContextInterface $channelContext,
        LocaleContextInterface $localeContext
    ) {
        $this->emailSender = $emailSender;
        $this->channelContext = $channelContext;
        $this->localeContext = $localeContext;
    }

    public function sendUserProVerifiedEmail(GenericEvent $event): void
    {
        $customer = $event->getSubject();

        Assert::isInstanceOf($customer, CustomerInterface::class);

        $user = $customer->getUser();
        if (null === $user) {
            return;
        }

        $email = $customer->getEmail();
        if (empty($email)) {
            return;
        }

        Assert::isInstanceOf($user, ShopUserInterface::class);

        if ($customer->isProVerified()) {
            $this->sendEmail($user, 'customer_pro_confirmation');
        }
    }

    private function sendEmail(UserInterface $user, string $emailCode): void
    {
        $this->emailSender->send(
            $emailCode,
            [$user->getEmail()],
            [
                'user' => $user,
                'channel' => $this->channelContext->getChannel(),
                'localeCode' => $this->localeContext->getLocaleCode(),
            ]
        );
    }
}
