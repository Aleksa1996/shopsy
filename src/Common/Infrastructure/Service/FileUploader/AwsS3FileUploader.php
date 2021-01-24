<?php

namespace App\Common\Infrastructure\Service\FileUploader;

use League\Flysystem\Filesystem;

class AwsS3FileUploader implements FileUploader
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * AwsS3FileUploader Constructor
     *
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @inheritDoc
     */
    public function upload($path, $file)
    {
        $this->filesystem->writeStream($path, $file);
        return true;
    }
}
