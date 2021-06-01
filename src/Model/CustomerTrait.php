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

}
