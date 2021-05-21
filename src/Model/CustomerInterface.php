<?php

declare(strict_types=1);

namespace Arobases\SyliusProfessionalCustomerPlugin\Model;

interface CustomerInterface
{
    public function isPro(): bool;

    public function setIsPro(bool $isPro): void;
}