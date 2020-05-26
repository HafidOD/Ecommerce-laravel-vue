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

class PaymentsController extends Controller
{
	private $apiContext;

	public function __construct()
	{
		$this->middleware('shopping_cart');

		$payPalConfig = config::get('services.paypal');

		$this->apiContext = new ApiContext(
			new OAuthTokenCredential(
				$payPalConfig['clientid'],     // ClientID
				$payPalConfig['secret']      // ClientSecret
			)
		);
	}

	public function pay(Request $request){

		$total = $request->shopping_cart->amount();
		echo $total;

    $payer = new Payer();
    $payer->setPaymentMethod('paypal');

    $amount = new Amount();
    $amount->setTotal($total);
    $amount->setCurrency('MXN');

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
			\Session::remove('shopping_cart_id'); // eliminar session para eliminar productos
      return view('payments.success');
    }

    $status = 'Lo sentimos! El pago a través de PayPal no se pudo realizar.';
		return redirect('/results')->with(compact('status'));
	}

}
