<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Auth\LoginController@showLoginForm');

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('dashboard');

/**
 * Stock Route
 */
Route::prefix('stock')->group(function () {
    Route::get('/add', 'StockController@index')->name('stock.add');
    Route::post('save-purchase', 'StockController@save_purchase')->name('stock.save-purchase');
    Route::get('/', 'StockController@manage')->name('stock.manage');
    Route::get('/view/{id}', 'StockController@stock_details')->name('stock.view-details');
    Route::get('/edit/{id}', 'StockController@edit')->name('stock.edit');
    Route::post('/update/', 'StockController@update')->name('stock.update');
    Route::get('/delete/{id}', 'StockController@delete')->name('stock.delete');
});

/**
 * Supplier Route
 */
Route::prefix('supplier')->group(function () {
    Route::get('/', 'SupplierController@index')->name('supplier');
    Route::post('/store', 'SupplierController@store')->name('supplier.store');
    Route::get('/unpublished/{id}', 'SupplierController@unpublished')->name('supplier.unpublished');
    Route::get('/published/{id}', 'SupplierController@published')->name('supplier.published');
    Route::post('/update', 'SupplierController@update')->name('supplier.update');
    Route::post('/delete', 'SupplierController@delete')->name('supplier.delete');
});

/**
 * Brand Route
 */
Route::prefix('brand')->group(function () {
    Route::get('/', 'BrandController@index')->name('brand');
    Route::post('/store', 'BrandController@store')->name('brand.store');
    Route::get('/unpublished/{id}', 'BrandController@unpublished')->name('brand.unpublished');
    Route::get('/published/{id}', 'BrandController@published')->name('brand.published');
    Route::post('/update', 'BrandController@update')->name('brand.update');
    Route::post('/delete', 'BrandController@delete')->name('brand.delete');
});

/**
 * Category Route
 */
Route::prefix('category')->group(function () {
    Route::get('/', 'CategoryController@index')->name('category');
    Route::post('/store', 'CategoryController@store')->name('category.store');
    Route::get('/unpublished/{id}', 'CategoryController@unpublished')->name('category.unpublished');
    Route::get('/published/{id}', 'CategoryController@published')->name('category.published');
    Route::post('/update', 'CategoryController@update')->name('category.update');
    Route::post('/delete', 'CategoryController@delete')->name('category.delete');
});

/**
 * Supplier Payment Route
 */
Route::prefix('payment')->group(function () {
    Route::get('/', 'PaymentController@index')->name('payment');
    Route::post('/supplier', 'PaymentController@save_supplier_payment')->name('payment.supplier');
    Route::get('/details/{id}', 'PaymentController@payment_details')->name('payment.details');
});