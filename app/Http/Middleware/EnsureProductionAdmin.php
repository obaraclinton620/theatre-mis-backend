<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureProductionAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        if ($user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // If route has production param, enforce ownership
        $production = $request->route('production');

        if ($production) {
            // Laravel 12: may be a model or an ID
            $productionId = is_object($production)
                ? $production->id
                : (int) $production;

            if ((int) $user->production_id !== (int) $productionId) {
                return response()->json([
                    'message' => 'Production not found'
                ], 404);
            }
        }

        return $next($request);
    }

}
