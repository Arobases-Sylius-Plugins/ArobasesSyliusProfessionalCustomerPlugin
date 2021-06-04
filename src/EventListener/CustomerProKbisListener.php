<?php

declare(strict_types=1);

namespace Arobases\SyliusProfessionalCustomerPlugin\EventListener;

use Arobases\SyliusProfessionalCustomerPlugin\Files\Uploader\KbisUploader;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class CustomerProKbisListener {

    private KbisUploader  $kbisUploader;
    private EntityManager $em;

    /**
     * @param KbisUploader $kbisUploader
     * @param EntityManager $em
     */
    public function __construct(KbisUploader $kbisUploader, EntityManager $em)
    {
        $this->kbisUploader = $kbisUploader;
        $this->em = $em;
    }

    public function preCreate(GenericEvent $event): void
    {

        $file = $event->getSubject()->getFile();

        if ($file !== null) {
            $pathFile = $this->kbisUploader->upload($file);

            $customer = $event->getSubject();
            $customer->setFilePath($pathFile);

            $this->em->persist($customer);
            $this->em->flush();
        }

    }

    public function preUpdate(GenericEvent $event): void{

        $file = $event->getSubject()->getFile();

        if($file === null)
            throw new BadRequestHttpException();

        $pathFile = $this->kbisUploader->upload($file);
        $customer = $event->getSubject();
        $customer->setFilePath($pathFile);

        $this->em->persist($customer);
        $this->em->flush();
    }
}
