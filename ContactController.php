<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function createContact(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:contacts',
            'phone' => 'required',
        ]);

        $contact = Auth::user()->contacts()->create($validatedData);

        return response()->json(['message' => 'Contact created successfully', 'contact' => $contact], 201);
    }

    public function updateContact(Request $request, $id)
    {
        $contact = Auth::user()->contacts()->find($id);

        if (!$contact) {
            return response()->json(['message' => 'Contact not found'], 404);
        }

        $contact->update($request->all());

        return response()->json(['message' => 'Contact updated successfully', 'contact' => $contact]);
    }

    public function getContact($id)
    {
        $contact = Auth::user()->contacts()->find($id);

        if (!$contact) {
            return response()->json(['message' => 'Contact not found'], 404);
        }

        return response()->json(['contact' => $contact]);
    }

    public function searchContact(Request $request)
    {
        $query = $request->input('query');

        $contacts = Auth::user()->contacts()
            ->where('first_name', 'LIKE', "%$query%")
            ->orWhere('last_name', 'LIKE', "%$query%")
            ->orWhere('email', 'LIKE', "%$query%")
            ->orWhere('phone', 'LIKE', "%$query%")
            ->get();

        return response()->json(['contacts' => $contacts]);
    }

    public function removeContact($id)
    {
        $contact = Auth::user()->contacts()->find($id);

        if (!$contact) {
            return response()->json(['message' => 'Contact not found'], 404);
        }

        $contact->delete();

        return response()->json(['message' => 'Contact removed successfully']);
    }
}
