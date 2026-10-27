<?php

declare(strict_types=1);

namespace Arobases\SyliusProfessionalCustomerPlugin\Files\Uploader;

use Arobases\SyliusProfessionalCustomerPlugin\Files\Provider\FileNameProvider;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class FileUploader implements FileUploaderInterface
{
    public function __construct(
        protected Filesystem $filesystem,
        protected FileNameProvider $fileNameProvider,
        protected string $baseUploadPath,
        protected string $complementUploadPath,
    ) {
    }

    public function upload(UploadedFile $file): ?string
    {
        $uploadPath = $this->baseUploadPath . $this->complementUploadPath;
        $fileName = $this->fileNameProvider->getFileName($file, $uploadPath);

        try {
            $this->filesystem->copy((string) $file->getRealPath(), $uploadPath . $fileName);
        } catch (IOExceptionInterface) {
            return null;
        }

        return $this->complementUploadPath . $fileName;
    }
}
