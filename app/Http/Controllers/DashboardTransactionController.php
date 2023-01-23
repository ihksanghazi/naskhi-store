<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;

class DashboardTransactionController extends Controller
{
    public function index(){
        $selltransactions = TransactionDetail::with(['transaction.user','product.galleries'])
                        ->whereHas('product',function($product){
                            $product->where('users_id',Auth::user()->id);
                        })->get();
        $buyTransactions = TransactionDetail::with(['transaction.user','product.galleries'])
                        ->whereHas('transaction',function($transaction){
                            $transaction->where('users_id',Auth::user()->id);
                        })->get();
        return view('pages.dashboard-transactions',[
            'sellTransactions' => $selltransactions,
            'buyTransactions' => $buyTransactions
        ]);
    }

    public function detail(TransactionDetail $transactionDetail){
        $transactionDetail->with(['transaction.user','product.galleries']);
        return view('pages.dashboard-transaction-detail',[
            'transaction' => $transactionDetail
        ]);
    }

    public function update(TransactionDetail $transactionDetail, Request $request){
        $data = $request->all();
        $transactionDetail->update($data);

        return redirect()->route('dashboard-transaction-detail',$transactionDetail->id);
    }
}
