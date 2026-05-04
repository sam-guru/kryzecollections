<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingAddress;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'address_line_1' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postcode' => 'required|string|max:10',
        ]);

        // if this is the user's first address, make it default
        $isFirst = auth()->user()->shippingAddresses()->count() === 0;

        auth()->user()->shippingAddresses()->create([
            'address_line_1' => $request->address_line_1,
            'city' => $request->city,
            'postcode' => $request->postcode,
            'country' => $request->country ?? 'United Kingdom',
            'is_default' => $isFirst,
        ]);

        // Check if the request wants to stay in checkout
        if ($request->input('redirect') === 'checkout') {
            return redirect()->route('checkout.address')->with('success', 'Address added!');
        }

        return back()->with('success', 'Address saved successfully!');
    }


    public function destroy(ShippingAddress $address)
    {
        //ensure user owns the address before deleting
        if ($address->user_id === auth()->id()) {
            $address->delete();
        }
        return back()->with('success', 'Address removed.');
    }
}