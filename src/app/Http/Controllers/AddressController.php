<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;

class AddressController extends Controller
{
    public function edit($item_id)
    {
        $shippingAddress = session()->get('shipping_address', [
            'postal_code' => auth()->user()->postal_code,
            'address'     => auth()->user()->address,
            'building'    => auth()->user()->building,
        ]);

        return view('purchase.edit', compact('shippingAddress', 'item_id'));
    }

    public function update(AddressRequest $request, $item_id)
    {
        $validated = $request->validated();

        session(['shipping_address' => [
            'postal_code' => $validated['shipping_postal_code'],
            'address'     => $validated['shipping_address'],
            'building'    => $validated['shipping_building'],
        ]]);

        return redirect('/purchase/' . $item_id);
    }
}
