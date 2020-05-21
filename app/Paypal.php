<?php

namespace App;
use URL;

use Illuminate\Support\Facades\Config;
use PayPal\Core\PayPalHttpClient;
use PayPal\v1\Payments\PaymentCreateRequest;
use PayPal\v1\Payments\PaymentExecuteRequest;
use PayPal\Core\SandboxEnvironment; //ProductionEnvironment for production calls

use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Api\PaymentExecution;


//use Illuminate\Database\Eloquent\Model;

class Paypal
{
    public  $enviroment; // $client;

    public function __construct(){

        $clientid = Config::get('services.paypal.clientid');
        $secret = Config::get('services.paypal.secret');

        $this->enviroment = new ApiContext(
            new OAuthTokenCredential(
                $clientid['clientid'],     // ClientID
                $secret['secret']      // ClientSecret
            )
          );

        // $this->client = new PaypalHttpClient($this->enviroment);
    }

    public function buildPaymentRequest($amount){
    
    $payer = new Payer();
    $payer->setPaymentMethod('paypal');

    $amount = new Amount();
    $amount->setTotal($amount);
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

    return $payment;

    }

    public function charge($amount){
        return $this->buildPaymentRequest($amount);
    }
}
