<?php

declare(strict_types=1);

namespace Arobases\SyliusProfessionalCustomerPlugin\Files\Uploader;

use Arobases\SyliusProfessionalCustomerPlugin\Files\Provider\FileNameProvider;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;


abstract class FileUploader implements FileUploaderInterface
{
    protected Filesystem $filesystem;
    protected FileNameProvider $fileNameProvider;
    protected string $baseUploadPath;
    protected string $complementUploadPath;


    public function __construct(
        Filesystem $filesystem,
        FileNameProvider $fileNameProvider,
        string $baseUploadPath,
        string $complementUploadPath
    ) {
        $this->filesystem = $filesystem;
        $this->fileNameProvider = $fileNameProvider;

        $this->baseUploadPath = $baseUploadPath;
        $this->complementUploadPath = $complementUploadPath;
    }

    public function upload(UploadedFile $file): ?string
    {
        $uploadPath = $this->baseUploadPath . $this->complementUploadPath;
        try {
            $fileName = $this->fileNameProvider->getFileName($file, $uploadPath);
            $this->filesystem->copy($file->getRealPath(), $uploadPath . $fileName);
        }
        catch(\Exception $exception){

        }
        return $this->complementUploadPath.$fileName;
    }
}
