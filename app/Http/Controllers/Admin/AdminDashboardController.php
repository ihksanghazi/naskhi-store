<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class AdminDashboardController extends Controller
{
    public function index(){
        $user = User::count(); 
        $revenue = Transaction::sum('total_price');
        $transactions = Transaction::count();
        return view('pages.admin.dashboard',[
            'users' => $user,
            'revenue' => $revenue,
            'transactions' => $transactions,

        ]);
    }
}
