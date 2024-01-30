<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SesionEditTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_loads_correctly(){
        $response = $this->get('/login');
        $response->assertOk();
    }

    public function test_login_validates_users(): void
    {
        $user = User::factory()->create();
        $credentials = [
            'usuario' => $user->username,
            'password' => $user->password,
        ];
        $response = $this->post('/homePromotor', $credentials);
        $response->assertRedirect('/homePromotor');
    }
}
