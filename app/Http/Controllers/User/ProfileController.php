<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return response()->json($request->user());
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'full_name' => 'sometimes|string',
            'phone' => 'nullable|string',
            'residence' => 'nullable|string',
            'gender' => 'nullable|string',
        ]);

        $user->update($data);

        return response()->json($user);
    }
}
