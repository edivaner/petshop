<?php

namespace App\Http\Controllers;

use App\Models\Tutor;
use Illuminate\Http\Request;
use App\Services\TutorService;
use App\Http\Requests\StoreTutorRequest;
use App\Http\Requests\UpdateTutorRequest;
use App\Http\Controllers\Traits\ApiResponseTrait;


class TutorController extends Controller
{
    use ApiResponseTrait;

    protected TutorService $service;

    public function __construct(TutorService $service){
        $this->service = $service;
    }

    public function index(){
        return $this->success($this->service->list());
    }

    public function create()
    {
        //
    }

    public function store($request){
        return $this->success(
            $this->service->create($request),
            'Tutor criado com sucesso',
            201
        );
    }

    public function show(int $id){
        return $this->success($this->service->get($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tutor $tutor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($request, int $id)
    {
        return $this->success(
            $this->service->update($id, $request),
            'Tutor atualizado com sucesso'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->service->delete($id);
        return $this->success(null, 'Tutor removido', 204);
    }
}
