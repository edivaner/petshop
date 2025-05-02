<?php
namespace App\Services;

use App\Repositories\Contracts\AnimalRepositoryInterface;
use App\Http\Resources\AnimalResource;

class AnimalService
{
    protected AnimalRepositoryInterface $repositorio;
    protected CacheService $cacheService;

    public function __construct(AnimalRepositoryInterface $repositorio, CacheService $cacheService){
        $this->repositorio = $repositorio;
        $this->cacheService = $cacheService;
    }

    public function list(){
        return AnimalResource::collection($this->repositorio->all());
    }

    public function get(int $id){
        $produto = $this->cacheService->getCache('animal_'.$id) ?? $this->repositorio->find($id);
        if($produto){
            $this->cacheService->setCache('animal_'.$id, $produto);
        }
        return new AnimalResource($produto);
    }

    public function create(array $data){
        return new AnimalResource($this->repositorio->create($data));
    }

    public function update(int $id, array $data){
        return new AnimalResource($this->repositorio->update($id, $data));
    }

    public function delete(int $id){
        $this->cacheService->clearCache('animal_'.$id);
        return $this->repositorio->delete($id);
    }
}
?>