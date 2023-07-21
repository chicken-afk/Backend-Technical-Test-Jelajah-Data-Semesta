<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ImageUpload
{
    protected $image;
    /**Default Maxsimal Size is 1MB */
    protected $size = 1000000;

    protected $imageExtention;

    public $acceptable_mimetypes = [
        'image/jpeg',
        'image/jpg',
        'image/png',
        'application/pdf',
        'application/octet-stream'
    ];

    public function __construct($image = null)
    {
        $this->image = $image;
    }


    /**
     * Set Image
     *
     * @param [type] $image
     * @return void
     */

    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Set Maxsimal Size
     *
     * @param [integer] $size
     * @return void
     */

    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * Set Image Extention
     */

    public function getImageExtention()
    {
        $file = base64_decode($this->image);
        $f = finfo_open();
        $mime_type = finfo_buffer($f, $file, FILEINFO_MIME_TYPE);
        return $mime_type;
    }


    /**
     * String acceptable extention
     */

    public function getExtention()
    {
        $string = "";
        foreach ($this->acceptable_mimetypes as $value) {
            $parts = explode('/', $value);
            $extension = $parts[1];
            $string = $string . ", " . $extension;
        }
        return $string;
    }

    /**
     * Validate Size Image
     *
     * @param
     * @return boolean
     */

    public function validateSize()
    {
        $size = strlen(base64_decode($this->image));
        if ($size > $this->size) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Validate image Extention
     *
     * @param
     * @return boolean
     */

    public function validateExtention()
    {
        $file = base64_decode($this->image);
        $f = finfo_open();
        $mime_type = finfo_buffer($f, $file, FILEINFO_MIME_TYPE);

        if (!in_array($mime_type, $this->acceptable_mimetypes)) {
            return false;
        } else {
            return true;
        }
    }


    /**
     * Validate if base64 can be decoded
     *
     * @param
     * @return boolean
     */

    public function isDecoded()
    {
        $file = base64_decode($this->image);
        if ($file === false) {
            return false;
        } else {
            return true;
        }
    }


    public function save($location)
    {
        /**Image base64 to image */
        if (strpos($this->image, "base64,") == true) {
            // Mencari posisi indeks "base64,"
            $startIndex = strpos($this->image, "base64,") + strlen("base64,");

            // Mengambil string setelah posisi indeks "base64,"
            $this->image = substr($this->image, $startIndex);
        }
        $file = base64_decode($this->image);
        $uniqueFileName = Str::random(20);
        try {
            // code 
            // if something is not as expected 
            // throw exception using the "throw" keyword 
            // code, it won't be executed if the above exception is thrown 
            Storage::disk('local')->put("public/$location/" . $uniqueFileName . '.jpg', $file);
            return config('app.url') . "/storage/$location/" . $uniqueFileName . '.jpg';
        } catch (Exception $e) {
            // exception is raised and it'll be handled here 
            // $e->getMessage() contains the error message 
            return false;
        }
    }
}
