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
        $cacheKey = 'products_all';
        $products = $this->cacheService->getCache($cacheKey);

        if (!$products) {
            $products = ProductResource::collection($this->productRepositorio->all());
            $this->cacheService->setMinutosDuracaoCache(2);
            $this->cacheService->setCache($cacheKey, $products);
        }

        return $products;
    }

    public function get(int $id){
        $produto = $this->cacheService->getCache('product_'.$id) ?? $this->productRepositorio->find($id);
        if($produto){
            $this->cacheService->setCache('product_'.$id, $produto);
        }
        return new  ProductResource($produto);
    }

    public function create(array $data){
        $this->cacheService->clearCache('products_all');
        return new ProductResource($this->productRepositorio->create($data));
    }

    public function update(int $id, array $data){
        $this->cacheService->clearCache('products_all');
        return new ProductResource($this->productRepositorio->update($id, $data));
    }

    public function delete(int $id){
        $this->cacheService->clearCache('product_'.$id);
        $this->cacheService->clearCache('products_all');
        return $this->productRepositorio->delete($id);
    }
}
?>