<?php

declare(strict_types=1);

namespace Arobases\SyliusProfessionalCustomerPlugin\EventListener;

use Arobases\SyliusProfessionalCustomerPlugin\Files\Uploader\FileUploaderInterface;
use Arobases\SyliusProfessionalCustomerPlugin\Model\CustomerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class CustomerProKbisListener
{
    public function __construct(
        private FileUploaderInterface $kbisUploader,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function preCreate(GenericEvent $event): void
    {
        $customer = $event->getSubject();
        if (!$customer instanceof CustomerInterface) {
            return;
        }

        $file = $customer->getFile();
        if (!$file instanceof UploadedFile) {
            return;
        }

        $customer->setFilePath($this->kbisUploader->upload($file));

        $this->entityManager->persist($customer);
        $this->entityManager->flush();
    }
}
