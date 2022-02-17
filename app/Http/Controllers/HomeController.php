<?php

namespace App\Http\Controllers;

use App\Helpers\ProcessFileUpload;
use App\Http\Requests\User\FileRequest;
use App\Interfaces\User\UserRepositoryInterface;
use App\Jobs\FileUploadJob;
use App\Traits\Helper;
use Illuminate\Support\Facades\Bus;

class HomeController extends Controller
{
    use Helper;
    public $processFileUpload;
    public $userInterface;

    public function __construct(ProcessFileUpload $processFileUpload, UserRepositoryInterface $userInterface){
        $this->processFileUpload = $processFileUpload;
        $this->userInterface = $userInterface;
    }

    public function store(FileRequest $request)
    {
        $filePath = $this->processFileUpload->processFile($request);
        if ($filePath){
            $batch  = Bus::batch([])->dispatch();
            $batch->add(new FileUploadJob($filePath));
            return back()->with(['success' => 'Jobs running....']);
        }

        return back()->with(['error' => 'No data to process....']);
    }
}
