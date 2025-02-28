<?php

namespace App\Exceptions;

use Exception;

class ImageUploadException extends Exception
{
    public function __construct($message = "Görsel yüklenirken bir hata oluştu!", $code = 500)
    {
        parent::__construct($message, $code);
    }

    public function report()
    {
        // ImageUploadException ile yakalanan hataları loglamayı devre dışı bırakmak için report metodunu override ediyoruz.
    }
}
