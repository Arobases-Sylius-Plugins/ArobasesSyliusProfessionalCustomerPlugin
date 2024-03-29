<?php

declare(strict_types=1);

namespace Arobases\SyliusProfessionalCustomerPlugin\EventListener;

use Sylius\Component\Core\Model\Channel;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\ShopUser;
use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Core\Repository\CustomerRepositoryInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Mailer\Sender\SenderInterface;
use Sylius\Component\User\Model\UserInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webmozart\Assert\Assert;

final class CustomerProVerifiedListener
{
    private SenderInterface $emailSender;

    private ChannelContextInterface $channelContext;

    private LocaleContextInterface $localeContext;
    private CustomerRepositoryInterface  $customerRepository;

    /**
     * @param SenderInterface $emailSender
     * @param ChannelContextInterface $channelContext
     * @param LocaleContextInterface $localeContext
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(SenderInterface $emailSender, ChannelContextInterface $channelContext, LocaleContextInterface $localeContext, CustomerRepositoryInterface $customerRepository)
    {
        $this->emailSender = $emailSender;
        $this->channelContext = $channelContext;
        $this->localeContext = $localeContext;
        $this->customerRepository = $customerRepository;
    }

    public function sendCustomerProVerifiedEmail(GenericEvent $event): void
    {
        /** @var ShopUser $user */
        $user = $event->getSubject();

        Assert::isInstanceOf($user, ShopUserInterface::class);

        /** @var Channel $channel */
        $channel = $this->channelContext->getChannel();

        if ($channel->isAccountVerificationRequired() && $user->getCustomer()->isPro()) {
            $this->sendEmail($user, 'user_registration_pro', $user->getEmail());
            if($channel->getContactEmail() !== null){
                $this->sendEmail($user, 'admin_customer_pro_notification', $channel->getContactEmail());
            }
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



