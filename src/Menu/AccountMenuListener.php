<?php

namespace Arobases\SyliusProfessionalCustomerPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;
use Sylius\Component\Customer\Context\CustomerContextInterface;

final class AccountMenuListener
{
    /**
     * @var CustomerContextInterface
     */
    private $customerContext;

    /**
     * @param CustomerContextInterface $customerContext
     */
    public function __construct(CustomerContextInterface $customerContext)
    {
        $this->customerContext = $customerContext;
    }


    public function addAccountMenuItems(MenuBuilderEvent $event): void
    {

        if(false === $this->customerContext->getCustomer()->isPro()) {
            return;
        }
        $menu = $event->getMenu();
        $menu
            ->addChild('new', ['route' => 'arobases_sylius_professional_customer_shop_account_dashboard'])
            ->setLabel('arobases_sylius_professional_customer.menu.ui.professional_information')
            ->setLabelAttribute('icon', 'star')
        ;
    }
}
