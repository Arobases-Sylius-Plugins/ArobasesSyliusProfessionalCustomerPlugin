<?php

declare(strict_types=1);

namespace Arobases\SyliusProfessionalCustomerPlugin\Form\Type\Customer;

use Sylius\Bundle\CoreBundle\Form\Type\Customer\CustomerSimpleRegistrationType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Component\Customer\Model\Customer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Unique;

final class CustomerProRegistrationType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options = []): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('firstName', TextType::class, [
                'label' => 'sylius.form.customer.first_name',
            ])
            ->add('lastName', TextType::class, [
                'label' => 'sylius.form.customer.last_name',
            ])
            ->add('phoneNumber', TextType::class, [
                'required' => false,
                'label' => 'sylius.form.customer.phone_number',
            ])
            ->add('subscribedToNewsletter', CheckboxType::class, [
                'required' => false,
                'label' => 'sylius.form.customer.subscribed_to_newsletter',
            ])
            ->add('siret', TextType::class, [
                'label' => 'arobases_sylius_professional_customer.form.customer_pro.siret',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Choose a password!'
                    ]),
                    new Length([
                        'min' => 14,
                        'max' => 14,
                    ]),
                    new Unique()
                ]
            ])
            ->add('socialReason', TextType::class, [
                'label' => 'arobases_sylius_professional_customer.form.customer_pro.socialReason',
            ])
            ->add('vatNumber', TextType::class, [
                'label' => 'arobases_sylius_professional_customer.form.customer_pro.vatNumber',
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                /** @var Customer $customer */
                 $customer = $event->getData();
                 $customer->setIsPro(true);
            });
        ;
    }

    public function getParent(): string
    {
        return CustomerSimpleRegistrationType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_customer_registration';
    }
}
