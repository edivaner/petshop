<?php
namespace App\Services;

use App\Http\Resources\StockResource;
use App\Repositories\Contracts\StockRepositoryInterface;

class StockService
{
    protected StockRepositoryInterface $repository;
    protected CacheService $cacheService;

    public function __construct(StockRepositoryInterface $repository, CacheService $cacheService){
        $this->repository = $repository;
        $this->cacheService = $cacheService;
    }

    public function list(){
        $cacheKey = 'stocks_all';
        $stocks = $this->cacheService->getCache($cacheKey);

        if (!$stocks) {
            $stocks = StockResource::collection($this->repository->all());
            $this->cacheService->setCache($cacheKey, $stocks);
        }

        return $stocks;
    }

    public function get(int $id){
        $cacheKey = 'stock_' . $id;
        $stock = $this->cacheService->getCache($cacheKey) ?? $this->repository->find($id);

        if ($stock) {
            $this->cacheService->setCache($cacheKey, $stock);
        }

        return new StockResource($stock);
    }

    public function create(array $data){
        $stock = $this->repository->create($data);
        $this->cacheService->clearCache('stocks_all');
        return new StockResource($stock);
    }

    public function update(int $id, array $data){
        $stock = $this->repository->update($id, $data);
        $this->cacheService->clearCache('stock_' . $id);
        $this->cacheService->clearCache('stocks_all');
        return new StockResource($stock);
    }

    public function delete(int $id){
        $this->cacheService->clearCache('stock_' . $id);
        $this->cacheService->clearCache('stocks_all');
        return $this->repository->delete($id);
    }
}
?>