<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RealtorListingController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'deleted' => $request->boolean('deleted'),
            ...$request->only(['sold', 'by', 'order'])
        ];

        // return inertia('Realtor/Index', ['listings' => Auth::user()->listings]);
        return inertia('Realtor/Index', [
            'filters' => $filters,
            'listings' => Auth::user()
                            ->listings()
                            ->filter($filters)
                            ->withCount('images')
                            ->withCount('offers')
                            ->paginate(5)
                            ->withQueryString()
        ]);
    }

    public function show(Listing $listing)
    {
        Gate::authorize('viewAsOwner', $listing); // Owner-only view logic

        return inertia('Realtor/Show', ['listing' => $listing->load('offers', 'offers.bidder')]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $this->authorize('create', Listing::class);

        return inertia('Realtor/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $listing = $request->user()->listings()->create(
            $request->validate([
                'beds' => 'required|integer|min:0|max:20',
                'baths' => 'required|integer|min:0|max:20',
                'area' => 'required|integer|min:15|max:1500',
                'city' => 'required',
                'code' => 'required',
                'street' => 'required',
                'street_nr' => 'required|min:1|max:10',
                'price' => 'required|integer|min:1|max:20000000'
            ])
        );

        return redirect()->route('realtor.listings.index')
            ->with('success', 'Listing was created')
            ->with('listingToHighlight', $listing->id);
    }

    public function destroy(Listing $listing)
    {
        Gate::authorize(
            'delete',
            $listing
        );

        $listing->deleteOrFail();

        return redirect()->back()
            ->with('success', 'Listing was deleted');
    }

    public function restore(Listing $listing)
    {
        $listing->restore();

        return redirect()->back()->with('success', 'Listing was restored.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        Gate::authorize(
            'update',
            $listing
        );

        return inertia('Realtor/Edit', [
            'listing' => $listing
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {
        Gate::authorize(
            'update',
            $listing
        );
        
        $listing->update(
            $request->validate([
                'beds' => 'required|integer|min:0|max:20',
                'baths' => 'required|integer|min:0|max:20',
                'area' => 'required|integer|min:15|max:1500',
                'city' => 'required',
                'code' => 'required',
                'street' => 'required',
                'street_nr' => 'required|min:1|max:99999999',
                'price' => 'required|integer|min:1|max:20000000'
            ])
        );

        return redirect()->route('realtor.listings.index')
            ->with('success', 'Listing was updated')
            ->with('listingToHighlight', $listing->id);
    }
}
