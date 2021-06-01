<?php

declare(strict_types=1);

namespace Arobases\SyliusProfessionalCustomerPlugin\Form\Extension;

use Sylius\Bundle\ChannelBundle\Form\Type\ChannelType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

class ChannelTypeExtension extends AbstractTypeExtension {

    public static function getExtendedTypes(): array
    {
        return [ChannelType::class];
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('considerTaxesForProfessionalCustomer', CheckboxType::class, [
            'label' => 'arobases_sylius_professional_customer.admin.consider_taxes_for_professional_customer',
        ]);
    }
}
















