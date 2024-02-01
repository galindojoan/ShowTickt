<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecuperarPasswordTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_recuperar_page_loads_correctly(): void
    {
        $response = $this->get('/recuperar');
        $response->assertOk();
    }
    public function test_recuperar_sends_email_correctly() {
        $user = User::factory()->create();
        $form = [
            'email' => $user->email,
        ];
        $response = $this->post('/recuperar-form',$form);
        $response->assertRedirect('/login');
    }
}
