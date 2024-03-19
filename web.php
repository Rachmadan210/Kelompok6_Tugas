<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AddressController;

// Routes for User
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::middleware('auth')->group(function () {
    Route::put('/user', [UserController::class, 'updateUser'])->name('user.update');
    Route::get('/user', [UserController::class, 'getUser'])->name('user.get');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
});

// Routes for Contact
Route::middleware('auth')->group(function () {
    Route::post('/contacts', [ContactController::class, 'createContact'])->name('contacts.create');
    Route::put('/contacts/{id}', [ContactController::class, 'updateContact'])->name('contacts.update');
    Route::get('/contacts/{id}', [ContactController::class, 'getContact'])->name('contacts.get');
    Route::get('/contacts', [ContactController::class, 'searchContact'])->name('contacts.search');
    Route::delete('/contacts/{id}', [ContactController::class, 'removeContact'])->name('contacts.remove');
});

// Routes for Address
Route::middleware('auth')->group(function () {
    Route::post('/addresses', [AddressController::class, 'createAddress'])->name('addresses.create');
    Route::put('/addresses/{id}', [AddressController::class, 'updateAddress'])->name('addresses.update');
    Route::get('/addresses/{id}', [AddressController::class, 'getAddress'])->name('addresses.get');
    Route::get('/addresses', [AddressController::class, 'listAddresses'])->name('addresses.list');
    Route::delete('/addresses/{id}', [AddressController::class, 'removeAddress'])->name('addresses.remove');
});
