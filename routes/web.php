<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Auth::routes(['register' => false]);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')
        ->name('home');

    Route::get('/sales-purchases/chart-data', 'HomeController@salesPurchasesChart')
        ->name('sales-purchases.chart');

    Route::get('/current-month/chart-data', 'HomeController@currentMonthChart')
        ->name('current-month.chart');

    Route::get('/payment-flow/chart-data', 'HomeController@paymentChart')
        ->name('payment-flow.chart');
});

Route::get('/media/{path}', function ($path) {
    $path = urldecode($path);

    if (!Storage::disk('public')->exists($path)) {
        abort(404, 'File tidak ditemukan: ' . $path);
    }

    return response()->file(
        Storage::disk('public')->path($path)
    );
})->where('path', '.*')->name('media.show');

Route::delete('/media/{media}', function ($media) {

    $media = \Spatie\MediaLibrary\MediaCollections\Models\Media::findOrFail($media);

    $media->delete();

    return response()->json([
        'success' => true,
        'message' => 'Media berhasil dihapus'
    ]);

})->middleware('auth');