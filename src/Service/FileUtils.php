<?php


namespace App\Service;


class FileUtils
{
    private function __construct() {}

    public static function imageFileToBinary($file) {
        $strm = fopen($file->getRealPath(),'rb');
        return stream_get_contents($strm);
    }
}