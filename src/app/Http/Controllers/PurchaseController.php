<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\Item;
use App\Models\Purchase;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class PurchaseController extends Controller
{
    public function create($item_id)
    {
        $item = Item::findOrFail($item_id);

        if ($item->isSold()) {
            return redirect('/');
        }

        $shippingAddress = session()->get('shipping_address', [
            'postal_code' => auth()->user()->postal_code,
            'address'     => auth()->user()->address,
            'building'    => auth()->user()->building,
        ]);

        $paymentMethods = Purchase::PAYMENT_METHODS;

        return view('purchase.create', compact('item', 'shippingAddress', 'paymentMethods'));
    }

    public function store(PurchaseRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        if ($item->isSold()) {
            return redirect('/');
        }

        $shippingAddress = session()->get('shipping_address', [
            'postal_code' => auth()->user()->postal_code,
            'address'     => auth()->user()->address,
            'building'    => auth()->user()->building,
        ]);

        Purchase::create([
            'user_id' => auth()->id(),
            'item_id' => $item->id,
            'payment_method' => $request->payment_method,
            'shipping_postal_code' => $shippingAddress['postal_code'],
            'shipping_address' => $shippingAddress['address'],
            'shipping_building' => $shippingAddress['building'],
        ]);

        session()->forget('shipping_address');

        if ($request->payment_method == 1) {
            return redirect('/');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'unit_amount' => $item->price,
                    'product_data' => [
                        'name' => $item->name,
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('/'),
            'cancel_url' => url('/'),
        ]);

        return redirect()->away($session->url);
    }
}
