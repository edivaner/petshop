<?php
namespace Tests\Unit\ProductService;

use App\Http\Resources\ProductResource;
use Tests\TestCase;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Services\CacheService;
use App\Services\ProductService;

class ProductTest extends TestCase
{
    protected $produtoService;
    protected $produtoRepositorioMock;
    protected $cacheServiceMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->produtoRepositorioMock = $this->createMock(ProductRepositoryInterface::class);
        $this->cacheServiceMock = $this->createMock(CacheService::class);
        $this->produtoService = new ProductService($this->produtoRepositorioMock, $this->cacheServiceMock);
    }

    public function testCreateProduct()
    {
        $data = [
            'name' => 'Raça de Cachorro',	
            'price' => 80.00,
            'description' => 'Ração para cachorros de grande porte',
            'stock_minimum' => 10,
        ];
        $this->produtoRepositorioMock->expects($this->once())
            ->method('create')
            ->with($data)
            ->willReturn(new Product($data));
        $produto = $this->produtoService->create($data);

        $this->assertInstanceOf(ProductResource::class, $produto);
        $this->assertEquals($data['name'], $produto->name);
        $this->assertEquals($data['price'], $produto->price);
    }

    public function testGetProduct()
    {
        $productId = 1;
        $productData = [
            'id' => $productId,
            'name' => 'Raça de Cachorro',	
            'price' => 80.00,
            'description' => 'Ração para cachorros de grande porte',
            'stock_minimum' => 10,
        ];
        $this->cacheServiceMock->expects($this->once())
            ->method('getCache')
            ->with('product_'.$productId)
            ->willReturn(null);

        $this->cacheServiceMock->expects($this->once())
            ->method('setCache')
            ->with('product_'.$productId, new Product($productData));

        $this->produtoRepositorioMock->expects($this->once())
            ->method('find')
            ->with($productId)
            ->willReturn(new Product($productData));
        $produto = $this->produtoService->get($productId);

        $this->assertInstanceOf(ProductResource::class, $produto);
        $this->assertEquals($productData['name'], $produto->name);
        $this->assertEquals($productData['price'], $produto->price);
    }
    public function testUpdateProduct()
    {
        $productId = 1;
        $data = [
            'name' => 'Raça de Cachorro',	
            'price' => 80.00,
            'description' => 'Ração para cachorros de grande porte',
            'stock_minimum' => 10,
        ];
        $this->produtoRepositorioMock->expects($this->once())
            ->method('update')
            ->with($productId, $data)
            ->willReturn(new Product($data));
        $produto = $this->produtoService->update($productId, $data);

        $this->assertInstanceOf(ProductResource::class, $produto);
        $this->assertEquals($data['name'], $produto->name);
        $this->assertEquals($data['price'], $produto->price);
    }
    public function testDeleteProduct()
    {
        $productId = 1;
        $this->produtoRepositorioMock->expects($this->once())
            ->method('delete')
            ->with($productId)
            ->willReturn(true);
        $this->cacheServiceMock->expects($this->once())->method('clearCache')->with('product_'.$productId);
        $result = $this->produtoService->delete($productId);

        $this->assertTrue($result);
    }
    
    public function testListProducts()
    {
        $productData = [
            [
                'id' => 1,
                'name' => 'Raça de Cachorro', 
                'price' => 80.00, 
                'description' => 'Ração para cachorros de grande porte', 
                'stock_minimum' => 10
            ],
            [
                'id' => 2, 
                'name' => 'Ração para Gatos', 
                'price' => 50.00, 
                'description' => 
                'Ração para gatos de pequeno porte', 
                'stock_minimum' => 5
            ],
        ];
        $this->produtoRepositorioMock->expects($this->once())
            ->method('all')
            ->willReturn(
                    array_map(fn($data) => new Product($data), $productData)
                );
        $produtos = $this->produtoService->list();

        $this->assertCount(2, $produtos);
        $this->assertInstanceOf(ProductResource::class, $produtos[0]);
        $this->assertEquals($productData[0]['name'], $produtos[0]->name);
    }
}

?>