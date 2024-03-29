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

namespace Arobases\SyliusProfessionalCustomerPlugin\Component\Core\OrderProcessing;

use Sylius\Component\Addressing\Matcher\ZoneMatcherInterface;
use Sylius\Component\Addressing\Model\ZoneInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\AdjustmentInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\Scope;
use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Core\Provider\ZoneProviderInterface;
use Sylius\Component\Core\Taxation\Exception\UnsupportedTaxCalculationStrategyException;
use Sylius\Component\Core\Taxation\Strategy\TaxCalculationStrategyInterface;
use Sylius\Component\Customer\Context\CustomerContextInterface;
use Sylius\Component\Order\Model\OrderInterface as BaseOrderInterface;
use Sylius\Component\Order\Processor\OrderProcessorInterface;
use Sylius\Component\Registry\PrioritizedServiceRegistryInterface;
use Webmozart\Assert\Assert;

final class OrderTaxesProcessor implements OrderProcessorInterface
{
    /** @var ZoneProviderInterface */
    private $defaultTaxZoneProvider;

    /** @var ZoneMatcherInterface */
    private $zoneMatcher;

    /** @var PrioritizedServiceRegistryInterface */
    private $strategyRegistry;

    private CustomerContextInterface $customerContext;

    private ChannelContextInterface $channelContext;

    public function __construct(
        ZoneProviderInterface $defaultTaxZoneProvider,
        ZoneMatcherInterface $zoneMatcher,
        PrioritizedServiceRegistryInterface $strategyRegistry,
        CustomerContextInterface $customerContext,
        ChannelContextInterface $channelContext

    ) {
        $this->defaultTaxZoneProvider = $defaultTaxZoneProvider;
        $this->zoneMatcher = $zoneMatcher;
        $this->strategyRegistry = $strategyRegistry;
        $this->customerContext = $customerContext;
        $this->channelContext = $channelContext;
    }

    public function process(BaseOrderInterface $order): void
    {
        /** @var OrderInterface $order */
        Assert::isInstanceOf($order, OrderInterface::class);

        $this->clearTaxes($order);
        if ($order->isEmpty()) {
            return;
        }
        if(null !== $this->customerContext->getCustomer()  ){
            if(
                $this->customerContext->getCustomer()->isPro() &&
                $this->customerContext->getCustomer()->isProVerified() &&
                $this->channelContext->getChannel()->getConsiderTaxesForProfessionalCustomer()){
                return;
            }
        }

        $zone = $this->getTaxZone($order);

        if (null === $zone) {
            return;
        }



        /** @var TaxCalculationStrategyInterface $strategy */
        foreach ($this->strategyRegistry->all() as $strategy) {
            if ($strategy->supports($order, $zone)) {
                $strategy->applyTaxes($order, $zone);

                return;
            }
        }

        throw new UnsupportedTaxCalculationStrategyException();
    }

    private function getTaxZone(OrderInterface $order): ?ZoneInterface
    {
        $billingAddress = $order->getBillingAddress();
        $zone = null;

        if (null !== $billingAddress) {
            $zone = $this->zoneMatcher->match($billingAddress, Scope::TAX);
        }

        return $zone ?: $this->defaultTaxZoneProvider->getZone($order);
    }

    private function clearTaxes(BaseOrderInterface $order): void
    {
        $order->removeAdjustments(AdjustmentInterface::TAX_ADJUSTMENT);
        foreach ($order->getItems() as $item) {
            $item->removeAdjustmentsRecursively(AdjustmentInterface::TAX_ADJUSTMENT);
        }
        /** @var ShipmentInterface $shipment */
        foreach ($order->getShipments() as $shipment) {
            $shipment->removeAdjustments(AdjustmentInterface::TAX_ADJUSTMENT);
        }
    }
}
