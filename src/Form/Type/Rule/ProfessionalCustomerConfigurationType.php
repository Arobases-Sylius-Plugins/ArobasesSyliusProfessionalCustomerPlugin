<?php

namespace Arobases\SyliusProfessionalCustomerPlugin\Form\Type\Rule;

use Symfony\Component\Form\AbstractType;

class ProfessionalCustomerConfigurationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_promotion_rule_professional_customer_configuration';
    }
}