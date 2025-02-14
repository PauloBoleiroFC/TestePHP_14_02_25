<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProductRepository;

class ProductController extends Controller
{
    protected ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function list()
    {
        return response()->json($this->productRepository->all());
    }

    public function create(Request $request)
    {
        return response()->json($this->productRepository->create($request->all()));
    }

    public function show(int $id)
    {
        return response()->json($this->productRepository->find($id));
    }

    public function update(Request $request, int $id)
    {
        return response()->json($this->productRepository->update($id, $request->all()));
    }

    public function delete(int $id)
    {
        return response()->json(['deleted' => $this->productRepository->delete($id)]);
    }
}
