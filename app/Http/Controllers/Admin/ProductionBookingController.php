<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class ProductionBookingController extends Controller
{
    /**
     * List all bookings for a production (admin view)
     */
    public function index($productionId)
    {
        // 🔐 Ensure admin belongs to this production
        if ((int) auth()->user()->production_id !== (int) $productionId) {
            return response()->json([
                'message' => 'Unauthorized production access'
            ], 403);
        }

        $bookings = Booking::where('production_id', $productionId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($bookings);
    }

    /**
     * Confirm a booking (admin only)
     */
    public function confirm(Booking $booking)
    {
        // 🔐 Ensure admin belongs to this production
        if ($booking->production_id !== auth()->user()->production_id) {
            return response()->json([
                'message' => 'Unauthorized production access'
            ], 403);
        }

        // 🔁 Prevent reconfirmation
        if ($booking->status === 'confirmed') {
            return response()->json([
                'message' => 'Booking already confirmed'
            ], 400);
        }

        // 🚫 Double-book prevention
        $conflict = Booking::where('production_id', $booking->production_id)
            ->where('date', $booking->date)
            ->where('time', $booking->time)
            ->where('status', 'confirmed')
            ->where('id', '!=', $booking->id)
            ->exists();

        if ($conflict) {
            return response()->json([
                'message' => 'This date and time is already booked'
            ], 409);
        }

        // ✅ Confirm booking
        $booking->update([
            'status' => 'confirmed'
        ]);

        return response()->json([
            'message' => 'Booking confirmed successfully',
            'booking' => $booking
        ]);
    }

    /**
     * Edit a booking (admin only)
     */
    public function update(Request $request, Booking $booking)
    {
        // 🔐 Ensure admin belongs to this production
        if ($booking->production_id !== auth()->user()->production_id) {
            return response()->json([
                'message' => 'Unauthorized production access'
            ], 403);
        }

        // 🔒 Prevent editing confirmed bookings
        if ($booking->status === 'confirmed') {
            return response()->json([
                'message' => 'Confirmed bookings cannot be edited'
            ], 400);
        }

        $validated = $request->validate([
            'date'  => 'sometimes|date',
            'time'  => 'sometimes',
            'notes' => 'nullable|string',
        ]);

        $booking->update($validated);

        return response()->json([
            'message' => 'Booking updated successfully',
            'booking' => $booking
        ]);
    }
}
