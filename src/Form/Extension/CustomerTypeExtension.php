<?php

declare(strict_types=1);

namespace Arobases\SyliusProfessionalCustomerPlugin\Form\Extension;

use Sylius\Bundle\CustomerBundle\Form\Type\CustomerType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

class CustomerTypeExtension extends AbstractTypeExtension {

    public static function getExtendedTypes(): array
    {
        return [CustomerType::class];
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('isPro', CheckboxType::class, [
            'label' => 'arobases_sylius_professional_customer.admin.is_pro',
        ]);
    }
}
















