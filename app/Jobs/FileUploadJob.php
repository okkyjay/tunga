<?php

namespace App\Jobs;

use App\Exceptions\User\CreateUserErrorException;
use App\Interfaces\User\UserRepositoryInterface;
use App\Traits\Helper;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FileUploadJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Helper;

    /**
     * @var
     */
    private $item;
    /**
     * @var UserRepositoryInterface
     */
    private $userRepo;


    /**
     * JsonJob constructor.
     * @param UserRepositoryInterface $userRepository
     * @param $item
     */
    public function __construct(array $item, UserRepositoryInterface $userRepository)
    {
        $this->item = $item;
        $this->userRepo = $userRepository;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->item as $item){
            (array)$item = $this->prepareForDB($item);
            try {
                $this->userRepo->createUser($item);
            }catch (\Exception $e){
                throw new CreateUserErrorException($e);
            }
        }
    }
}
