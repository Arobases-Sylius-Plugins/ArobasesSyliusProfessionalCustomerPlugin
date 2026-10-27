<?php

declare(strict_types=1);

namespace Arobases\SyliusProfessionalCustomerPlugin\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

trait CustomerTrait
{
    #[ORM\Column(type: 'boolean', nullable: true)]
    protected ?bool $isPro = false;

    #[ORM\Column(type: 'boolean', nullable: true)]
    protected ?bool $isProVerified = false;

    #[ORM\Column(type: 'boolean', nullable: true, options: ['default' => '0'])]
    protected ?bool $proVerifiedEmailSend = false;

    #[ORM\Column(type: 'text', nullable: true)]
    protected ?string $businessRegistrationNumber = null;

    #[ORM\Column(type: 'text', nullable: true)]
    protected ?string $socialReason = null;

    #[ORM\Column(type: 'text', nullable: true)]
    protected ?string $vatNumber = null;

    #[ORM\Column(type: 'string', length: 511, nullable: true)]
    protected ?string $filePath = null;

    protected ?File $file = null;

    public function isProVerifiedEmailSend(): bool
    {
        return true === $this->proVerifiedEmailSend;
    }

    public function setProVerifiedEmailSend(bool $proVerifiedEmailSend): void
    {
        $this->proVerifiedEmailSend = $proVerifiedEmailSend;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(?string $filePath): void
    {
        $this->filePath = $filePath;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file): void
    {
        $this->file = $file;
    }

    public function isPro(): ?bool
    {
        return $this->isPro;
    }

    public function setIsPro(bool $isPro): void
    {
        $this->isPro = $isPro;
    }

    public function isProVerified(): ?bool
    {
        return $this->isProVerified;
    }

    public function setIsProVerified(bool $isProVerified): void
    {
        $this->isProVerified = $isProVerified;
    }

    public function getBusinessRegistrationNumber(): ?string
    {
        return $this->businessRegistrationNumber;
    }

    public function setBusinessRegistrationNumber(?string $businessRegistrationNumber): void
    {
        $this->businessRegistrationNumber = $businessRegistrationNumber;
    }

    public function getVatNumber(): ?string
    {
        return $this->vatNumber;
    }

    public function setVatNumber(?string $vatNumber): void
    {
        $this->vatNumber = $vatNumber;
    }

    public function getSocialReason(): ?string
    {
        return $this->socialReason;
    }

    public function setSocialReason(?string $socialReason): void
    {
        $this->socialReason = $socialReason;
    }
}
