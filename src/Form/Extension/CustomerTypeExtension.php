<?php

declare(strict_types=1);

namespace Arobases\SyliusProfessionalCustomerPlugin\Form\Extension;

use Sylius\Bundle\CustomerBundle\Form\Type\CustomerType;
use Sylius\Component\Customer\Model\Customer;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\NotBlank;

class CustomerTypeExtension extends AbstractTypeExtension {

    public static function getExtendedTypes(): array
    {
        return [CustomerType::class];
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isPro', CheckboxType::class, [
                'label' => 'arobases_sylius_professional_customer.admin.is_pro',
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                /** @var Customer $customer */
                $form = $event->getForm();
                $customer = $event->getData();
                if (true === $customer->isPro()){
                    $form->add('siret', TextType::class, [
                        'label' => 'arobases_sylius_professional_customer.form.customer_pro.siret',
                        'constraints' => [
                            new NotBlank([
                                'message' => 'Choose a password!'
                            ]),
                        ]
                    ]);
                    $form->add('socialReason', TextType::class, [
                        'label' => 'arobases_sylius_professional_customer.form.customer_pro.socialReason',
                    ]);
                    $form->add('vatNumber', TextType::class, [
                        'label' => 'arobases_sylius_professional_customer.form.customer_pro.vatNumber',
                    ]);
                    $form->add('isProVerified', CheckboxType::class, [
                        'label' => 'arobases_sylius_professional_customer.admin.is_pro_verified',
                    ]);
                }
            });
    }
}
















