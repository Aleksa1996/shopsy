<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto;


use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Common\Infrastructure\Delivery\Symfony\RequestDto\RequestDto;
use App\Common\Infrastructure\Delivery\Symfony\Validator as CustomAssert;

/**
 * @CustomAssert\AtLeastOneValidField
 */
class UploadUserAvatarDto implements RequestDto
{
    /**
     * @var UploadedFile
     *
     * @Assert\Type("Symfony\Component\HttpFoundation\File\UploadedFile")
     * @Assert\NotBlank()
     * @Assert\File(
     *      maxSize = "1M"
     * )
     * @Assert\Image(
     *      detectCorrupted=true
     * )
     */
    public $avatar;
}
