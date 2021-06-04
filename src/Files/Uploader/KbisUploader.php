<?php
declare(strict_types=1);

namespace Arobases\SyliusProfessionalCustomerPlugin\Files\Uploader;

use Arobases\SyliusProfessionalCustomerPlugin\Files\Provider\FileNameProvider;
use Symfony\Component\Filesystem\Filesystem;

final class KbisUploader extends FileUploader {

    public function __construct(Filesystem $fileSystem, FileNameProvider $fileNameProvider, string $partnerBaseUploadPath, string $partnerComplementUploadPath )
    {
        parent::__construct($fileSystem, $fileNameProvider, $partnerBaseUploadPath, $partnerComplementUploadPath);
    }
}
