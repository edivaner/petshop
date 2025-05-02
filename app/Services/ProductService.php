<?php
namespace App\Services;

use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Http\Resources\ProductResource;

class ProductService
{
    protected ProductRepositoryInterface $productRepositorio;
    protected CacheService $cacheService;

    public function __construct(ProductRepositoryInterface $repo, CacheService $cacheService){
        $this->cacheService = $cacheService;
        $this->productRepositorio = $repo;
    }

    public function list(){
        return ProductResource::collection($this->productRepositorio->all());
    }

    public function get(int $id){
        $produto = $this->cacheService->getCache('product_'.$id) ?? $this->productRepositorio->find($id);
        if($produto){
            $this->cacheService->setCache('product_'.$id, $produto);
        }
        return new  ProductResource($produto);
    }

    public function create(array $data){
        return new ProductResource($this->productRepositorio->create($data));
    }

    public function update(int $id, array $data){
        return new ProductResource($this->productRepositorio->update($id, $data));
    }

    public function delete(int $id){
        $this->cacheService->clearCache('product_'.$id);
        return $this->productRepositorio->delete($id);
    }
}
?>