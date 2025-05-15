<?php
namespace App\Repositories\Eloquent;

use App\Models\Stock;
use App\Repositories\Contracts\StockRepositoryInterface;

class StockRepository implements StockRepositoryInterface
{
    public function all(){
        return Stock::all();
    }

    public function find(int $id){
        return Stock::find($id);
    }

    public function create(array $data){
        return Stock::create($data);
    }

    public function update(int $id, array $data){
        $stock = Stock::findOrFail($id);
        $stock->update($data);
        return $stock;
    }

    public function delete(int $id){
        return Stock::destroy($id);
    }
}
?>