<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function uploadProof(Request $request, $productionId)
    {
        $request->validate([
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $subscription = Subscription::firstOrCreate(
            ['production_id' => $productionId],
            ['status' => 'pending']
        );

        $path = $request->file('payment_proof')
            ->store('subscription_proofs', 'public');

        $subscription->update([
            'payment_proof_url' => '/storage/' . $path,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Payment proof uploaded. Awaiting approval.',
            'subscription' => $subscription
        ]);
    }
    public function approve($subscriptionId)
    {
        $subscription = Subscription::findOrFail($subscriptionId);

        $subscription->update([
            'status' => 'paid',
            'start_date' => now(),
            'end_date' => now()->addMonth(),
        ]);

        // Update production
        $subscription->production->update([
            'active' => true,
            'subscription_end' => $subscription->end_date,
        ]);

        return response()->json([
            'message' => 'Subscription approved',
            'subscription' => $subscription
        ]);
    }

}
