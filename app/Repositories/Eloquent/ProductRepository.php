<?php
namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    protected Product $model;

    public function __construct(Product $model){
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
        $product = $this->find($id);
        $product->update($data);
        return $product;
    }

    public function delete(int $id){
        $product = $this->find($id);
        return $product->delete();
    }
}
?>