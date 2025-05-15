<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use App\Services\StockService;
use App\Http\Controllers\Traits\ApiResponseTrait;

class StockController extends Controller
{
    use ApiResponseTrait;

    protected StockService $service;

    public function __construct(StockService $service){
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        return $this->success($this->service->create($request->toArray()));
    }

    /**
     * Display the specified resource.
     */
    public function show($id){
        return $this->success($this->service->get($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id){
        return $this->success($this->service->update($id, $request->toArray()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
        return $this->success($this->service->delete($id));
    }
}
