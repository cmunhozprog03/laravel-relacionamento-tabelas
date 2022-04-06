<?php

use App\Models\{
    Course,
    Preference,
    User
};
use Illuminate\Support\Facades\Route;

Route::get('/one-to-many', function(){
    //$course = Course::create(['name' => 'Curso Laravel']);

    $course = Course::with('modules.lessons')->first();
    //dd($course);

    echo $course->name;
    echo '<br>';
    foreach ($course->modules as $module) {
        echo "Módulo {$module->name} <br>";

        foreach ($module->lessons as $lesson) {
            echo "Aula {$lesson->name} <br>";
        }
    }


    $data = ['name' => 'Módulo x2'];

    //$course->modules()->create($data);

    //$course->modules()->get();
    $modules = $course->modules;

    dd($modules);
});

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
