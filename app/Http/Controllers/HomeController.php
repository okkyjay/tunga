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
        $items = $this->processFileUpload->processFile($request);
        if (count($items) > 0){
            $items = array_chunk($items, 500);
            $batch  = Bus::batch([])->dispatch();
            foreach($items as $item){
                $batch->add(new FileUploadJob((array)$item, $this->userInterface));
            }
            return back()->with(['success' => 'Jobs running....']);
        }

        return back()->with(['success' => 'No data to process....']);
    }
}
