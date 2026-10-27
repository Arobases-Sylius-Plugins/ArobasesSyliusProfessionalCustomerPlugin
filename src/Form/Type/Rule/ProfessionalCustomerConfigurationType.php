<?php

declare(strict_types=1);

namespace Arobases\SyliusProfessionalCustomerPlugin\Form\Type\Rule;

use Symfony\Component\Form\AbstractType;

final class ProfessionalCustomerConfigurationType extends AbstractType
{
    public function getBlockPrefix(): string
    {
        return 'app_promotion_rule_professional_customer_configuration';
    }
}
