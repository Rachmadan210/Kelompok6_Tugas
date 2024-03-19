<?php
namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function createAddress(Request $request)
    {
        $validatedData = $request->validate([
            'street' => 'required',
            'city' => 'required',
            'province' => 'required',
            'country' => 'required',
            'postal_code' => 'required',
        ]);

        $address = Auth::user()->addresses()->create($validatedData);

        return response()->json(['message' => 'Address created successfully', 'address' => $address], 201);
    }

    public function updateAddress(Request $request, $id)
    {
        $address = Auth::user()->addresses()->find($id);

        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }

        $address->update($request->all());

        return response()->json(['message' => 'Address updated successfully', 'address' => $address]);
    }

    public function getAddress($id)
    {
        $address = Auth::user()->addresses()->find($id);

        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }

        return response()->json(['address' => $address]);
    }

    public function listAddresses()
    {
        $addresses = Auth::user()->addresses()->get();

        return response()->json(['addresses' => $addresses]);
    }

    public function removeAddress($id)
    {
        $address = Auth::user()->addresses()->find($id);

        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }

        $address->delete();

        return response()->json(['message' => 'Address removed successfully']);
    }
}
