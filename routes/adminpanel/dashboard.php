<?php



Route::group(

    [

        'prefix' => 'dashboard/',

        'as'     =>  'dashboard.',

    ],

    function () {

      Route::get('','AdminController@index')->name('index');

    });
