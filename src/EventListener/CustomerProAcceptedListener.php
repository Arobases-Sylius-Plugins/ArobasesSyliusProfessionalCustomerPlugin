<?php

declare(strict_types=1);

namespace Arobases\SyliusProfessionalCustomerPlugin\EventListener;

use Sylius\Component\Core\Model\Channel;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Core\Repository\CustomerRepositoryInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Mailer\Sender\SenderInterface;
use Sylius\Component\User\Model\UserInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webmozart\Assert\Assert;

final class CustomerProAcceptedListener
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

    public function sendCustomerProAcceptedEmail(GenericEvent $event): void
    {

        /** @var CustomerInterface $newCustomer */
        $customer = $event->getSubject();

        Assert::isInstanceOf($customer, CustomerInterface::class);

        /** @var Channel $channel */
        $channel = $this->channelContext->getChannel();

        if ($channel->isAccountVerificationRequired() && $customer->isPro() && $customer->isProVerified() ) {

            /** Customer */
            if ($customer->isProVerifiedEmailSend() === false) {

                $this->emailSender->send(
                    'customer_pro_confirmation',
                    [$customer->getUser()->getEmail()],
                    [
                        'user' => $customer->getUser(),
                        'channel' => $this->channelContext->getChannel(),
                        'localeCode' => $this->localeContext->getLocaleCode(),
                    ]
                );

                $customer->setProVerifiedEmailSend(true);

            }

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



