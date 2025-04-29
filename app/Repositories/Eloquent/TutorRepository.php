<?php
namespace App\Repositories\Eloquent;

use App\Models\Tutor;
use App\Repositories\Contracts\TutorRepositoryInterface;

class TutorRepository implements TutorRepositoryInterface
{
    protected Tutor $model;

    public function __construct(Tutor $model){
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
        $record = $this->find($id);
        $record->update($data);
        return $record;
    }
    public function delete(int $id){
        $record = $this->find($id);
        return $record->delete();
    }
}
?>