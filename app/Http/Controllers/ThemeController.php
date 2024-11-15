<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThemeController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'theme' => 'required|in:dark,light',
        ]);

        $user = User::whereId(Auth::id())->first();
        $user->theme = $request->theme;
        $user->save();

        return response()->json(['success' => true, 'theme' => $user->theme]);
    }
}
