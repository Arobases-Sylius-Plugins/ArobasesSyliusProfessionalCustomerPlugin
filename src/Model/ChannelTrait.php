<?php

declare(strict_types=1);

namespace Arobases\SyliusProfessionalCustomerPlugin\Model;

use Doctrine\ORM\Mapping as ORM;

trait ChannelTrait
{
    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $considerTaxesForProfessionalCustomer = false ;

    /**
     * @return bool
     */
    public function getConsiderTaxesForProfessionalCustomer(): ?bool
    {
        return $this->considerTaxesForProfessionalCustomer;
    }

    /**
     * @param bool $considerTaxesForProfessionalCustomer
     */
    public function setConsiderTaxesForProfessionalCustomer(bool $considerTaxesForProfessionalCustomer): void
    {
        $this->considerTaxesForProfessionalCustomer = $considerTaxesForProfessionalCustomer;
    }

}
