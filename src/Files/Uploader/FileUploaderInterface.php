<?php

declare(strict_types=1);

namespace Arobases\SyliusProfessionalCustomerPlugin\Files\Uploader;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileUploaderInterface
{
    public function upload(UploadedFile $file): ?string;
}
