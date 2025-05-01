<?php
namespace App\Repositories\Eloquent;

use App\Models\Animal;
use App\Repositories\Contracts\AnimalRepositoryInterface;

class AnimalRepository implements AnimalRepositoryInterface
{
    protected Animal $model;

    public function __construct(Animal $model){
        $this->model = $model;
    }

    public function all(){
        return $this->model->all();
    }

    public function find(int $id){
        return $this->model->findOrFail($id);
    }

    public function create(array $data){
        return $this->model->create($data);
    }

    public function update(int $id, array $data){
        $animal = $this->find($id);
        $animal->update($data);
        return $animal;
    }

    public function delete(int $id){
        $animal = $this->find($id);
        return $animal->delete();
    }
}
?>