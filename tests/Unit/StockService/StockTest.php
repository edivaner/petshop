<?php

use App\Repositories\Contracts\StockRepositoryInterface;
use App\Services\CacheService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;
use App\Services\StockService;

class StockTest extends TestCase
{
    use RefreshDatabase;

    protected $stockService;
    protected $stockRepositoryMock;
    protected $cacheServiceMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->stockRepositoryMock = Mockery::mock(StockRepositoryInterface::class);
        $this->cacheServiceMock = $this->createMock(CacheService::class);
        $this->stockService = new StockService($this->stockRepositoryMock, $this->cacheServiceMock);
    }

    public function testListStocks()
    {
        $stockFake = (object) [
            'id' => 1,
            'product_id' => 1,
            'quantity' => 10,
            'price' => 100.00,
        ];

        $this->stockRepositoryMock
            ->shouldReceive('all')
            ->once()
            ->andReturn([$stockFake]);

        $response = $this->stockService->list();
        $this->assertNotEmpty($response);
        $this->assertEquals(1, $response->first()->product_id);
        $this->assertEquals(10, $response->first()->quantity);
        
    }

    public function testGetStock(){
        $stockFake = (object) [
            'id' => 1,
            'product_id' => 1,
            'quantity' => 10,
        ];

        $this->stockRepositoryMock
            ->shouldReceive('find')
            ->once()
            ->with(1)
            ->andReturn($stockFake);

        $response = $this->stockService->get(1);
        $this->assertEquals(1, $response->product_id);
        $this->assertEquals(10, $response->quantity);
    }

    public function testCreateStock(){
        $data = [
            'id' => 1,
            'product_id' => 1,
            'quantity' => 10,
        ];

        $this->stockRepositoryMock
            ->shouldReceive('create')
            ->once()
            ->with($data)
            ->andReturn((object) $data);

        $response = $this->stockService->create($data);
        $this->assertEquals($data['product_id'], $response->product_id);
        $this->assertEquals($data['quantity'], $response->quantity);
    }

    public function testUpdateStock(){
        $data = [
            'product_id' => 1,
            'quantity' => 25,
        ];
        $stockFake = (object) [
            'id' => 1,
            'product_id' => 1,
            'quantity' => 25,
        ];

        $this->stockRepositoryMock
            ->shouldReceive('update')
            ->once()
            ->with(1, $data)
            ->andReturn($stockFake);

        $response = $this->stockService->update(1, $data);
        $this->assertEquals($data['product_id'], $response->product_id);
        $this->assertEquals($data['quantity'], $response->quantity);
    }

    public function testDeleteStock()
    {
        $this->stockRepositoryMock
            ->shouldReceive('delete')
            ->once()
            ->with(1)
            ->andReturn(true);

        $response = $this->stockService->delete(1);
        $this->assertTrue($response);
    }
}
?>