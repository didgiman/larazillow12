<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Offer;
use Gate;
use Illuminate\Http\Request;

class RealtorListingAcceptOfferController extends Controller
{
    public function __invoke(Offer $offer)
    {
        $listing = $offer->listing;
        Gate::authorize(
            'update',
            $listing
        );

        // Accept selected offer
        $offer->update([
            'accepted_at' => now()
        ]);

        $listing->sold_at = now();
        $listing->save();
        
        // Reject all other offers
        $listing->offers()->except($offer)->update([
            'rejected_at' => now()
        ]);

        return redirect()->back()->with('success', "Offer #{$offer->id} accepted. Other offers rejected.");
    }
}
