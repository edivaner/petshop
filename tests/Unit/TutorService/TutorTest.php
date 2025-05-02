<?php

namespace Tests\Unit\TutorService;

use App\Services\CacheService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\TestCase;
use App\Services\TutorService;
use App\Repositories\Contracts\TutorRepositoryInterface;
use Mockery;

class TutorTest extends TestCase
{   
    use DatabaseTransactions;
    protected $tutorService;
    protected $tutorRepositoryMock;
    protected $cacheServiceMock;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->tutorRepositoryMock = Mockery::mock(TutorRepositoryInterface::class);
        $this->cacheServiceMock = $this->createMock(CacheService::class); // Mockery::mock(CacheService::class);
        $this->tutorService = new TutorService($this->tutorRepositoryMock, $this->cacheServiceMock);
    }

    public function testListTutors()
    {
        $tutorFake = (object) [
            'id' => 1,
            'name' => 'João da Silva',
            'email' => 'joao@email.com',
            'phone' => '123456789',
            'address' => 'Rua Teste, 123',
            'instagram' => 'joao_dasilva',
            'whatsapp' => '987654321',
            'alternative_contact' => '999888777',
        ];

        $this->tutorRepositoryMock
        ->shouldReceive('all')
        ->once()
        ->andReturn([$tutorFake]);

        $response = $this->tutorService->list();
        $this->assertNotEmpty($response);
        $this->assertEquals('João da Silva', $response->first()->name);
    }

    public function testGetTutor()
    {
        $tutorFake = (object) [
            'id' => 1,
            'name' => 'João da Silva',
            'email' => 'joao@email.com',
            'phone' => '123456789',
            'address' => 'Rua Teste, 123',
            'instagram' => 'joao_dasilva',
            'whatsapp' => '987654321',
            'alternative_contact' => '999888777',
        ];

        $this->cacheServiceMock->expects($this->once())->method('getCache')->with('tutor_'.$tutorFake->id)->willReturn(null);
        
        $this->tutorRepositoryMock
        ->shouldReceive('find')
        ->once()
        ->with($tutorFake->id)
        ->andReturn($tutorFake);
        
        //$this->cacheServiceMock->expects($this->once())->method('setCache')->with('tutor_'.$tutorFake->id, $tutorFake);
        
        $response = $this->tutorService->get($tutorFake->id);

        $this->assertEquals($tutorFake->id, $response->id);
    }

    public function testCreateTutor()
    {
        $data = [
            'name' => 'Eduardo Silva',
            'email' => 'eduardo@email.com',
            'phone' => '1234567890',
            'address' => 'Mario Bonfim, 222 - Centro - São Paulo',
            'instagram' => 'eduardo_silva',
            'whatsapp' => '1234567890',
            'alternative_contact' => '1234567890',
        ];

        $this->tutorRepositoryMock
        ->shouldReceive('create')
        ->once()
        ->with($data)
        ->andReturn((object) array_merge(['id' => 1], $data));

        $response = $this->tutorService->create($data);
        $this->assertEquals($data['name'], $response->name);
        $this->assertEquals($data['email'], $response->email);
        $this->assertEquals($data['phone'], $response->phone);
        $this->assertEquals($data['address'], $response->address);
        $this->assertEquals($data['instagram'], $response->instagram);
        $this->assertEquals($data['whatsapp'], $response->whatsapp);
        $this->assertEquals($data['alternative_contact'], $response->alternative_contact);
    }

    public function testUpdateTutor()
    {
        $id = 42;
        $data = [
            'name' => 'Eduardo Ferreira Silva',
            'email' => 'eduardo@email.com.br',
            'phone' => '123456789',
            'address' => 'Mario Bonfim, 222 - Centro - São Paulo/SP',
            'instagram' => 'eduardo_silva123',
            'whatsapp' => '123456789',
            'alternative_contact' => '123456789',
        ];

        $tutor = (object) array_merge(['id' => $id], $data);

        $this->tutorRepositoryMock
        ->shouldReceive('update')
        ->once()
        ->with($id, $data)
        ->andReturn($tutor);

        $response = $this->tutorService->update($tutor->id, $data);
        $this->assertEquals($data['name'], $response->name);
        $this->assertEquals($data['email'], $response->email);
        $this->assertEquals($data['phone'], $response->phone);
        $this->assertEquals($data['address'], $response->address);
        $this->assertEquals($data['instagram'], $response->instagram);
        $this->assertEquals($data['whatsapp'], $response->whatsapp);
        $this->assertEquals($data['alternative_contact'], $response->alternative_contact);
    }

    public function testDeleteTutor()
    {
        $tutor = (object) [
            'id' => 1,
            'name' => 'João da Silva',
            'email' => 'joao@email.com',
        ];

        $this->tutorRepositoryMock->shouldReceive('delete')->once()->with($tutor->id)->andReturn($tutor);
        $this->cacheServiceMock->expects($this->once())->method('clearCache')->with('tutor_'.$tutor->id);
        $response = $this->tutorService->delete($tutor->id);

        $this->assertNull($response);
    }
}
?>