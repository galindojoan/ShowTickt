<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    public function test_home_page_loads_correctly()
    {
        $response = $this->get('/');
        $response->assertOk();

        // Ajusta a la lògica per obtenir esdeveniments
        $events = \App\Models\Esdeveniment::take(5)->get();

        foreach ($events as $event) {
            $response->assertSeeText($event->nom);
        }
    }

    public function test_search_filter_works_correctly()
    {
        // Assumint que hi ha resultats de cerca vàlids a la base de dades
        $response = $this->get('/?q=keyword_with_valid_results');
        $response->assertOk();

        // Ajusta a la teva lògica per obtenir i verificar els resultats de cerca
        $expectedResults = \App\Models\Esdeveniment::where('nom', 'like', '%keyword_with_valid_results%')->get();

        foreach ($expectedResults as $result) {
            $response->assertSeeText($result->nom);
        }
    }

    public function test_category_filter_works_correctly()
    {
        // Assegura't que hi ha dades a la base de dades
        // associades a una categoria específica
        $categoryId = 4; // Ajusta a l'ID correcte de la categoria "social"
        $response = $this->get("/cerca?category={$categoryId}");

        $response->assertOk();
    }

    // Podeu continuar afegint altres proves aquí...

    public function test_pagination_works_correctly()
    {
        // Prova de paginació
        $response = $this->get('/?page=2');
        $response->assertOk();

        // Verifica que es mostri correctament la segona pàgina
        $response->assertSeeText('2');

        // Assegura't que la paginació no estigui buida
        $response->assertDontSeeText('Mostrando 0 - 0 de 0 resultados');
    }

    public function test_home_page_contains_category_options()
    {
        // Prova que la pàgina conté les opcions de categoria
        $response = $this->get('/');
        $response->assertOk();

        // Ajusta a la teva lògica per obtenir les categories
        $categories = \App\Models\Categoria::all();

        foreach ($categories as $category) {
            $response->assertSeeText($category->tipus);
        }
    }
}
