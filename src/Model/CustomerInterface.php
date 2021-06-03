<?php

declare(strict_types=1);

namespace Arobases\SyliusProfessionalCustomerPlugin\Model;

interface CustomerInterface
{
    public function isPro(): bool;

    public function setIsPro(bool $isPro): void;

    public function isProVerified(): ?bool;

    public function setIsProVerified(bool $isProVerified): void;

    public function getBusinessRegistrationNumber(): ?string;

    public function setBusinessRegistrationNumber(string $businessRegistrationNumber): void;

    public function getVatNumber(): ?string;

    public function setVatNumber(?string $vatNumber): void;

    public function getSocialReason(): ?string;

    public function setSocialReason(?string $socialReason): void;
}