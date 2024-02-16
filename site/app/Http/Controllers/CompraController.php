<?php

namespace App\Http\Controllers;

require_once base_path('app/redsysHMAC256_API_PHP_7.0.0/apiRedsys.php');
require_once base_path('app/rest_API_PHP/ApiRedsysREST/initRedsysApi.php');
// use App\
use RESTConstants;
use App\Models\Sessio;
use App\Models\Entrada;
use App\Models\Categoria;
use App\Models\Esdeveniment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use RESTInitialRequestService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Config;

class CompraController extends Controller
{
  public function compra(Request $request)
  {
    $nomEvent = $request->input('detallesEvents');
    $total = $request->input('inputTotal');
    $entradaArray = json_decode($request->input('arrayEntradas'));
    $sessionArray = Sessio::getSessionbyID($entradaArray[0]->contadorSession);
    return view('confirmarCompra', compact('nomEvent', 'entradaArray', 'sessionArray', 'total'));
  }
  public function creacioPdf(Request $request)
  {
    $event = Esdeveniment::getEventById($request->input('id'));
    $entrades = $request->input('arrayEntradas');
    $pdf = app('dompdf.wrapper');
    $pdf->loadView('entradas', compact('event', 'entrades'));
    return $pdf->download('entradas.pdf');
  }

  public function redsysDades(Request $request)
  {
    Session::put('ArrayEntradas', json_decode($request->input('ArrayEntradas')));

    $precioTotal = $request->input("total");
    $amount = (int)$precioTotal * 100;
    $id = time();
    $fuc = '999008881';
    $moneda = '978';
    $trans = '0';
    $terminal = '001';
    $url = '';

    $urlOK = route('finCompra');
    $urlKO = route('errorCompra');

    $miObj = new \RedsysAPI;
    $miObj->setParameter("DS_MERCHANT_AMOUNT", $amount);
    $miObj->setParameter("DS_MERCHANT_ORDER", $id);
    $miObj->setParameter("DS_MERCHANT_MERCHANTCODE", $fuc);
    $miObj->setParameter("DS_MERCHANT_CURRENCY", $moneda);
    $miObj->setParameter("DS_MERCHANT_TRANSACTIONTYPE", $trans);
    $miObj->setParameter("DS_MERCHANT_TERMINAL", $terminal);
    $miObj->setParameter("DS_MERCHANT_MERCHANTURL", $url);
    $miObj->setParameter("DS_MERCHANT_DIRECTPAYMENT", "true");
    $miObj->setParameter("DS_REDSYS_ENVIROMENT", "true");
    $miObj->setParameter("DS_MERCHANT_URLOK", $urlOK);
    $miObj->setParameter("DS_MERCHANT_URLKO", $urlKO);

    $params = $miObj->createMerchantParameters();
    $signature = $miObj->createMerchantSignature('sq7HjrUOBfKmC576ILgskD5srU870gJ7');
    $response = new Response();
        $response->setContent("
            <form action='https://sis-t.redsys.es:25443/sis/realizarPago' method='post' id='redsys'>
                <input type='hidden' name='Ds_SignatureVersion' value='HMAC_SHA256_V1'>
                <input type='hidden' name='Ds_MerchantParameters' value='{$params}'/>
                <input type='hidden' name='Ds_Signature' value='{$signature}'/>
            </form>
            <script>document.getElementById('redsys').submit();</script>
        ");
        return $response;
  }
  public function finalDelPagament(Request $request)
  {
    $miObj = new \RedsysAPI;
    $params = json_decode(base64_decode($request->input("Ds_MerchantParameters")));
    $version = $request->input("Ds_SignatureVersion");
    $signatureRecibida = $request->input("Ds_Signature");
    $datos = $request->input("Ds_MerchantParameters");
    // var_dump($codigoRespuesta);
    $decodec = $miObj->decodeMerchantParameters($datos);
    // dd($decodec);
    $kc = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7'; //Clave recuperada de CANALES
    $firma = $miObj->createMerchantSignatureNotif($kc, $datos);

    if ($firma == $signatureRecibida) {
      $Entradas = Session::get('ArrayEntradas');
      foreach ($Entradas as $entrada) {
        Entrada::where('entradas.id', '=', $entrada->contadorEntrada)
                ->update([
                    'quantitat' => $entrada->Maxcantidad,
                ]);
      }
      
      return redirect()->route('compraAceptada');
    } else {
      echo "FIRMA KO";
    }
  }
  public function entradasGratis(Request $request){
    $Entradas=json_decode($request->input('ArrayEntradas'));
    foreach ($Entradas as $entrada) {

      Entrada::where('entradas.id', '=', $entrada->contadorEntrada)
              ->update([
                  'quantitat' => $entrada->Maxcantidad,
              ]);
    }
    
    return redirect()->route('compraAceptada');
  }
  public function viewFinalCompra(Request $request)
  {
    Session::forget('ArrayEntradas');
    $compra=true;
    $pag = Config::get('app.items_per_page', 100);
    $categoryId = ''; // Establece un valor predeterminado

    $esdeveniments = Esdeveniment::with(['recinte'])
      // Ordenar por fecha descendente
      ->paginate($pag);

    $events = Esdeveniment::getAllEvents($pag);

    $categories = Categoria::all();
    $categoriesWithEventCount = (new Categoria())->getCategoriesWithEventCount();

    $categoriesWith3 = Categoria::getCategoriesWith3();

    return view('home', compact('esdeveniments', 'categories', 'categoryId', 'categoriesWithEventCount', 'events', 'categoriesWith3','compra'));
  }
  
  public function errorCompra(Request $request)
  {
    Session::forget('ArrayEntradas');
    $compra=false;
    $pag = Config::get('app.items_per_page', 100);
    $categoryId = ''; // Establece un valor predeterminado

    $esdeveniments = Esdeveniment::with(['recinte'])
      // Ordenar por fecha descendente
      ->paginate($pag);

    $events = Esdeveniment::getAllEvents($pag);
    $categories = Categoria::all();
    $categoriesWithEventCount = (new Categoria())->getCategoriesWithEventCount();

    $categoriesWith3 = Categoria::getCategoriesWith3();

    return view('home', compact('esdeveniments', 'categories', 'categoryId', 'categoriesWithEventCount', 'events', 'categoriesWith3','compra'));
  }
}