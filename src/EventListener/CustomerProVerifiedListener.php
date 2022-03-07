<?php

declare(strict_types=1);

namespace App\EntityListener;

use App\Entity\Channel\Channel;
use App\Entity\Product\Product;
use App\Entity\Product\ProductTaxon;
use App\Entity\Taxonomy\Taxon;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Bundle\CoreBundle\Mailer\Emails;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\Customer;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Core\Repository\CustomerRepositoryInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Mailer\Sender\SenderInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
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
        /** @var CustomerInterface $newCustomer */
        $user = $event->getSubject();

        Assert::isInstanceOf($user, ShopUserInterface::class);

        /** @var Channel $channel */
        $channel = $this->channelContext->getChannel();

        if ($channel->isAccountVerificationRequired() && $user->getCustomer()->isPro()) {

            //   dump($newCustomer);die;
            $this->sendEmail($user, 'user_registration_pro');
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



