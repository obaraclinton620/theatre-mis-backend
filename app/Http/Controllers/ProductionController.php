<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Production;




class ProductionController extends Controller
{
    public function index()
    {
        // list productions (later)
    }

    public function show($slug)
    {
        // show single production by slug (later)
    }
    public function calendar(Request $request, Production $production)
    {
        // 1 Get month query param
        $month = $request->query('month'); // expected: YYYY-MM

        if (!$month) {
            return response()->json([
                'error' => 'month query parameter is required'
            ], 422);
        }

        // 2 Validate month format safely
        try {
            $start = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Invalid month format. Expected YYYY-MM'
            ], 422);
        }

        $end = (clone $start)->endOfMonth();

        // 3️⃣ Fetch bookings for this production in that month
        $bookings = Booking::where('production_id', $production->id)
            ->whereBetween('date', [
                $start->toDateString(),
                $end->toDateString()
            ])
            ->get();

        // STEP 6 — Group bookings by date (RAW)
        $dates = [];

        foreach ($bookings as $booking) {
            $date = Carbon::parse($booking->date)->toDateString();
            $dates[$date][] = $booking->status;
        }

        //  STEP 7 — Decide calendar status per date
        $calendar = [];

        foreach ($dates as $date => $statuses) {
            if (in_array('confirmed', $statuses)) {
                $calendar[$date] = 'booked';
            } elseif (in_array('payment_uploaded', $statuses)) {
                $calendar[$date] = 'pending';
            } else {
                $calendar[$date] = 'available';
            }
        }

        //  STEP 8 — Fill missing dates as available
        $cursor = $start->copy();

        while ($cursor <= $end) {
            $d = $cursor->toDateString();

            if (!isset($calendar[$d])) {
                $calendar[$d] = 'available';
            }

            $cursor->addDay();
        }

        // Ensure dates are in ascending order
        ksort($calendar);

        // 4 Return full calendar
        return response()->json([
            'production_id' => $production->id,
            'month' => $month,
            'dates' => $calendar
        ]);
    }


}

