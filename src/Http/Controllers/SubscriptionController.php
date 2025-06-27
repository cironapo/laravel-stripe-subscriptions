<?php

namespace Cironapo\StripeSubscriptions\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Stripe\Stripe;
use Stripe\Price;
use Stripe\Product;

use function Illuminate\Log\log;

class SubscriptionController extends Controller
{

    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function index(Request $request)
    {
        return Inertia::render('Subscriptions/BillingPage');
    }


    function getPlans(Request $request){
        $plans = config('subscriptions.plans');

        foreach($plans as $i => $plan){
            $price = Price::retrieve($plan['monthly_id']);
            $plan['monthly_price'] = $price->unit_amount / 100;
            $price = Price::retrieve($plan['yearly_id']);
            $plan['yearly_price'] = $price->unit_amount / 100;
            $plans[$i] = $plan;
        }
        return response()->json($plans);
    }

    /**
     * Get Subscription Info
     *
     * @param Request $request
     * @return void
     */
    function getInfoSubscription(Request $request){
        $user = $request->user();
        $subscription = $user->subscription('default');
        if( $subscription ){
            $price = Price::retrieve($subscription->stripe_price);
            $product = Product::retrieve($price->product);
            $subscription->price = $price;
            $subscription->product = $product;
        }
        
        return response()->json([
            'subscription' => $subscription,
            'ended' =>  $subscription?->ended(),
            'canResume' => $subscription?->onGracePeriod()
        ]);
    }
 

    public function subscribe(Request $request)
    {
        $request->validate([
            'price' => 'required|string',
        ]);

        $user = $request->user();

        $subscription = $user->subscription('default');
        if( $subscription ){
            $user->subscription('default')->swap($request->price);
            return response()->json([
                'checkout_url' => route('billing'),
            ]);
        }else{
            //$succes_url = route('subscription.success').'?session_id={CHECKOUT_SESSION_ID}';
            /*return response()->json([
                'checkout_url' => $succes_url,
            ]);*/
            $session = $request->user()
            ->newSubscription('default', $request->price)
            //->trialDays(5)
            ->allowPromotionCodes()
            ->checkout();
            /*->checkout([
                'success_url' => $succes_url,
                'cancel_url' => route('subscription.cancel'),
            ]);*/

            return response()->json([
                'checkout_url' => $session->url,
            ]);
        }


        
    }

    /**
     * Cancel subscription
     *
     * @param Request $request
     * @return void
     */
    public function cancel(Request $request)
    {
        $user = $request->user();
        $subscription = $user->subscription('default');
        $subscription->cancel();
        return redirect()->route('billing');
    }

    /**
     * Resume subscription
     *
     * @param Request $request
     * @return void
     */
    public function resume(Request $request){
        $subscription = $request->user()->subscription('default');

        if ($subscription && $subscription->onGracePeriod()) {
            $subscription->resume();

            return back()->with('success', 'La sottoscrizione è stata ripristinata con successo.');
        }

        return back()->withErrors('Non è possibile ripristinare questa sottoscrizione.');
    }

    /**
     * Load invoices
     *
     * @param Request $request
     * @return void
     */
    function getInvoices(Request $request){
        return response()->json($request->user()->invoices()->map(function ($invoice) {
            return [
                'id' => $invoice->id,
                'date' => $invoice->date()->toDateString(),
                'total' => $invoice->total(),
                'status' => $invoice->asStripeInvoice()->status,
                'download_url' => route('invoice.download', $invoice->id),
            ];
        }));
    }

    /**
     * Downalod Invoice
     *
     * @param string $invoiceId
     * @param Request $request
     * @return void
     */
    function downloadInvoice(string $invoiceId, Request $request){
        return $request->user()->downloadInvoice($invoiceId, [
            'vendor' => 'Nome Azienda',
            'product' => 'Nome Prodotto/Servizio',
        ]);
    }


}