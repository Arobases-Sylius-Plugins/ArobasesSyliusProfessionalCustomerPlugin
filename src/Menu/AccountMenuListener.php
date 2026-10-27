<?php

declare(strict_types=1);

namespace Arobases\SyliusProfessionalCustomerPlugin\Menu;

use Arobases\SyliusProfessionalCustomerPlugin\Model\CustomerInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;
use Sylius\Component\Customer\Context\CustomerContextInterface;

final class AccountMenuListener
{
    public function __construct(private CustomerContextInterface $customerContext)
    {
    }

    public function addAccountMenuItems(MenuBuilderEvent $event): void
    {
        $customer = $this->customerContext->getCustomer();
        if (!$customer instanceof CustomerInterface || true !== $customer->isPro()) {
            return;
        }

        $event->getMenu()
            ->addChild('professional_information', ['route' => 'arobases_sylius_professional_customer_shop_account_dashboard'])
            ->setLabel('arobases_sylius_professional_customer.menu.ui.professional_information')
            ->setLabelAttribute('icon', 'star')
        ;
    }
}
