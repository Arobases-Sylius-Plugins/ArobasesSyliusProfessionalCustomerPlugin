<?php

declare(strict_types=1);

namespace Arobases\SyliusProfessionalCustomerPlugin\Model;

use Arobases\SyliusProfessionalCustomerPlugin\Entity\KbisImage;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;

trait CustomerTrait
{
    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $isPro = false ;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $isProVerified = false ;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $businessRegistrationNumber = null;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
   protected $socialReason = null;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $vatNumber = null;

    /**
     * @ORM\Column(type="string", length=511, nullable=true)
     */
    protected ?string $filePath = null;
    protected ?File $file = null;

    /**
     * @return string|null
     */
    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    /**
     * @param string|null $filePath
     */
    public function setFilePath(string $filePath): void
    {
        $this->filePath = $filePath;
    }

    /**
     * @return File|null
     */
    public function getFile(): ?File
    {
        return $this->file;
    }

    /**
     * @param File|null $file
     */
    public function setFile(?File $file): void
    {
        $this->file = $file;
    }

    /**
     * @return bool
     */
    public function isPro(): ?bool
    {
        return $this->isPro;
    }

    /**
     * @param bool $isPro
     */
    public function setIsPro(bool $isPro): void
    {
        $this->isPro = $isPro;
    }

    /**
     * @return bool
     */
    public function isProVerified(): ?bool
    {
        return $this->isProVerified;
    }

    /**
     * @param bool $isProVerified
     */
    public function setIsProVerified(bool $isProVerified): void
    {
        $this->isProVerified = $isProVerified;
    }

    /**
     * @return string
     */
    public function getBusinessRegistrationNumber(): ?string
    {
        return $this->businessRegistrationNumber;
    }

    /**
     * @param ?string $businessRegistrationNumber
     */
    public function setBusinessRegistrationNumber(?string $businessRegistrationNumber): void
    {
        $this->businessRegistrationNumber = $businessRegistrationNumber;
    }

    /**
     * @return string
     */
    public function getVatNumber(): ?string
    {
        return $this->vatNumber;
    }

    /**
     * @param ?string $vatNumber
     */
    public function setVatNumber(?string $vatNumber): void
    {
        $this->vatNumber = $vatNumber;
    }

    /**
     * @return string
     */
    public function getSocialReason(): ?string
    {
        return $this->socialReason;
    }

    /**
     * @param ?string $socialReason
     */
    public function setSocialReason(?string $socialReason): void
    {
        $this->socialReason = $socialReason;
    }
}
