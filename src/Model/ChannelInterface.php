<?php

declare(strict_types=1);

namespace Arobases\SyliusProfessionalCustomerPlugin\Model;

interface ChannelInterface
{
    public function getConsiderTaxesForProfessionalCustomer(): ?bool;

    public function setConsiderTaxesForProfessionalCustomer(bool $considerTaxesForProfessionalCustomer): void;
}