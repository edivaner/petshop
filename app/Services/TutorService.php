<?php
namespace App\Services;

use App\Repositories\Contracts\TutorRepositoryInterface;
use App\Http\Resources\TutorResource;

class TutorService
{
    protected TutorRepositoryInterface $repositorio;

    public function __construct(TutorRepositoryInterface $repository)
    {
        $this->repositorio = $repository;
    }

    public function list(){
        return TutorResource::collection($this->repositorio->all());
    }

    public function get(int $id){
        return new TutorResource($this->repositorio->find($id));
    }

    public function create(array $data){
        $tutor = $this->repositorio->create($data);
        return new TutorResource($tutor);
    }

    public function update(int $id, array $data){
        $tutor = $this->repositorio->update($id, $data);
        return new TutorResource($tutor);
    }

    public function delete(int $id){
        $this->repositorio->delete($id);
    }
}
?>