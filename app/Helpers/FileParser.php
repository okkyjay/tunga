<?php

namespace App\Helpers;

use App\Interfaces\User\UserRepositoryInterface;

class FileParser
{
    public $userInterface;

    public function __construct(UserRepositoryInterface $userInterface){
        $this->userInterface = $userInterface;
    }
    public function json($filePath)
    {
        return (new ProcessJsonFile($this->userInterface))->process($filePath);
    }
    public function xml($filePath)
    {
        return (new ProcessXmlFileq($this->userInterface))->process($filePath);
    }
    public function csv($filePath)
    {
        return (new ProcessCSVlFile($this->userInterface))->process($filePath);
    }
}
