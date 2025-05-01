<?php
namespace Tests\Unit\AnimalService;

use Tests\TestCase;
use App\Models\Animal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;

class AnimalTest extends TestCase{
    use RefreshDatabase;
    
    public function testAnimalCreateStore(){
        $animal = [
            'name' => 'Doug',
            'species' => 'Cachorro',
            'breed' => 'Labrador',
            'age' => 5,
            'sex' => 'macho',
            'color' => 'Amarelo',
            'size'  => 20.5,
            'observations' => 'Está saudável',
            'tutor_id' => 1,
        ];

        $response = $this->post('/api/animals', $animal);
        
        $response->assertStatus(201);
    }
}
?>