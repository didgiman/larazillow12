<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Gate;

class ListingController extends Controller
{
    // use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Gate::authorize(
        //     'viewAny',
        //     Listing::class
        // );

        $filters = $request->only([
            'priceFrom', 'priceTo', 'beds', 'baths', 'areaFrom', 'areaTo'
        ]);

        // $query = Listing::with('owner')->orderBy('created_at', 'desc')
        //     ->when(
        //         $filters['priceFrom'] ?? false,
        //         fn ($query, $value) => $query->where('price', '>=', $value)
        //     )
        //     ->when(
        //         $filters['priceTo'] ?? false,
        //         fn ($query, $value) => $query->where('price', '<=', $value)
        //     )
        //     ->when(
        //         $filters['beds'] ?? false,
        //         fn ($query, $value) => $query->where('beds', $value)
        //     )
        //     ->when(
        //         $filters['baths'] ?? false,
        //         fn ($query, $value) => $query->where('baths', $value)
        //     )
        //     ->when(
        //         $filters['areaFrom'] ?? false,
        //         fn ($query, $value) => $query->where('price', '>=', $value)
        //     )
        //     ->when(
        //         $filters['areaTo'] ?? false,
        //         fn ($query, $value) => $query->where('price', '<=', $value)
        //     );

        // if ($filters['priceFrom'] ?? false) {
        //     $query->where('price', '>=', $filters['priceFrom']);
        // }
        // if ($filters['priceTo'] ?? false) {
        //     $query->where('price', '<=', $filters['priceTo']);
        // }
        // if ($filters['beds'] ?? false) {
        //     $query->where('beds', $filters['beds']);
        // }
        // if ($filters['baths'] ?? false) {
        //     $query->where('baths', $filters['baths']);
        // }
        // if ($filters['areaFrom'] ?? false) {
        //     $query->where('area', '>=', $filters['areaFrom']);
        // }
        // if ($filters['areaTo'] ?? false) {
        //     $query->where('area', '<=', $filters['areaTo']);
        // }

        return inertia('Listing/Index', [
            'filters' => $filters,
            'listings' => Listing::with('owner')->latest()
                ->filter($filters) // filters scope in Listing model
                ->paginate(10)
                ->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $this->authorize('create', Listing::class);

        return inertia('Listing/Create');
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

        return redirect()->route('listings.index')
            ->with('success', 'Listing was created')
            ->with('listingToHighlight', $listing->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        // Auth::user()->can('view', $listing);

        // $this->authorize('view', $listing);

        Gate::authorize(
            'view',
            $listing
        );

        return inertia('Listing/Show', [
            'listing' => $listing
        ]);
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

        return inertia('Listing/Edit', [
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

        return redirect()->route('listings.index')
            ->with('success', 'Listing was updated')
            ->with('listingToHighlight', $listing->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        $listing->delete();

        return redirect()->back()
            ->with('success', 'Listing was deleted');
    }
}
