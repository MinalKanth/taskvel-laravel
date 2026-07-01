<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThemeController extends Controller
{
    /**
     * Update application theme.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'theme' => 'required|in:light,dark,system',
            'accent' => 'nullable|in:blue,green,purple,red,orange,teal',
            'sidebar' => 'nullable|in:expanded,collapsed',
        ]);

        session([
            'theme' => $validated['theme'],
            'accent' => $validated['accent'] ?? 'blue',
            'sidebar' => $validated['sidebar'] ?? 'expanded',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Theme updated successfully.',
        ]);
    }

    /**
     * Get current theme settings.
     */
    public function current()
    {
        return response()->json([
            'theme' => session('theme', 'system'),
            'accent' => session('accent', 'blue'),
            'sidebar' => session('sidebar', 'expanded'),
        ]);
    }

    /**
     * Reset theme settings to defaults.
     */
    public function reset(Request $request)
    {
        $request->session()->forget([
            'theme',
            'accent',
            'sidebar',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Theme settings reset successfully.',
            'theme' => 'system',
            'accent' => 'blue',
            'sidebar' => 'expanded',
        ]);
    }
}