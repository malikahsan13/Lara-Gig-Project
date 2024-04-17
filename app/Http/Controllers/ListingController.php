<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    // Show all listings
    public function index()
    {
        //dd(request()->query("tag"));
        return view('listings.index', [
            "heading" => "Latest Listings",
            "listings" => \App\Models\Listing::latest()
            ->filter(request(['tag', "search"]))
            // ->paginate(2)
            ->simplePaginate(2)
        ]);
    }

    //Show single listing
    public function show($id)
    {
        $listing = \App\Models\Listing::find(($id));
        //dd($listing);
        if($listing)
        {
            return view("listings.show", [
                "listing" => $listing
            ]);
        } else {
            abort(404);
        }
    }

    public function create()
    {
        return view("listings.create");
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            "title" => "required",
            "company" => "required",
            "location" => "required",
            "website" => "required",
            "email" => ["required", "email"],
            "tags" => "required",
            "description" => "required"

        ]);
        
        if($request->hasFile('logo'))
        {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] =  auth()->user()->id;

        Listing::create($formFields);
        
        // Session::flash()

        return redirect("/")->with('message', "Listing Created Successfully!");
    }

    public function edit(Listing $listing)
    {
        return view("listings.edit", ['listing' => $listing]);
    }

    public function update(Request $request,Listing $listing)
    {
        if($listing->user_id != auth()->id())
        {
            abort(403, "Unauthorized Action");
        }
        $formFields = $request->validate([
            "title" => "required",
            "company" => "required",
            "location" => "required",
            "website" => "required",
            "email" => ["required", "email"],
            "tags" => "required",
            "description" => "required"

        ]);
        
        if($request->hasFile('logo'))
        {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formFields);
        
        // Session::flash()

        return back()->with('message', "Listing Updated Successfully!");
    }

    public function destroy(Listing $listing)
    {
        $listing->delete();
        return redirect("/")->with('message', "Listing Deleted Successfully!");
    }

    public function manage()
    {
        return view("listings.manage", ['listings' => auth()->user()->listings]);
    }
}
