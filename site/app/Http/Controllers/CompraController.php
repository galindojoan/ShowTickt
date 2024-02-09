<?php

namespace App\Http\Controllers;

require_once base_path('app/redsysHMAC256_API_PHP_7.0.0/apiRedsys.php');
require_once base_path('app/rest_API_PHP/initRedsysApi.php');
// use App\
use RESTConstants;
use App\Models\Esdeveniment;
use App\Models\Sessio;
use Illuminate\Http\Request;
use RESTInitialRequestService;
use Illuminate\Support\Facades\Http;

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
  public function procesPagament(Request $request)
  {
    $challengeRequest = new \RESTAuthenticationRequestMessage();
    $precioTotal = $request->input("total");
    $amount = (int)$precioTotal * 100;
    $id = time();
    $fuc = '999008881';
    $moneda = '978';
    $trans = '0';
    $terminal = '001';
    $url = '';

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

    $params = $miObj->createMerchantParameters();
    $signature = $miObj->createMerchantSignature('sq7HjrUOBfKmC576ILgskD5srU870gJ7');

    return view('targeta', compact('params', 'signature'));
    //Controler nuevo
    //$validate=$request->validate([''])
    //$expiration
    //   "DS_MERCHANT_CVV2": "123",
    // "DS_MERCHANT_EXPIRYDATE": "fechaExpired (año mes)",
    // "DS_MERCHANT_PAN": "targeta credito",
  }
  public function finalDelPagament(Request $request)
  {
    // $validate = $request->validate([
    //   'tarjetaCredito' => 'required|credit_card_number',
    //   'fechaCaducidad' => 'required|regex:/^(0[1-9]|1[0-2])\/[0-9]{2}$/',
    //   'cvv' => 'required|numeric|min:100|max:999',
    // ]);
    // dd($validate);
    $miObj = new \RedsysAPI; 
    var_dump($request->input());
    $params = json_decode(base64_decode($request->input("Ds_MerchantParameters")));
    $version = $request->input("Ds_SignatureVersion");
    $signatureRecibida = $request->input("Ds_Signature");
    var_dump($params);
    $datos=$request->input("Ds_MerchantParameters");
    // var_dump($codigoRespuesta);
    $decodec = $miObj->decodeMerchantParameters($datos);
    // dd($decodec);
			$kc = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7'; //Clave recuperada de CANALES
			$firma = $miObj->createMerchantSignatureNotif($kc,$datos);
		
			if ($firma == $signatureRecibida){
				echo "FIRMA OK";
			} else {
				echo "FIRMA KO";
			}
  }
  function initialOperationV2($orderID) {
		
    $protocolVersion = "";
    $threeDSServerTransID = "";
	$threeDSMethodURL = "";
    
    $cardDataInfoRequest = new \RESTInitialRequestMessage();
	
	// Operation mandatory data
	$cardDataInfoRequest->setAmount("123"); // i.e. 1,23 (decimal point depends on currency code)
	$cardDataInfoRequest->setCurrency("978"); // ISO-4217 numeric currency code
	$cardDataInfoRequest->setMerchant("999008881");
	$cardDataInfoRequest->setTerminal("20");
	$cardDataInfoRequest->setOrder($orderID);
	$cardDataInfoRequest->setTransactionType(RESTConstants::$AUTHORIZATION);
    
    //Card Data information
    $cardDataInfoRequest->setCardNumber("4918019199883839");
    $cardDataInfoRequest->setCardExpiryDate("3412");
    $cardDataInfoRequest->setCvv2("123");
	// Other optional parameters example can be added by "addParameter" method
	$cardDataInfoRequest->addParameter("DS_MERCHANT_PRODUCTDESCRIPTION", "Prueba de pago InSite con 3DSecure");
		
	//Method to ask about card information data
	$cardDataInfoRequest->demandCardData();

	// Service setting (Signature and Environment)
	$signatureKey = "sq7HjrUOBfKmC576ILgskD5srU870gJ7";
	//$signatureKey = "Mk9m98IfEblmPfrpsawt7BmxObt98Jev";

	$service = new RESTInitialRequestService($signatureKey, RESTConstants::$ENV_SANDBOX);
	
	//Printing SendMessage
	echo "<h1>INITIAL: Mensaje a enviar</h1>";
	var_dump($cardDataInfoRequest);
	var_dump($service);

	//Send the operation and catch the response
	$response = $service->sendOperation($cardDataInfoRequest);

	// Response analysis
	echo "<h1>INITIAL: Respuesta recibida</h1>";
	var_dump($response);
		
	//Method the gives the request Result (OK/KO/AUT)
	switch ($response->getResult()) {

		case RESTConstants::$RESP_LITERAL_OK:
			//In this case the operation was ok and PSD2= "N", so authentication is not needed but its possible to make authentication
			echo "<h1>Operation was OK</h1>";
			//In this case the commerce can choose which kind of operation want to use
			//directPaymentOperation (example of this operation in InsiteExampleDirectPayment.java)
			//or authenticationOperationV2 (recommended)
			authenticationOperationV2($cardDataInfoRequest, $protocolVersion, $threeDSServerTransID, $threeDSMethodURL);
		break;

		case RESTConstants::$RESP_LITERAL_AUT: 
			//In this case the operation was ok and PSD2= "Y" and return the protocolVersion parameter
			echo "<h1>Operation requires authentication</h1>";
			//Method to catch the threeDSInfo value
			$threeDSInfo = $response->getThreeDSInfo();
			//Method to catch the protocolVersion (Required for authentication Request)
            $protocolVersion = $response->protocolVersionAnalysis();
            //Because the protocolVersion in this example is 2.X.0, its required to catch two mandatory Parameters in the response
            $threeDSServerTransID = $response->getThreeDSServerTransID();
            $threeDSMethodURL = $response->getThreeDSMethodURL();
            
            //Ones we catch the parameters, we must make the authenticationRequest
			authenticationOperationV2($cardDataInfoRequest, $protocolVersion, $threeDSServerTransID, $threeDSMethodURL);
		break;
		
		case RESTConstants::$RESP_LITERAL_KO: 
			//Operation error
			echo "<h1>Operation was not OK</h1>";
		break;
		
		default:
			echo "<h1>Aqui no debemos de entrar!!!</h1>";
	}
}
public function creacioPdf(Request $request){
  $event = Esdeveniment::getEventById($request->input('id'));
  $entrades = $request->input('arrayEntradas');
  $pdf = app('dompdf.wrapper');
  $pdf->loadView('entradas', compact('event','entrades'));
  return $pdf->download('entradas.pdf');
}
}
