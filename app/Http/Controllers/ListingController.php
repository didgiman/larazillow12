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
}
