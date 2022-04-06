<?php

use App\Models\{
    Preference,
    User
};
use Illuminate\Support\Facades\Route;


Route::get('/one-to-one', function(){
    $user = User::with('preference')->find(2);

    $data = [
        'background_color' => '#fcfcfc'
    ];

    if($user->Preference){
        $user->Preference->update($data);
    }else {
        $user->Preference()->create($data);
    }

    $user->refresh();

   var_dump($user->Preference);

    $user->preference->delete();

    $user->refresh();

    dd($user->Preference);
});

Route::get('/', function () {
    return view('welcome');
});
