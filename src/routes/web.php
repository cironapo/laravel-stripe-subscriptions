<?php

use Illuminate\Support\Facades\Route;
use Cironapo\StripeSubscriptions\Http\Controllers\SubscriptionController;
use Cironapo\StripeSubscriptions\Http\Controllers\StripeWebhookController;
use Illuminate\Http\Request;

Route::middleware(['web','auth'])->group(function () {
    Route::get('/billing', [SubscriptionController::class, 'index'])->name('billing');
    Route::get('/subscription/info', [SubscriptionController::class, 'getInfoSubscription'])->name('subscription.info');
    
    Route::get('/subscription/plans', [SubscriptionController::class, 'getPlans'])->name('subscription.plans');
    Route::post('/subscription/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscription.subscribe');
    Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
    Route::post('/subscription/resume', [SubscriptionController::class, 'resume'])->name('subscription.resume');
    Route::get('/subscription/success', [SubscriptionController::class, 'success'])->name('subscription.success');
    
    Route::get('/billing-portal', function (Request $request) {
        return $request->user()->redirectToBillingPortal(route('billing'));
    });

    Route::get('/invoices/{invoice}',[SubscriptionController::class, 'downloadInvoice'])->name('invoice.download');
    Route::get('/invoices', [SubscriptionController::class, 'getInvoices'])->name('invoice.list');

    Route::get('/billing-portal', function (Request $request) {
        return $request->user()->redirectToBillingPortal(route('billing'));
    });
});

//workaround stripe cli
//Route::post('/stripe/webhook', [StripeWebhookController::class, '__invoke']);