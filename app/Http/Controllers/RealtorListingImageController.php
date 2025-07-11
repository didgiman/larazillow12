<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use Storage;

class RealtorListingImageController extends Controller
{
    public function create($listing)
    {
        // $listing->load(['images']);
        $listing = Listing::withTrashed()->with('images')->findOrFail($listing);

        return inertia(
            'Realtor/ListingImage/Create',
            ['listing' => $listing]
        );
    }

    public function store($listing, Request $request)
    {
        if ($request->hasFile('images')) {

            $listing = Listing::withTrashed()->with('images')->findOrFail($listing);

            $request->validate([
                    'images.*' => 'mimes:jpg,png,jpeg,webp|max:5000'
                ],
                [
                    'images.*.mimes' => 'The files should be in one of these formats: jpg,png,jpeg,webp'
                ]
            );

            foreach($request->file('images') as $file) {
                $path = $file->store('listingimages', 'public');

                $listing->images()->save(new ListingImage([
                    'filename' => $path
                ]));
            }
            
            return redirect()->back()->with('success', 'Image(s) uploaded.');
        }

        return redirect()->back()->with('warning', 'No image were uploaded.');
    }

    public function destroy($listing, ListingImage $image)
    {
        Storage::disk('public')->delete($image->filename);
        $image->delete();

        return redirect()->back()->with('success', 'Image was deleted.');
    }
}
