<?php

declare(strict_types=1);

namespace Tests\Arobases\SyliusProfessionalCustomerPlugin\Entity\Channel;

use Arobases\SyliusProfessionalCustomerPlugin\Model\ChannelInterface;
use Arobases\SyliusProfessionalCustomerPlugin\Model\ChannelTrait;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Channel as BaseChannel;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_channel")
 */
class Channel extends BaseChannel implements ChannelInterface
{
    use ChannelTrait;
}