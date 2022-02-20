<?php

namespace App\Helpers;
use App\Classes\ProcessRegisterHookHelper;
use App\Interfaces\User\UserRepositoryInterface;

class FileParser
{
    public $userInterface;
    public $extension;

    public function __construct(UserRepositoryInterface $userInterface, ProcessRegisterHookHelper $processRegisterHookHelper){
        $this->userInterface = $userInterface;
        $processRegisterHookHelper->processRegisteredHooks();
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

    public function processFileBYExtension($filePath, $extension)
    {
        if (!$extension){
            $f = explode('.', $filePath);
            $extension = $f[count($f) - 1];
            $this->extension = $extension;
        }
        try {
            if (method_exists($this, $extension)){
                return $this->$extension($filePath);
            }else{
                return false;
            }
        }catch (\Exception $exception){

        }
    }
}
