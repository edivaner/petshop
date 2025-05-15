<?php
namespace App\Services;

use App\Repositories\Contracts\TutorRepositoryInterface;
use App\Http\Resources\TutorResource;
use Illuminate\Container\Attributes\Cache;

class TutorService
{
    protected TutorRepositoryInterface $repositorio;
    protected CacheService $cacheService;

    public function __construct(TutorRepositoryInterface $repository, CacheService $cacheService){
        $this->cacheService = $cacheService;
        $this->repositorio = $repository;
    }

    public function list(){
        $cacheKey = 'tutors_list';
        $tutors = $this->cacheService->getCache($cacheKey); 

        if(!$tutors){
            $tutors = TutorResource::collection($this->repositorio->all());
            $this->cacheService->setMinutosDuracaoCache(2);
            $this->cacheService->setCache($cacheKey, $tutors);
        }

        return $tutors;
    }

    public function get(int $id){
        $tutor = new TutorResource( $this->cacheService->getCache('tutor_'.$id) ?? $this->repositorio->find($id));
        if($tutor){
            $this->cacheService->setCache('tutor_'.$id, $tutor);
        }
        return $tutor; 
    }

    public function create(array $data){
        $tutor = $this->repositorio->create($data);
        $this->cacheService->clearCache('tutors_list');
        return new TutorResource($tutor);
    }

    public function update(int $id, array $data){
        $tutor = $this->repositorio->update($id, $data);
        $this->cacheService->clearCache('tutor_'.$id);
        $this->cacheService->clearCache('tutors_list');
        return new TutorResource($tutor);
    }

    public function delete(int $id){
        $this->repositorio->delete($id);
        $this->cacheService->clearCache('tutor_'.$id);
        $this->cacheService->clearCache('tutors_list');
    }
}
?>