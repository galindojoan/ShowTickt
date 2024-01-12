<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Recinte;
use App\Models\Esdeveniment;
use App\Models\Categoria;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads_correctly()
    {
        Categoria::factory(4)->create();
        Recinte::factory(2)->create();

        // Obtener IDs de recintos y categorias existentes
        $recintesIds = Recinte::pluck('id');
        $categoriesIds = Categoria::pluck('id');
        Esdeveniment::factory()->count(6)->create([
            'recinte_id' => function () use ($recintesIds) {
                return rand(1, count($recintesIds));
            },
            'categoria_id' => function () use ($categoriesIds) {
                return rand(1, count($categoriesIds));
            },
        ]);

        $response = $this->get('/');
        $response->assertOk();

        $events = Esdeveniment::take(1)->get();

        foreach ($events as $event) {
            $response->assertSeeText($event->nom);
        }
    }

    public function test_search_filter_works_correctly()
    {
        $keyword = 'keyword_with_valid_results';

        // Utilitza la fàbrica per crear un esdeveniment amb recinte i categoria
        Esdeveniment::factory()->create([
            'nom' => $keyword,
            'recinte_id' => Recinte::factory()->create()->id,
            'categoria_id' => Categoria::factory()->create()->id,
        ]);

        $response = $this->get("/?q={$keyword}");
        $response->assertOk();

        $expectedResults = Esdeveniment::where('nom', 'like', "%{$keyword}%")->get();

        foreach ($expectedResults as $result) {
            $response->assertSeeText($result->nom);
        }
    }

    public function test_category_filter_works_correctly()
    {
        $categoryId = 3;

        Categoria::factory()->create(['id' => $categoryId]);

        // Utilitza la fàbrica per crear un esdeveniment amb recinte i categoria
        Esdeveniment::factory()->create([
            'categoria_id' => $categoryId,
            'recinte_id' => Recinte::factory()->create()->id,
        ]);

        $response = $this->get("/cerca?category={$categoryId}");
        $response->assertOk();
    }

    public function test_pagination_works_correctly()
    {
        // Crea recintes i categories necessàries
        Recinte::factory(10)->create();
        Categoria::factory(10)->create();

        // Crea esdeveniments amb recintes i categories associats
        Esdeveniment::factory(10)->create([
            'recinte_id' => Recinte::factory()->create()->id,
            'categoria_id' => Categoria::factory()->create()->id,
        ]);

        $response = $this->get('/?page=2');
        $response->assertOk();

        $response->assertSeeText('2');
        $response->assertDontSeeText('Mostrando 0 - 0 de 0 resultados');
    }

    public function test_home_page_contains_category_options()
    {
        Categoria::factory(4)->create();

        $response = $this->get('/');
        $response->assertOk();

        $categories = Categoria::all();

        foreach ($categories as $category) {
            $response->assertSeeText($category->tipus);
        }
    }
}
