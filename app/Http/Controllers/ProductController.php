<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\ApiResponseTrait;


class ProductController extends Controller
{
    use ApiResponseTrait;

    protected ProductService $service;

    public function __construct(ProductService $service){
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(){
        return $this->success($this->service->list());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(){
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        return $this->success(
            $this->service->create($request->toArray()),
            'Produto criado com sucesso',
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product){
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        return $this->success(
            $this->service->update($id, $request->toArray()),
            'Produto atualizado com sucesso'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id){
        $this->service->delete($id);
        return $this->success(null, 'Produto removido', 204);
    }
}
