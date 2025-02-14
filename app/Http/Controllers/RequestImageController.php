<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use App\Repositories\RequestRepository;

class RequestImageController extends Controller
{
    protected RequestRepository $requestRepository;

    /**
     * @param RequestRepository $requestRepository
     */
    public function __construct(RequestRepository $requestRepository)
    {
        $this->requestRepository = $requestRepository;
    }

    /**
     * @param UploadRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImage(UploadRequest $request)
    {


        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            return response()->json(['success' => true, 'path' => $path]);
        }

        return response()->json(['success' => false, 'message' => 'No image sent']);
    }


}
