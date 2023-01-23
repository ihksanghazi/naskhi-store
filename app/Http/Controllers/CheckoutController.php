<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionDetail;

use Exception;

use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;

class CheckoutController extends Controller
{
    public function process(Request $request){
        // Save User Data
        $user = Auth::user();
        $user->update($request->except('total_price'));

        // Process Checkout
        $code = 'STORE-'. mt_rand(00000,99999);
        $carts = Cart::with(['product','user'])
                    ->where('users_id',Auth::user()->id)
                    ->get();

        // transaction Create
        $transaction = Transaction::create([
            'users_id' => Auth::user()->id,
            'insurance_price'=> 0,
            'shipping_price'=> 0,
            'total_price'=> (int) $request->total_price ,
            'transaction_status'=>"PENDING",
            'code'=> $code,
        ]);

        // Transaction Detail
        foreach ($carts as $cart) {
            $trx = 'TRX-'. mt_rand(00000,99999);
            TransactionDetail::create([
                'transactions_id' => $transaction->id,
                'product_id' => $cart->product->id,
                'price' => $cart->product->price,
                'resi' => "",
                'shipping_status' => "PENDING",
                'code' => $trx,
            ]);
        }

        // Delete Cart Data
        Cart::where('users_id',Auth::user()->id)->delete();

        // Konfigurasi Midtrans

        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');
    
        // buat array untuk dikirim ke midtrans
        $midtrans = [
            "transaction_details"=> [
            "order_id" => $code,
            "gross_amount" => (int) $request->total_price,
            ],
            "customer_details"=> [
                "first_name" => Auth::user()->name,
                "email" => Auth::user()->email,
            ],
            "enabled_payments" => ['gopay','permata_va','bank_transfer'],
            "vtweb" => [],
        ];

        try {
            // Get Snap Payment Page URL
            $paymentUrl = \Midtrans\Snap::createTransaction($midtrans)->redirect_url;
            
            // Redirect to Snap Payment Page
            return redirect($paymentUrl);
        }catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function callback(Request $requset){
        // set konfigurasi midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // instance midtrans notifications
        $notification = new Notification();

        //assign ke variable untuk memudahkan coding
        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud= $notification->fraud_status;
        $orderId= $notification->order_id;

        //cari transaksi berdasarkan id
        $transactionn = Transaction::findOrFail($orderId);
        
        // Handle Notification status
        if ($status == 'capture') {
            if($type == 'credit_card'){
                if($fraud == 'challenge'){
                    $transactionn->status = 'PENDING';
                }else{
                    $transactionn->status = 'PENDING';
                }
                
            }
        }
        else if($status == 'settlement'){
            $transactionn->status = 'SUCCESS';
        }
        else if($status == 'pending'){
            $transactionn->status = 'PENDING';
        }
        else if($status == 'deny'){
            $transactionn->status = 'CANCELLED';
        }
        else if($status == 'expire'){
            $transactionn->status = 'CANCELLED';
        }
        else if($status == 'cancel'){
            $transactionn->status = 'CANCELLED';
        }

        //simpan transaksi
        $transactionn->save();
    }
}
