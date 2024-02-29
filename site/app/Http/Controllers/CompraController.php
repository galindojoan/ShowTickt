<?php

namespace App\Http\Controllers;

require_once base_path('app/redsysHMAC256_API_PHP_7.0.0/apiRedsys.php');
require_once base_path('app/rest_API_PHP/ApiRedsysREST/initRedsysApi.php');
// use App\
use Exception;
use RESTConstants;
use App\Models\Compra;
use App\Models\Sessio;
use App\Models\Entrada;
use Elibyy\TCPDF\TCPDF;
use App\Models\Categoria;
use App\Mail\CorreoEntrades;
use App\Models\Esdeveniment;
use Illuminate\Http\Request;
use App\Models\CompraEntrada;
use Illuminate\Http\Response;
use BaconQrCode\Encoder\QrCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;


class CompraController extends Controller
{
  public function compra(Request $request)
  {
    $nomEvent = $request->input('nameEvent');
    $total = $request->input('inputTotal');
    $entradaArray = json_decode($request->input('arrayEntradas'));
    $sessionArray = Sessio::getSessionbyID($entradaArray[0]->contadorSession);
    $idEvent = $request->input('idEvent');

    return view('confirmarCompra', compact('nomEvent', 'entradaArray', 'sessionArray', 'total', 'idEvent'));
  }
  public function redsysDades(Request $request)
  {
    Session::put('ArrayEntradas', json_decode($request->input('ArrayEntradas')));
    Session::put('email', $request->input('emailEscogido'));
    Session::put('idEvent', json_decode($request->input('idEvent')));


    Session::put('sessio', json_decode($request->input('sessioEscogida')));


    $precioTotal = $request->input("total");
    $amountWInt = $precioTotal * 100;
    $amount = (int)$amountWInt;
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
  public function entradasGratis(Request $request)
  {
    $Entradas = json_decode($request->input('ArrayEntradas'));
    foreach ($Entradas as $entrada) {

      Entrada::where('entradas.id', '=', $entrada->contadorEntrada)
        ->update([
          'quantitat' => $entrada->Maxcantidad,
        ]);
    }

    return redirect()->route('compraAceptada');
  }
  function generarCodigo($longitud)
  {
    $key = '';
    $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
    $max = strlen($pattern) - 1;
    for ($i = 0; $i < $longitud; $i++) {
      $key .= $pattern[mt_rand(0, $max)];
    };
    return $key;
  }
  public function viewFinalCompra(Request $request)
  {
    $compra = true;
    $pag = Config::get('app.items_per_page', 100);
    $categoryId = ''; // Establece un valor predeterminado

    $esdeveniments = Esdeveniment::with(['recinte'])
      // Ordenar por fecha descendente
      ->paginate($pag);

    $events = Esdeveniment::getAllEvents($pag);

    $categories = Categoria::all();
    $categoriesWithEventCount = (new Categoria())->getCategoriesWithEventCount();

    $categoriesWith3 = Categoria::getCategoriesWith3();

    try {
      $email = Session::get('email');
      $evento = Esdeveniment::getEventById(Session::get('idEvent'));
      $entrades = Session::get('ArrayEntradas');
      $sessio = Session::get('sessio');
      $recinte = Esdeveniment::getFirstEventLocal(Session::get('idEvent'));
      $lloc = $recinte->provincia.', '.$recinte->lloc.', '.$recinte->codi_postal.', '.$recinte->carrer.', '.$recinte->numero;
      foreach ($entrades as $entrada) {
        $num = $this->generarCodigo(10);
        $false = false;
        while (!$false) {
          if (CompraEntrada::isNumeroIdentificadorUnique($num)) {
            $entrada->numeroIdentificador =  $num;
            $false = true; 
            break;
          }else {
            $num = $this->generarCodigo(10);
          }
        }
        
      }
      Log::info('Variables.');

      $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
      $pdf->SetCreator('ShowTickt');
      $pdf->SetTitle('Entradas');
      $image = '<img style="text-align:center;" src="'.public_path('imagen/logo-blanco.png').'" width="100" alt="logo">';
      $titol = '<h1 style="font-size: 40px; text-align:center;">ShowTickt</h1>';
      
      $pdf->AddPage('L','A4');
      $y = $pdf->getY();
      $pdf->writeHTMLCell(40, 0, '', $y, $image, 0, 0, 0, true, 'C', true);
      $pdf->writeHTMLCell(80, 0, '', '', $titol, 0, 1, 0, true, 'C', true);

      $data = view('pdfs.entradas', ['event' => $evento, 'entrades' => $entrades, 'sessio' => $sessio->data, 'lloc' => $lloc])->render();
      $pdf->writeHTML($data, true, false, true, false, '');
      $pdfContent = $pdf->Output('', 'S');
      Log::info('PDF creado correctamente.');

      Mail::to($email)->send(new CorreoEntrades($evento, $sessio, $pdfContent));

      Log::info('Se ha enviado el mail con los entradas con éxito.');

      $compra = Compra::create(['sessios_id'=> $sessio->id,'quantitat'=>count($entrades),'mailComprador' => $email,]);
      foreach ($entrades as $entrada) {
        $entradesComprades = CompraEntrada::create([
          'nomComprador'=>$entrada->nomComprador,
          'dni' => $entrada->dniComprador,
          'tel' => $entrada->telComprador,
          'numeroIdentificador' => $entrada->numeroIdentificador,
          'entrada_id' =>$entrada->contadorEntrada,
          'compra_id' => $compra->id,
        ]);        
      }
      Log::info('Guardada la compra en la bd.');
      Session::forget('email', 'ArrayEntradas', 'idEvent', 'sessio');
    } catch (Exception $e) {
      Log::error('Error al mandar el mail o al crear el pdf de la compra. Error: ' . $e->getMessage());
      Session::forget('email', 'ArrayEntradas', 'idEvent', 'sessio');
    }

    return view('home', compact('esdeveniments', 'categories', 'categoryId', 'categoriesWithEventCount', 'events', 'categoriesWith3', 'compra'));
  }

  public function errorCompra(Request $request)
  {
    Session::forget('ArrayEntradas');
    $compra = false;
    $pag = Config::get('app.items_per_page', 100);
    $categoryId = ''; // Establece un valor predeterminado

    $esdeveniments = Esdeveniment::with(['recinte'])
      // Ordenar por fecha descendente
      ->paginate($pag);

    $events = Esdeveniment::getAllEvents($pag);
    $categories = Categoria::all();
    $categoriesWithEventCount = (new Categoria())->getCategoriesWithEventCount();

    $categoriesWith3 = Categoria::getCategoriesWith3();

    return view('home', compact('esdeveniments', 'categories', 'categoryId', 'categoriesWithEventCount', 'events', 'categoriesWith3', 'compra'));
  }
}
