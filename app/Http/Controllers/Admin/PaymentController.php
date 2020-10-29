<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Braintree;
use App\Apartment;
use App\User;
use App\Sponsor;
use Carbon\Carbon;

class PaymentController extends Controller
{
  // metodo
  public function payment(Apartment $apartment) {

    $sponsors = Sponsor::all();

    $gateway = new Braintree\Gateway([
        'environment' => config('services.braintree.environment'),
        'merchantId' => config('services.braintree.merchantId'),
        'publicKey' => config('services.braintree.publicKey'),
        'privateKey' => config('services.braintree.privateKey')
    ]);

    $token = $gateway->clientToken()->generate();


    return view('admin.apartments.payment', [
      'token' => $token,
      'apartment' => $apartment,
      'sponsors' => $sponsors
    ]);
  }

  public function checkout(Request $request, Apartment $apartment) {

    $data = $request->all();

    $gateway = new Braintree\Gateway([
        'environment' => config('services.braintree.environment'),
        'merchantId' => config('services.braintree.merchantId'),
        'publicKey' => config('services.braintree.publicKey'),
        'privateKey' => config('services.braintree.privateKey')
    ]);

    $this_id = $apartment->id;

    // $thisSponsor = $apartment->sponsors()->wherePivot('apartment_id', $apartment->id)->get();
    $price = implode($data['sponsors']);

    $nonce = $request->payment_method_nonce;

    $result = $gateway->transaction()->sale([
        'amount' => $price,
        'paymentMethodNonce' => $nonce,
        // 'customer' => [
        //     'firstName' => 'Tony',
        //     'lastName' => 'Stark',
        //     'email' => 'tony@avengers.com',
        // ],
        'options' => [
            'submitForSettlement' => true
        ]
    ]);

    if ($result->success) {
        $transaction = $result->transaction;
        // header("Location: transaction.php?id=" . $transaction->id);

        if ($price == 2.99) {
          $duration = 1;
          $sponsor_id = 1;
        }elseif ($price == 5.99) {
          $duration = 3;
          $sponsor_id = 2;
        }else {
          $duration = 6;
          $sponsor_id = 3;
        }

        $activeSponsor = $apartment->sponsors()->wherePivot('apartment_id', $apartment->id)->get();

        if ($activeSponsor->isEmpty()) {
          $startSponsor = Carbon::now()->format('Y-m-d H:i:s');
          //dd($startSponsor);
        }else {
          $startSponsor = $apartment->sponsors()
            ->wherePivot('apartment_id', $apartment->id)
            ->orderBy('fine_sponsorizzazione', 'desc')
            ->first()
            ->getOriginal('pivot_fine_sponsorizzazione');
          // dd($sponsorRows);
        }

        $apartment->sponsors()->attach($apartment->id,
          [
            'inizio_sponsorizzazione' => $startSponsor,
            'fine_sponsorizzazione' => Carbon::parse($startSponsor)->addDay($duration),
            'sponsor_id' => $sponsor_id,
            'status_payment' => 'approvato',
          ]);

        return back()->with('success_message', 'Transaction successful. The ID is:'. $transaction->id);
    } else {
        $errorString = "";

        foreach ($result->errors->deepAll() as $error) {
            $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
        }

        // $_SESSION["errors"] = $errorString;
        // header("Location: index.php");
        return back()->withErrors('An error occurred with the message: '.$result->message);
    }
  }
}
