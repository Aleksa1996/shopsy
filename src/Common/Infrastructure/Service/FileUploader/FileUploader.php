<?php

namespace App\Common\Infrastructure\Service\FileUploader;

interface FileUploader
{
    /**
     * @param string $path - full path where to upload together with filename and extenstion
     * @param resource $file
     *
     * @return bool
     */
    public function upload($path, $file);
}
