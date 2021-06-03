<?php

declare(strict_types=1);

namespace Arobases\SyliusProfessionalCustomerPlugin\Model;

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
    protected $siret = null;

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
     * @return bool
     */
    public function isPro(): bool
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
    public function getSiret(): ?string
    {
        return $this->siret;
    }

    /**
     * @param ?string $siret
     */
    public function setSiret(?string $siret): void
    {
        $this->siret = $siret;
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
