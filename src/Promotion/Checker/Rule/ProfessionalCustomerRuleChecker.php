<?php

namespace Arobases\SyliusProfessionalCustomerPlugin\Promotion\Checker\Rule;

use Sylius\Component\Promotion\Checker\Rule\RuleCheckerInterface;
use Sylius\Component\Promotion\Model\PromotionSubjectInterface;

class ProfessionalCustomerRuleChecker implements RuleCheckerInterface
{
    const TYPE = 'professional_customer';

    /**
     * {@inheritdoc}
     */
    public function isEligible(PromotionSubjectInterface $subject, array $configuration): bool
    {
        if($subject->getCustomer() !== null)
             return $subject->getCustomer()->isPro();
        else
            return false;
    }
}