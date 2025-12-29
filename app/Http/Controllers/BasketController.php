<?php

namespace App\Http\Controllers;

use App\Models\BasketItem;
use App\Models\Performance;
use Illuminate\Http\Request;


class BasketController extends Controller
{
    public function index() {}

    public function store(Request $request)
    {
        $data = $request->validate([
            'performance_id' => 'required|exists:performances,id',
            'audience_count' => 'required|integer|min:1',
        ]);

        $user = auth()->user();

        $performance = Performance::where('id', $data['performance_id'])
            ->where('production_id', $user->production_id)
            ->firstOrFail();

        $pricePerAudience = $performance->price_per_audience;

        
        $totalPrice = $pricePerAudience * $request->audience_count;

        $basketItem = BasketItem::create([
            'production_id'       => $user->production_id,
            'user_id'             => $user->id,
            'performance_id'      => $performance->id,
            'audience_count'      => $data['audience_count'],
            'price_per_audience'  => $pricePerAudience,
            'price'               => $pricePerAudience * $data['audience_count'],
        ]);

        return response()->json($basketItem, 201);
    }


    public function update($id) {}
}
