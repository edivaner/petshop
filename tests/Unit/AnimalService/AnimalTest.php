<?php
namespace Tests\Unit\AnimalService;

use App\Http\Resources\AnimalResource;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Models\Animal;
use App\Repositories\Contracts\AnimalRepositoryInterface;
use App\Repositories\Eloquent\AnimalRepository;
use App\Services\AnimalService;
use App\Services\CacheService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;

class AnimalTest extends TestCase{
    use DatabaseTransactions;

    protected $animalService;
    protected $animalRepositoryMock;
    protected $cacheServiceMock;

    public function setUp(): void{
        parent::setUp();
        $this->animalRepositoryMock = Mockery::mock(AnimalRepositoryInterface::class);
        $this->cacheServiceMock = Mockery::mock(CacheService::class);
        $this->animalService = new AnimalService($this->animalRepositoryMock, $this->cacheServiceMock);
    }

    public function testCreateAnimal(){
        $animalTeste = [
            'name' => 'Doug',
            'species' => 'Cachorro',
            'breed' => 'Labrador',
            'age' => 5,
            'sex' => 'Macho',
            'color' => 'Amarelo',
            'size'  => 20.5,
            'observations' => 'Está saudável',
            'tutor_id' => 1,
        ];

        $this->animalRepositoryMock->shouldReceive('create')->once()->with($animalTeste)->andReturn(new Animal($animalTeste));

        $animal = $this->animalService->create($animalTeste);

        $this->assertInstanceOf(AnimalResource::class, $animal);
        $this->assertEquals($animalTeste['name'], $animal->name);
    }

    public function testListAnimals(){
        $animalTeste = (object) [
            'id' => 1,
            'name' => 'Doug',
            'species' => 'Cachorro',
            'breed' => 'Labrador',
            'age' => 5,
            'sex' => 'Macho',
            'color' => 'Amarelo',
            'size'  => 20.5,
            'observations' => 'Está saudável',
            'tutor_id' => 1,
        ];

        $this->animalRepositoryMock->shouldReceive('all')->once()->andReturn([$animalTeste]);

        $animal = $this->animalService->list();

        $this->assertInstanceOf(AnimalResource::class, $animal->first());
        $this->assertNotEmpty($animal);
        $this->assertEquals($animalTeste->name, $animal->first()->name);
    }

    public function testGetAnimal(){
        $animalTeste = (object) [
            'id' => 1,
            'name' => 'Doug',
            'species' => 'Cachorro',
            'breed' => 'Labrador',
            'age' => 5,
            'sex' => 'Macho',
            'color' => 'Amarelo',
            'size'  => 20.5,
            'observations' => 'Está saudável',
            'tutor_id' => 1,
        ];

        $this->cacheServiceMock->shouldReceive('getCache')->once()->with('animal_'.$animalTeste->id)->andReturn(null);
        $this->animalRepositoryMock->shouldReceive('find')->once()->with($animalTeste->id)->andReturn($animalTeste);
        $this->cacheServiceMock->shouldReceive('setCache')->once()->with('animal_'.$animalTeste->id, $animalTeste);
        

        $animal = $this->animalService->get($animalTeste->id);

        $this->assertInstanceOf(AnimalResource::class, $animal);
        $this->assertEquals($animalTeste->id, $animal->id);
        $this->assertEquals($animalTeste->name, $animal->name);
    }
    
    public function testUpdateAnimal(){
        $animalTeste = [
            'id' => 2,
            'name' => 'Douglas',
            'species' => 'Cachorro',
            'breed' => 'Labrador de Pequeno Porte',
            'age' => 6,
            'sex' => 'Macho',
            'color' => 'Amarelo e Branco',
            'size'  => 21,
            'observations' => 'Está saudável e feliz',
            'tutor_id' => 1,
        ];

        $this->animalRepositoryMock->shouldReceive('update')->once()->with($animalTeste['id'], $animalTeste)->andReturn($animalTeste);

        $animal = $this->animalService->update($animalTeste['id'], $animalTeste);

        $this->assertInstanceOf(AnimalResource::class, $animal);
        $this->assertEquals($animalTeste['id'], $animal['id']);
        $this->assertEquals($animalTeste['name'], $animal['name']);
    }

    public function testDeleteAnimal(){
        $animalTeste = [
            'id' => 2
        ];

        $this->animalRepositoryMock->shouldReceive('delete')->once()->with($animalTeste['id'])->andReturn(true);
        $this->cacheServiceMock->shouldReceive('clearCache')->once()->with('animal_'.$animalTeste['id']);
        
        $animal = $this->animalService->delete($animalTeste['id']);

        $this->assertTrue($animal);
    }
}

?>