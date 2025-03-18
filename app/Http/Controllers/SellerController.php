<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seller;
use Illuminate\Support\Facades\Mail;
use App\Mail\SellerVerification;

class SellerController extends Controller
{
    public function verification(Request $request){
        $request->validate([
            'selling_option' => 'required',
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'dob'            => 'required|date',
            'nationality'    => 'required|string|max:255',
            'street_address' => 'required|string|max:255',
            'city'           => 'required|string|max:255',
            'country'        => 'required|string|max:255',
            'postal_code'    => 'required|string|max:20',
            'main_photo_1'   => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'main_photo_2'   => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        // Store files
        $path_1 = $request->file('main_photo_1')->store('seller_verification', 'public');
        $path_2 = $request->file('main_photo_2')->store('seller_verification', 'public');
    
        // Save seller details
        $seller = Seller::create([
            'selling_option' => $request->selling_option,
            'first_name'     => $request->first_name,
            'middle_name'    => $request->middle_name,
            'last_name'      => $request->last_name,
            'dob'            => $request->dob,
            'nationality'    => $request->nationality,
            'street_address' => $request->street_address,
            'city'           => $request->city,
            'country'        => $request->country,
            'postal_code'    => $request->postal_code,
            'main_photo_1'   => "storage/$path_1",
            'main_photo_2'   => "storage/$path_2",
        ]);
    
        $sellerData = [
            'name'    => "{$seller->first_name} {$seller->last_name}",
            'status'  => 'Pending',
            'email'   => auth()->user()->email,
            'photo_1' => asset("storage/$path_1"),
            'photo_2' => asset("storage/$path_2"),
        ];
        
        // Queue Emails
        Mail::to(auth()->user()->email)->send(new SellerVerification($sellerData));
        Mail::to('gamify295@gmail.com')->send(new SellerVerification($sellerData));
        
        return redirect('/')->with('success', 'Verification submitted! Email is being processed.');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
