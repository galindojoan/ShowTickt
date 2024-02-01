<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Sessio;
use App\Models\Entrada;
use App\Models\Recinte;
use App\Models\Categoria;
use App\Models\Esdeveniment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SesionEditTest extends TestCase
{
    use RefreshDatabase;

    //Test el cual valida la carga de la página login
    public function test_login_page_loads_correctly()
    {
        $response = $this->get('/login');
        $response->assertOk();
    }

    //Test que valida el acceso a usuarios desde el login
    public function test_login_validates_users()
    {
        $user = User::factory()->create([
            'password' => Hash::make('p12345678'),
        ]);
        $credentials = [
            'usuario' => $user->username,
            'password' => 'p12345678',
        ];
        $response = $this->post('/iniciarSesion', $credentials);
        $response->assertRedirect('/homePromotor');
    }

    //Test que valida la carga de la página añadir sesión
    public function test_anadir_sessio_page_loads_correctly()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->withSession(['key' => $user->id])->get('/añadirSession');
        $response->assertOk();
    }

    //Test que valida la subida de una nueva sesión a la bd
    public function test_anadir_session_validate()
    {
        //Creación de un evento para poder añadirle una sesión
        $user = User::factory()->create();
        $categoria = Categoria::factory()->create();
        $recinte = Recinte::factory()->create([
            'user_id' => $user->id,
        ]);
        $esdeveniment = Esdeveniment::factory()->create([
            'user_id'=>$user->id,
            'id' => $categoria->id,
            'categoria_id' => $categoria->id,
            'recinte_id' => $recinte->id,
        ]);

        //Datos de la nueva sesión
        $form = [
            'event-id' =>$esdeveniment->id,
            'user_id' => $user->id,
            'data_hora' => '2024-02-28 12:00:00',
            'dataHoraPersonalitzada' => '2024-02-28 12:00:00',
            'aforament_maxim' => 100,
            'entradaNominal' => True,
            'entrades-nom' => ['general', 'vip'],
            'entrades-preu' => [90, 150],
            'entrades-quantitat' => [100, 50],
        ];
        $response = $this->actingAs($user)->withSession(['key' => $user->id])->post('/peticionSesion', $form);
        $response->assertRedirect('/editarEsdeveniment/'.$esdeveniment->id);
    }



    //Al editar la sesón podes añadir, quitar o editar las entradas. Se crearon test para cada caso posible en cuanto a las entradas
    //y se editan las otras partes de las sesiones para confirmar que todo funciona.
    public function test_editar_session_edit_entrada_validate() {
         //Creación de un evento para poder añadirle una sesión
        $user = User::factory()->create();
        $categoria = Categoria::factory()->create();
        $recinte = Recinte::factory()->create([
            'user_id' => $user->id,
        ]);
        $esdeveniment = Esdeveniment::factory()->create([
            'user_id'=>$user->id,
            'id' => 1,
            'categoria_id' => $categoria->id,
            'recinte_id' => $recinte->id,
        ]);
        $sessio = Sessio::factory()->create([
            'esdeveniments_id'=>$esdeveniment->id,
        ]);
        $entrada = Entrada::factory()->create([
            'sessios_id'=>$sessio->id,
        ]);

        $form = [
            'event-id' =>$esdeveniment->id,
            'fecha-id'=>$sessio->id,
            'user_id' => $user->id,
            'data_hora' => '2024-04-18 13:30:00',
            'dataHoraPersonalitzada' => '2024-04-18 10:00:00',
            'aforament_maxim' => 50,
            'entradaNominal' => False,
            'entrades-nom' => ['normal', 'vip+'],
            'entrades-preu' => [20, 100],
            'entrades-quantitat' => [25, 25],
        ];
        $response = $this->actingAs($user)->withSession(['key'=> $user->id])->post('/cambiarSesion',$form);
        $response->assertRedirect('/editarEsdeveniment/'.$esdeveniment->id);
    }
    public function  test_editar_session_mas_entrada_validate() {
          //Creación de un evento para poder añadirle una sesión
        $user = User::factory()->create();
        $categoria = Categoria::factory()->create();
        $recinte = Recinte::factory()->create([
            'user_id' => $user->id,
        ]);
        $esdeveniment = Esdeveniment::factory()->create([
            'user_id'=>$user->id,
            'id' => 1,
            'categoria_id' => $categoria->id,
            'recinte_id' => $recinte->id,
        ]);
        $sessio = Sessio::factory()->create([
            'esdeveniments_id'=>$esdeveniment->id,
        ]);
        $entrada = Entrada::factory()->create([
            'sessios_id'=>$sessio->id,
        ]);

        $form = [
            'event-id' =>$esdeveniment->id,
            'fecha-id'=>$sessio->id,
            'user_id' => $user->id,
            'data_hora' => '2024-04-18 13:30:00',
            'dataHoraPersonalitzada' => '2024-04-18 10:00:00',
            'aforament_maxim' => 400,
            'entradaNominal' => False,
            'entrades-nom' => ['normal','normal+', 'vip+','vip'],
            'entrades-preu' => [20,30, 100,200],
            'entrades-quantitat' => [100,100,100,100],
        ];
        $response = $this->actingAs($user)->withSession(['key'=> $user->id])->post('/cambiarSesion',$form);
        $response->assertRedirect('/editarEsdeveniment/'.$esdeveniment->id);
    }
    public function test_editar_session_menos_entrada_validate() {
         //Creación de un evento para poder añadirle una sesión
         $user = User::factory()->create();
         $categoria = Categoria::factory()->create();
         $recinte = Recinte::factory()->create([
             'user_id' => $user->id,
         ]);
         $esdeveniment = Esdeveniment::factory()->create([
             'user_id'=>$user->id,
             'id' => 1,
             'categoria_id' => $categoria->id,
             'recinte_id' => $recinte->id,
         ]);
         $sessio = Sessio::factory()->create([
             'esdeveniments_id'=>$esdeveniment->id,
         ]);
         $entrada = Entrada::factory()->create([
             'sessios_id'=>$sessio->id,
         ]);
 
         $form = [
             'event-id' =>$esdeveniment->id,
             'fecha-id'=>$sessio->id,
             'user_id' => $user->id,
             'data_hora' => '2024-04-18 13:30:00',
             'dataHoraPersonalitzada' => '2024-04-18 10:00:00',
             'aforament_maxim' => 150,
             'entradaNominal' => False,
             'entrades-nom' => ['normal'],
             'entrades-preu' => [15],
             'entrades-quantitat' => [150],
         ];
         $response = $this->actingAs($user)->withSession(['key'=> $user->id])->post('/cambiarSesion',$form);
         $response->assertRedirect('/editarEsdeveniment/'.$esdeveniment->id);
    }
}
