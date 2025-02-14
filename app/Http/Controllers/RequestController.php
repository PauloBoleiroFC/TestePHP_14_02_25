<?php

namespace App\Http\Controllers;

use App\Mail\SendNotification;
use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;
use App\Repositories\RequestRepository;
use Illuminate\Support\Facades\Mail;

class RequestController extends Controller
{
    protected RequestRepository $requestRepository;
    protected CustomerRepository $customerRepository;

    /**
     * @param RequestRepository $requestRepository
     * @param CustomerRepository $customerRepository
     */
    public function __construct(RequestRepository $requestRepository, CustomerRepository $customerRepository)
    {
        $this->requestRepository = $requestRepository;
        $this->customerRepository = $customerRepository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        return response()->json($this->requestRepository->all());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {


        try{
            $requestCreated = $this->requestRepository->create($request->except('products'));

            // Attach Products
            if($requestCreated){
                $attachProducts =  response()->json([$this->requestRepository->attach($requestCreated->id, $request->products)]);

                if($attachProducts){

                    // Send new email
                    try{
                        $request = $this->requestRepository->find($requestCreated->id);
                        $customer = $this->customerRepository->find($requestCreated->customer_id);

                        $content = new \stdClass();
                        $content->id = $request->id;
                        $content->name = $customer->name;
                        $content->products = $request->products;
                        Mail::to($customer->email, $customer->name)->send(new SendNotification($content));
                        return response()->json(["success" => "ok"], 200);

                    }catch (\Exception $err){
                        return response()->json(['error' => $err->getMessage()], $err->getCode());
                    }
                    return response()->json(['error' => $err->getMessage()], $err->getCode());
                }

            }

        }catch (\Exception $e){
            return response()->json($e);
        }

        return response()->json($this->requestRepository->create($request->except('products')));
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        return response()->json($this->requestRepository->find($id));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {
        return response()->json($this->requestRepository->update($id, $request->all()));
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $id)
    {
        return response()->json(['deleted' => $this->requestRepository->delete($id)]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function attachProducts(Request $request, int $id)
    {
        return response()->json([$this->requestRepository->attach($id, [$request->request_id])]);
    }
}
