<?php


namespace App\Interfaces;


interface ProcessFileInterface
{
    /**
     * @param $filePath
     * @return mixed
     */
    public function process($filePath);
}
