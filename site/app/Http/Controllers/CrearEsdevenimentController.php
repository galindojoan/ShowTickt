<?php

namespace App\Http\Controllers;

use App\Models\Esdeveniment;
use App\Models\Categoria;
use App\Models\Recinte;
use App\Models\Sessio;
use App\Models\Entrada;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CrearEsdevenimentController extends Controller
{
    public function index()
    {
        $categories = Categoria::all();
        $recintes = Recinte::all();
        $noRecintes = $recintes->isEmpty();

        return view('crearEsdeveniment', compact('categories', 'recintes', 'noRecintes'));
    }
    public function recintePage(){
        return view('crearRecinte');
    }

    public function verificarCarrer($carrer, $numero)
    {
        $client = new Client();

        $direccion = $carrer . '+' . $numero;

        // Consulta a la API de Nominatim
        $response = $client->get('https://nominatim.openstreetmap.org/search?q=' . $direccion . '&format=json', [
            'limit' => 1,  // Limitar a un solo resultado
            'verify' => false,
        ]);

        // Log para mostrar la variable $response antes de procesar
        Log::info('Response de la API Nominatim: ' . $response->getBody());

        // Procesar la respuesta JSON
        $data = json_decode($response->getBody(), true);

        // Log para mostrar la variable $data
        Log::info('Data de la validación: ' . json_encode($data));

        // Verificar si hay resultados y si el tipo es 'tertiary' (carretera)
        return !empty($data);
    }

    public function store(Request $request)
    {
        $recinteId = $request->input('recinte');

        try {
            $esdeveniment = $this->createEsdeveniment($request, $recinteId);
            $sessioId = $this->createSessio($request, $esdeveniment->id);
            $this->createEntrades($request, $sessioId);

            Log::info('Evento nuevo creado con la id: ' . $esdeveniment->id);
        } catch (Exception $e) {
            Log::error('Fallo al intentar crear un nuevo evento. Mensaje de error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al crear el evento.')->withInput();
        }

        return redirect()->route('homePromotor')->with('success', 'Evento creado exitosamente');
    }

    private function getRecinteId(Request $request)
    {
        // Si se ha seleccionado crear una nueva dirección
        $carrer = $request->input('nova_carrer');
        $numero = $request->input('nova_numero');

        Log::info('Carrer: ' . $carrer);
        Log::info('Numero: ' . $numero);

        // Verificar si la dirección existe utilizando la función verificarCarrer
        $direccionValida = $this->verificarCarrer($carrer, $numero);

        if (!$direccionValida) {
            return redirect()->back()->with('error', 'La dirección no existe, introduce una dirección válida.')->withInput();
        }

        // Crear un nuevo recinto con las datos proporcionados
        $recinte = Recinte::create([
            'nom' => $request->input('nova_nom'),
            'provincia' => $request->input('nova_provincia'),
            'lloc' => $request->input('nova_ciutat'),
            'carrer' => $request->input('nova_carrer'),
            'numero' => $request->input('nova_numero'),
            'codi_postal' => $request->input('nova_codi_postal'),
            'capacitat' => $request->input('nova_capacitat'),
            'user_id' => $request->input('nova_user_id'),
        ]);

        return $recinte->id;
    }

    private function createEsdeveniment(Request $request, $recinteId)
    {
        $nombreUnico = time() . '_' . $request->file('imatge')->getClientOriginalName();

        return Esdeveniment::create([
            'nom' => $request->input('titol'),
            'categoria_id' => $request->input('categoria'),
            'recinte_id' => $recinteId,
            'imatge' => $request->file('imatge')->storeAs('images', $nombreUnico),
            'descripcio' => $request->input('descripcio'),
            'ocult' => $request->has('ocultarEsdeveniment'),
            'user_id' => $request->input('user_id'),
        ]);
    }

    private function createSessio(Request $request, $esdevenimentId)
    {
        $sessio = Sessio::create([
            'data' => $request->input('data_hora'),
            'aforament' => $request->input('aforament_maxim'),
            'tancament' => $request->input('dataHoraPersonalitzada'),
            'esdeveniments_id' => $esdevenimentId,
        ]);

        return $sessio->id;
    }

    private function createEntrades(Request $request, $sessioId)
    {
        $noms = $request->input('entrades-nom');
        $preus = $request->input('entrades-preu');
        $quantitats = $request->input('entrades-quantitat');
        $nominal = $request->input('entradaNominalCheck');

        // Procesar los datos según sea necesario
        for ($i = 0; $i < count($noms); $i++) {
            // $entradaNominal = isset($nominal[$i]) ? true : false;
            Entrada::create([
                'nom' => $noms[$i],
                'preu' => $preus[$i],
                'quantitat' => $quantitats[$i],
                'nominal' => $nominal[$i],
                'sessios_id' => $sessioId,
            ]);
        }

    }
    public function crearRecinte(Request $request){
        $this->getRecinteId($request);
        Log::info('Recinto nuevo creado.');
        return redirect('crear-esdeveniment');
    }
}
