<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardSettingController extends Controller
{
    public function store(){
        return view('pages.dashboard-settings',[
            'user' => Auth::user(),
            'categories' => Category::all()
        ]);
    }

    public function account(){
        return view('pages.dashboard-account',[
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request,$redirect){

        $model = User::where('id',Auth::user()->id)->first();

        $validate=[
            'store_name' => 'nullable|max:255',
            'categories_id' => 'nullable|exists:categories,id',
            'store_status' => 'nullable|in:1,0',
            'email' => 'required|unique:users|email',
            'name' => 'required|string|max:50',
            'address_one' => 'nullable',
            'address_two' => 'nullable',
            'provinces_id' => 'nullable|exists:provinces,id',
            'regencies_id' => 'nullable|exists:regencies,id',
            'zip_code' => 'nullable',
            'country' =>'nullable',
            'phone_number' => 'nullable'
        ];

        // validasi untuk setting account
        if($model->email == $request->email){
            $validate['email'] = 'required|email';
        }

        // validasi untuk setting store
        if(!$request->name || !$request->email){
            $validate['name'] = 'nullable';
            $validate['email'] = 'nullable';
        }

        $data = $request->validate($validate);

        $item = Auth::user();
        
        $item->update($data);

        return redirect()->route($redirect);
    }

    public function uploadPhoto(Request $request){
        $lastPhoto = Auth::user()->photo;

        // hapus photo jika ada
        if($lastPhoto){
            $url = public_path('/storage/');
            unlink($url . $lastPhoto);
        }

        $data = $request->validate([
            'photo' => 'required|file|image|max:1024'
        ]);

        $data['photo'] = $request->file('photo')->store('assets/user','public');

        $item = Auth::user();
        $item->update($data);

        return redirect()->route('dashboard-setting-account');
    }
}
