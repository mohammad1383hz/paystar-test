<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        return view('product');
    }
    public function buy(Request $request)
    {


        $card_number = $request->card_number;
        if (strlen($card_number) !== 16) {
            return redirect()->route('index.product')->withErrors('cardnumber not valid');
        };
        $callback = env('APP_URL') . '/callback';
        $amount = 5000;
        $order_id = Str::random(10);

        $stringToSign = $amount . '#' . $order_id . '#' . $callback;
        $Secret = config('services.paystar.secret');
        $sign = hash_hmac('sha512', $stringToSign, $Secret);
        $arg = [
            "amount" =>  5000,
            "order_id" =>  $order_id,
            "callback" => $callback,
            "sign" =>  $sign,
            "card_number" => $card_number
        ];
        $gateway_id = config('services.paystar.gateway');

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $gateway_id
        ])->post('https://core.paystar.ir/api/pardakht/create', $arg);
        if ($response->json()['status'] == 1) {
            $token = $response->json()['data']['token'];
            $ref_num = $response->json()['data']['ref_num'];
            // create transaction
            $user = auth()->user();
            $transaction = new Transaction;
            $transaction->order_id = $order_id;
            $transaction->ref_num = $ref_num;
            $transaction->card_number = $card_number;
            $transaction->amount = $amount;
            $transaction->user_id = $user->id;
            $transaction->save();

            //redirect to pay page
            return Redirect::to('https://core.paystar.ir/api/pardakht/payment?card_number=' . $card_number . '&&token=' . $token);
        }
    }
    public function callback(Request $request)
    {
        // dd($request);
        // amount#ref_num#card_number#tracking_code

        if ($request->status == 1) {
            $gateway_id = config('services.paystar.gateway');
            $tracking_code = $request->tracking_code;
            $ref_num = $request->ref_num;
            $transaction = Transaction::where('ref_num', $ref_num)->first();
            // dd($transaction);

            $card_number = $transaction->card_number;
            // dd($card_number);

            $card_number = substr_replace($card_number, "******", 6, 6);

            if ($request->card_number == $card_number) {
                $amount = $transaction->amount;
                //amount#ref_num#card_number#tracking_code
                $stringToSign = $amount . '#' . $ref_num . '#' . $card_number . '#' . $tracking_code;
                $Secret = config('services.paystar.secret');
                $sign = hash_hmac('sha512', $stringToSign, $Secret);

                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $gateway_id
                ])->post('https://core.paystar.ir/api/pardakht/verify', [
                    "amount" => $amount,
                    "ref_num" => $ref_num,
                    "sign" => $sign,
                ]);

                $transaction->status = 1;
                $transaction->save();
                return redirect()->route('index.product')->with('succes', "pay succesfull");
            } else {
                return redirect()->route('index.product')->withErrors('the entered card number not match declared card number');
            }
        } else {
            return redirect()->route('index.product')->withErrors('pay not succesful');
        }
    }
}
