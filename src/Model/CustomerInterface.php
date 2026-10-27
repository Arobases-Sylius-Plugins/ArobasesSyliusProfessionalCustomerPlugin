<?php

declare(strict_types=1);

namespace Arobases\SyliusProfessionalCustomerPlugin\Model;

use Symfony\Component\HttpFoundation\File\File;

interface CustomerInterface
{
    public function isPro(): ?bool;

    public function setIsPro(bool $isPro): void;

    public function isProVerified(): ?bool;

    public function setIsProVerified(bool $isProVerified): void;

    public function isProVerifiedEmailSend(): bool;

    public function setProVerifiedEmailSend(bool $proVerifiedEmailSend): void;

    public function getBusinessRegistrationNumber(): ?string;

    public function setBusinessRegistrationNumber(?string $businessRegistrationNumber): void;

    public function getVatNumber(): ?string;

    public function setVatNumber(?string $vatNumber): void;

    public function getSocialReason(): ?string;

    public function setSocialReason(?string $socialReason): void;

    public function getFilePath(): ?string;

    public function setFilePath(?string $filePath): void;

    public function getFile(): ?File;

    public function setFile(?File $file): void;
}
