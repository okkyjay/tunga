<?php


namespace App\Helpers;


use App\Interfaces\ProcessFileInterface;
use App\Interfaces\User\UserRepositoryInterface;
use App\Traits\Helper;
use Tightenco\Collect\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Rodenastyle\StreamParser\StreamParser;

/**
 * Class ProcessJsonFile
 * @package App\Helpers
 */
class ProcessJsonFile implements ProcessFileInterface
{
    use Helper;

    /**
     * @var UserRepositoryInterface
     */
    public $userInterface;

    /**
     * ProcessJsonFile constructor.
     * @param UserRepositoryInterface $userInterface
     */
    public function __construct(UserRepositoryInterface $userInterface){
        $this->userInterface = $userInterface;
    }

    /**
     * @param $filePath
     * @return bool
     */
    public function process($filePath)
    {
        $path = Storage::path($filePath);
        StreamParser::json($path)->each(function (Collection $user){
            $user = json_decode($user, true);
            $filter = $this->filterCollectionData($user);
            if ($filter){
                $user = $this->prepareForDB($user);
                $this->userInterface->createUser($user);
            }
        });
        return  true;
    }
}
