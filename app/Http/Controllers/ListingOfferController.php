<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Offer;
use Illuminate\Http\Request;
use Gate;

class ListingOfferController extends Controller
{
    public function store(Listing $listing, Request $request)
    {
        Gate::authorize(
            'view',
            $listing
        );

        $listing->offers()->save(
            Offer::make(
                $request->validate([
                    'amount' => 'required|integer|min:1|max:100000000'
                ])
            )->bidder()->associate($request->user())
        );

        // $listing->offers()->create($request->validate([
        //     'amount' => 'required|integer|min:1|max:100000000'
        // ]))->bidder()->associate($request()->user());

        return redirect()->back()->with('success', 'Offer was made.');
    }
}
