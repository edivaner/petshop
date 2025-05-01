<?php
namespace Tests\Feature\TutorService; 

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TutorTest extends TestCase{
    use RefreshDatabase;
    
    public function testTutorCreateStore(){
        $data = [
            'name' => 'Eduardo Ferreira Silva',
            'email' => 'eduardo@email.com.br',
            'phone' => '123456789',
            'address' => 'Mario Bonfim, 222 - Centro - São Paulo/SP',
            'instagram' => 'eduardo_silva123',
            'whatsapp' => '123456789',
            'alternative_contact' => '123456789',
        ];

        $response = $this->post('/api/tutors', $data);
        
        $response->assertStatus(201);
    }
}
?>