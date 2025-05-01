<?php
namespace App\Services;

use App\Repositories\Contracts\AnimalRepositoryInterface;
use App\Http\Resources\AnimalResource;

class AnimalService
{
    protected AnimalRepositoryInterface $repositorio;

    public function __construct(AnimalRepositoryInterface $repositorio){
        $this->repositorio = $repositorio;
    }

    public function list(){
        return AnimalResource::collection($this->repositorio->all());
    }

    public function get(int $id){
        return new AnimalResource($this->repositorio->find($id));
    }

    public function create(array $data){
        return new AnimalResource($this->repositorio->create($data));
    }

    public function update(int $id, array $data){
        return new AnimalResource($this->repositorio->update($id, $data));
    }

    public function delete(int $id){
        return $this->repositorio->delete($id);
    }
}
?>