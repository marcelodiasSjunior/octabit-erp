<?php

use App\Http\Controllers\Api\QuoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('quotes', QuoteController::class);
Route::post('webhooks/leads', \App\Http\Controllers\Api\LeadWebhookController::class)->middleware('throttle:60,1');
Route::patch('quotes/{id}/send', [QuoteController::class, 'markAsSent']);
Route::patch('quotes/{id}/approve', [QuoteController::class, 'approve']);
Route::patch('quotes/{id}/reject', [QuoteController::class, 'reject']);
Route::post('quotes/{id}/convert-to-sale', [QuoteController::class, 'convertToSale']);
Route::get('quotes/{id}/pdf', [QuoteController::class, 'pdf'])->name('api.quotes.pdf');
