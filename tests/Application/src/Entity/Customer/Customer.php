<?php

declare(strict_types=1);

namespace Tests\Arobases\SyliusProfessionalCustomerPlugin\Entity\Customer;

use Arobases\SyliusProfessionalCustomerPlugin\Model\CustomerInterface;
use Arobases\SyliusProfessionalCustomerPlugin\Model\CustomerTrait;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Customer as BaseCustomer;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_customer")
 */
class Customer extends BaseCustomer implements CustomerInterface
{
    use CustomerTrait;
}
