<?php

declare(strict_types=1);

namespace Arobases\SyliusProfessionalCustomerPlugin\Model;

use Doctrine\ORM\Mapping as ORM;

trait ChannelTrait
{
    #[ORM\Column(type: 'boolean', nullable: true)]
    protected ?bool $considerTaxesForProfessionalCustomer = false;

    public function getConsiderTaxesForProfessionalCustomer(): ?bool
    {
        return $this->considerTaxesForProfessionalCustomer;
    }

    public function setConsiderTaxesForProfessionalCustomer(bool $considerTaxesForProfessionalCustomer): void
    {
        $this->considerTaxesForProfessionalCustomer = $considerTaxesForProfessionalCustomer;
    }
}
