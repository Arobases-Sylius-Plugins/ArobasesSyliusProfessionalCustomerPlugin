<?php

declare(strict_types=1);

namespace Arobases\SyliusProfessionalCustomerPlugin\Form\Extension;

use Arobases\SyliusProfessionalCustomerPlugin\Model\CustomerInterface;
use Sylius\Bundle\CustomerBundle\Form\Type\CustomerType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\NotBlank;

final class CustomerTypeExtension extends AbstractTypeExtension
{
    public static function getExtendedTypes(): iterable
    {
        return [CustomerType::class];
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isPro', CheckboxType::class, [
                'label' => 'arobases_sylius_professional_customer.admin.is_pro',
                'required' => false,
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event): void {
                $customer = $event->getData();
                if (!$customer instanceof CustomerInterface || true !== $customer->isPro()) {
                    return;
                }

                $form = $event->getForm();
                $form
                    ->add('businessRegistrationNumber', TextType::class, [
                        'label' => 'arobases_sylius_professional_customer.form.customer_pro.business_registration_number.label',
                        'help' => 'arobases_sylius_professional_customer.form.customer_pro.business_registration_number.help',
                        'constraints' => [
                            new NotBlank(['groups' => ['sylius']]),
                        ],
                    ])
                    ->add('socialReason', TextType::class, [
                        'label' => 'arobases_sylius_professional_customer.form.customer_pro.socialReason',
                        'constraints' => [
                            new NotBlank(['groups' => ['sylius']]),
                        ],
                    ])
                    ->add('vatNumber', TextType::class, [
                        'label' => 'arobases_sylius_professional_customer.form.customer_pro.vatNumber',
                        'constraints' => [
                            new NotBlank(['groups' => ['sylius']]),
                        ],
                    ])
                ;

                // Once verified, a professional customer cannot be "unverified" from the back office
                if (true === $customer->isProVerified()) {
                    $form->add('isProVerified', CheckboxType::class, [
                        'label' => 'arobases_sylius_professional_customer.admin.is_pro_verified',
                        'disabled' => true,
                        'data' => true,
                    ]);
                } else {
                    $form->add('isProVerified', CheckboxType::class, [
                        'label' => 'arobases_sylius_professional_customer.admin.is_pro_verified',
                        'required' => false,
                    ]);
                }
            })
        ;
    }
}
