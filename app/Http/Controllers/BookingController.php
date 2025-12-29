<?php

namespace App\Http\Controllers;

use App\Models\Production;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        // list user's bookings (later)
    }

    public function store(Request $request)
    {
        $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        $user = $request->user();

        // STEP 1 — Get basket items
        $basketItems = \App\Models\BasketItem::where('user_id', $user->id)->get();
        
        $productionIds = $basketItems->pluck('production_id')->unique();

        if ($productionIds->count() > 1) {
            return response()->json([
                'message' => 'Basket contains items from multiple productions'
            ], 400);
        }

        if ($basketItems->isEmpty()) {
            return response()->json([
                'message' => 'Basket is empty'
            ], 400);
        }

        // STEP 2 — Derive production from basket (DO NOT trust client)
        $productionId = $basketItems->first()->production_id;
        $production = Production::findOrFail($productionId);

        // STEP 3 — Enforce subscription rule (this part you did RIGHT)
        // Block suspended productions
        if (!$production->active) {
            return response()->json([
                'message' => 'This production is currently suspended'
            ], 403);
        }

        //  Block expired subscriptions
        if (
            !$production->subscription_end ||
            Carbon::parse($production->subscription_end)->isPast()
        ) {
            return response()->json([
                'message' => 'Production subscription expired'
            ], 403);
        }


        // STEP 4 — Calculate total
        $totalAmount = $basketItems->sum('price');

        // STEP 5 — Create booking
        $booking = Booking::create([
            'user_id' => $user->id,
            'production_id' => $productionId,
            'total_amount' => $totalAmount,
            'status' => 'awaiting_payment',
            'notes' => $request->input('notes'),
        ]);

        // STEP 6 — Clear basket
        \App\Models\BasketItem::where('user_id', $user->id)->delete();
        

        return response()->json($booking, 201);
    }


    public function uploadProof(Request $request, $id)
    {
        // STEP 4.1 — Strict validation
        $request->validate([
            'payment_proof' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:2048', // 2MB
            ],
        ]);

        // 2️⃣ Get existing booking
        $booking = Booking::findOrFail($id);

        if ($booking->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }


        // 3️⃣ Store file safely
        $path = $request->file('payment_proof')
            ->store('payment_proofs', 'public');

        // 4️⃣ Update booking (NOT create)
        $booking->update([
            'payment_proof_url' => Storage::url($path),
            'status' => 'payment_uploaded',
        ]);

        // 5️⃣ Return response
        return response()->json([
            'message' => 'Payment proof uploaded successfully',
            'booking' => $booking,
        ]);
    }
    public function calendar($id)
    {
        // bookings for calendar view (later)
    }
}
