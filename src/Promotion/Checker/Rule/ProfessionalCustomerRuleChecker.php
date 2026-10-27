<?php

declare(strict_types=1);

namespace Arobases\SyliusProfessionalCustomerPlugin\Promotion\Checker\Rule;

use Arobases\SyliusProfessionalCustomerPlugin\Model\CustomerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Promotion\Checker\Rule\RuleCheckerInterface;
use Sylius\Component\Promotion\Model\PromotionSubjectInterface;

final class ProfessionalCustomerRuleChecker implements RuleCheckerInterface
{
    public const TYPE = 'professional_customer';

    public function isEligible(PromotionSubjectInterface $subject, array $configuration): bool
    {
        if (!$subject instanceof OrderInterface) {
            return false;
        }

        $customer = $subject->getCustomer();

        return
            $customer instanceof CustomerInterface &&
            true === $customer->isPro() &&
            true === $customer->isProVerified()
        ;
    }
}
