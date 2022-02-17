<?php


namespace App\Helpers;


use App\Interfaces\ProcessFileInterface;
use App\Interfaces\User\UserRepositoryInterface;
use App\Traits\Helper;
use Illuminate\Support\Facades\Storage;
use Rodenastyle\StreamParser\StreamParser;
use Tightenco\Collect\Support\Collection;

class ProcessXmlFileq implements ProcessFileInterface
{
    use Helper;

    public $userInterface;

    public function __construct(UserRepositoryInterface $userInterface){
        $this->userInterface = $userInterface;
    }
    public function process($filePath)
    {
        $path = Storage::path($filePath);
        StreamParser::xml($path)->each(function (Collection $user){
            $user = json_decode($user, true);
            $filter = $this->filterCollectionData($user);
            if ($filter){
                $user = $this->prepareForDB($user);
                $this->userInterface->createUser($user);
            }
        });
        return true;
    }
}
