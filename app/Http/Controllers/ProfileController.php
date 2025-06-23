<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Show the biodata edit form
    public function edit()
    {
        $user = Auth::user(); // Get currently logged-in user
        return view('profile.edit', compact('user'));
    }

    // Handle the biodata update
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'phone' => 'required|numeric|digits:10',
            'title' => 'required|string',
            'id_passport' => 'required|string',
            'kra_pin' => 'required|string',
            'county' => 'required|string',
            'sub_county' => 'required|string',
            'ethnicity' => 'required|string',
            'gender' => 'required|string',
            'nationality' => 'required|string',
            'dob' => 'required|date',
            'disability_status' => 'required|string|max:15|in:yes,no',
            'disability_certificate_number' => 'required_if:disability_status,yes|nullable|string|max:25', 
        ]);

        $user->update($validated);

        return redirect()->route('profile')->with('success', 'Biodata updated successfully!');
    }
}
