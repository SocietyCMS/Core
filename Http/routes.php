<?php

Route::group(['namespace' => 'Modules\Core\Http\Controllers'], function () {
    Route::get('/', 'CoreController@index');
});
