<?php

use App\Models\{
    Comment,
    Course,
    Image,
    Permission,
    Preference,
    Tag,
    User
};
use Illuminate\Support\Facades\Route;

route::get('/many-to-many-polymorphyc', function(){
    //$course = Course::first();

    // Tag::create(['name' => 'tag1', 'color' => 'blue']);
    // Tag::create(['name' => 'tag2', 'color' => 'red']);
    // Tag::create(['name' => 'tag3', 'color' => 'green']);

    //$course->tags()->attach([2]);

    //dd($course->tags);

    $tag = Tag::find(2);
    dd($tag->courses);
});

Route::get('/one-to-many-polymorphyc', function(){
    //$course = Course::first();

    // $course->comments()->create([
    //     'subject' => 'Novo Comentário 2',
    //     'content' => 'Apenas (2) um comentário legal.'
    // ]);

    //dd($course->comments);

    $comment = Comment::find(1);
    dd($comment->commentable);
});

Route::get('/one-to-one-polymorphyc', function(){
    $user = User::find(1);

    $data = ['path' => 'nome-imagem2.png'];

    $user->image->delete();

    if ($user->image) {
        $user->image->update($data);
    } else {
        //
        $user->image()->create($data);
    }



    dd($user->image);
});

Route::get('/many-to-many-pivot', function(){
    $user = User::with('permissions')->find(1);
    //dd($user->érmissions);

    $user->permissions()->attach([
        1 => ['active' => false],
        3 => ['active' => false]
    ]);

    $user->refresh();

    echo "{$user->name} <br>";
    foreach ($user->permissions as $permission) {
        echo "{$permission->name} - {$permission->pivot->active} <br>";
    }
});

Route::get('/many-to-many', function(){

    //dd(Permission::create(['name' => 'menu_03']));

    $user = User::with('permissions')->find(1);

    //$permission = Permission::find(1);
    //$user->permissions()->save($permission);
    // $user->permissions()->saveMany([
    //     Permission::find(1),
    //     Permission::find(2),
    //     Permission::find(3),
    // ]);

    //$user->permissions()->sync([2]);
    //$user->permissions()->attach([1,3]);
    $user->permissions()->detach([1,3]);

    $user->refresh();

    dd($user->permissions);
});

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
