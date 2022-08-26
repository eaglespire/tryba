<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarketController;


//Market
Route::get('/', [MarketController::class, 'market'])->name('market');
Route::get('category/{cat}', [MarketController::class, 'marketcat'])->name('market.cat');
Route::get('country/{id}', [MarketController::class, 'marketcountry'])->name('market.country');
Route::post('search-market', [MarketController::class, 'searchmarket'])->name('search.market');