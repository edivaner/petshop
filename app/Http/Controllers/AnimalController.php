<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use App\Services\AnimalService;
use App\Http\Requests\StoreAnimalRequest;
use App\Http\Requests\UpdateAnimalRequest;
use App\Http\Controllers\Traits\ApiResponseTrait;

class AnimalController extends Controller
{
    use ApiResponseTrait;
    protected AnimalService $service;

    public function __construct(AnimalService $service)
    {
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
        // dd($request->all());
        return $this->success(
            $this->service->create($request->toArray()),
            'Animal criado com sucesso',
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id){
        return $this->success($this->service->get($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Animal $animal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id){
        return $this->success(
            $this->service->update($id, $request->validated()),
            'Animal atualizado com sucesso'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id){
        $this->service->delete($id);
        return $this->success(null, 'Animal removido', 204);
    }
}
