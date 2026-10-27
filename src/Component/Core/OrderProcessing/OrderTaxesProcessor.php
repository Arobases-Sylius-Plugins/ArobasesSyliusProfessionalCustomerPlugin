<?php

declare(strict_types=1);

namespace Arobases\SyliusProfessionalCustomerPlugin\Component\Core\OrderProcessing;

use Arobases\SyliusProfessionalCustomerPlugin\Model\ChannelInterface;
use Arobases\SyliusProfessionalCustomerPlugin\Model\CustomerInterface;
use Sylius\Component\Core\Model\AdjustmentInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Customer\Context\CustomerContextInterface;
use Sylius\Component\Order\Model\OrderInterface as BaseOrderInterface;
use Sylius\Component\Order\Processor\OrderProcessorInterface;
use Webmozart\Assert\Assert;

/**
 * Decorates the Sylius taxes processor: verified professional customers are not charged taxes
 * on channels where "considerTaxesForProfessionalCustomer" is enabled.
 */
final class OrderTaxesProcessor implements OrderProcessorInterface
{
    public function __construct(
        private OrderProcessorInterface $decoratedOrderTaxesProcessor,
        private CustomerContextInterface $customerContext,
    ) {
    }

    public function process(BaseOrderInterface $order): void
    {
        Assert::isInstanceOf($order, OrderInterface::class);

        if (!$order->canBeProcessed() || !$this->isTaxFree($order)) {
            $this->decoratedOrderTaxesProcessor->process($order);

            return;
        }

        $this->clearTaxes($order);
    }

    private function isTaxFree(OrderInterface $order): bool
    {
        $channel = $order->getChannel();
        if (!$channel instanceof ChannelInterface || true !== $channel->getConsiderTaxesForProfessionalCustomer()) {
            return false;
        }

        $customer = $this->customerContext->getCustomer();

        return
            $customer instanceof CustomerInterface &&
            true === $customer->isPro() &&
            true === $customer->isProVerified()
        ;
    }

    private function clearTaxes(OrderInterface $order): void
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
