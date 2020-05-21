<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Api\PaymentExecution;

use App\PayPal;
use App\Order;

use Session;

class PaymentsController extends Controller
{

  private $apiContext;

  public function __construct()
  {
    $payPalConfig = config::get('services.paypal');

    $this->apiContext = new ApiContext(
      new OAuthTokenCredential(
          $payPalConfig['clientid'],     // ClientID
          $payPalConfig['secret']      // ClientSecret
      )
    );
  }
/*
  public function pay2(Request $request){
    $amount = $request->shopping_cart->amount();

    $paypal = new PayPal();

    $response = $paypal->charge($amount);

    return var_dump(($response));
  }
*/
  public function pay(Request $request){
    
    //$amount = $request->shopping_cart->amount();
    $payer = new Payer();
    $payer->setPaymentMethod('paypal');

    $amount = new Amount();
    $amount->setTotal('5.00');
    $amount->setCurrency('USD');

    $transaction = new Transaction();
    $transaction->setAmount($amount);
    // $transaction->setDescription('Monto total de productos en ecommerce');

    $callbackUrl = url('/pagar/status');
    $redirectUrls = new RedirectUrls();
    $redirectUrls->setReturnUrl($callbackUrl)
      ->setCancelUrl($callbackUrl);
      // "http://ecommercepage.test/productos"

    $payment = new Payment();
    $payment->setIntent('sale')
      ->setPayer($payer)
      ->setTransactions(array($transaction))
      ->setRedirectUrls($redirectUrls);
    
    try {
      $payment->create($this->apiContext);
      
      return redirect()->away($payment->getApprovalLink());
      // echo $payment;
    
      // echo "\n\nRedirect user to approval_url: " . $payment->getApprovalLink() . "\n";
    }
    catch (PayPalConnectionException $ex) {
      // This will print the detailed information on the exception.
      //REALLY HELPFUL FOR DEBUGGING
      echo $ex->getData();
    }

  }

  public function payPalStatus(Request $request){
    $paymentId = $request->paymentId;
    $payerId = $request->PayerID;
    $token = $request->token;

    if(!$paymentId || !$payerId || !$token){
      $status = 'No se puedo completar el pago con paypal, intente de nuevo.';
      return redirect('/carrito')->with(compact(('status')));
    }



    $payment = Payment::get($paymentId, $this->apiContext);

    $execution = new PaymentExecution();
    $execution->setPayerId($payerId);

    /** Execute the payment **/
    $result = $payment->execute($execution, $this->apiContext);
    // dd($result);
    
    if ($result->getState() === 'approved') {
      $status = 'Gracias! El pago a través de PayPal se ha ralizado correctamente.';
      return view('payments.success');
    }

    $status = 'Lo sentimos! El pago a través de PayPal no se pudo realizar.';
    return redirect('/results')->with(compact('status'));

  
    //public function __construct(){
        //$this->middleware('shopping_cart');
     // }
    
        /*
        $redirectLinks = array_filter($response->result->links,function($link){
          return $link->method == 'REDIRECT'; // filtrar los links que solo cumplan en su propiedad method reditec
        });

        //filter deja sus indices, con array_values reacomodamos indices 
        $redirectLinks = array_values($redirectLinks);
    
        return redirect($redirectLinks[0]->href); //retornamos el primer elemento del array
        */
      }

      /*
      public function execute(Request $request){
        $paypal = new PayPal();
        $response = $paypal->execute($request->paymentId, $request->PayerID);
    
        if($response->statusCode == 200){
    
          $order = Order::createFromPayPalResponse($response->result,$request->shopping_cart);
    
          if($order){
            Session::remove('shopping_cart_id');
            return view('payments.success',['shopping_cart' => $request->shopping_cart, 'order' => $order]);
          }
    
    
        }else{
          return redirect(URL::route('shopping_cart.show'));
        }
        
      }
    */
}
