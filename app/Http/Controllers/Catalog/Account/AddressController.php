<?php

namespace App\Http\Controllers\Catalog\Account;

use App\Models\User;
use App\Models\State;
use App\Models\Address;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['action'] = route('catalog.address');
        $data['countries'] = Country::all();
        $data['states'] = State::all();
        $data['addresses'] = Address::where('user_id', session('isUser'))->with('state', 'country')->get();
        $user = User::where('id', session('isUser'))->first('number');
        $data['user_number'] = $user->number;
        return view("catalog.account.address", $data);
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
        $validated = $request->validate([
            "name" => "required|max:255",
            "contact" => "required|min:10|max:10",
            "address_1" => "required|max:255",
            "address_2" => "required|max:255",
            "city" => "required|max:50",
            "pincode" => "required|min:6|max:6",
            "state_id" => "required",
            "country_id" => "required",
        ]);

        $address = Address::where('user_id', session('isUser'))->count();
        if($address && $address >= 10){
            return redirect()->route('catalog.address')->with('error', 'You can not add more than 10 addresses.');
        }

        $validated['user_id'] = session('isUser');

        Address::create($validated);

        return redirect()->route("catalog.address")->with('success', 'Added new address successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $address = Address::where('id', $id)->where('user_id', session('isUser'))->first();
        $address->update_address = true;
        return response()->json([
            'success' => true,
            'update_mode' => true,
            'address'=> $address
        ]);
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
        if($request->request->has('update_mode')){
            $validated = $request->validate([
                "name" => "required|max:255",
                "contact" => "required|min:10|max:10",
                "address_1" => "required|max:255",
                "address_2" => "required|max:255",
                "city" => "required|max:50",
                "pincode" => "required|min:6|max:6",
                "state_id" => "required",
                "country_id" => "required",
            ]);
    
            Address::where('id', $id)->where('user_id', session('isUser'))->update($validated);
    
            return redirect()->route("catalog.address")->with('success', 'Updated address successfully');
        }else{
            // Set default address
            if($request->request->has('default')){
                $validated['default'] = isset($validated['default']) && $validated['default'] === 'on';
                
                // Reset all addresses to default = false for the current user
                Address::where('user_id', session('isUser'))->update(['default' => false]);
        
                Address::where('id',$id)->where('user_id', session('isUser'))->update(['default' => true]);
                return redirect()->route("catalog.address")->with('success', 'Set default address successfully');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Address::where('id', $id)->where('user_id', session('isUser'))->delete();
        return redirect()->route("catalog.address")->with('success', 'Address deleted successfully');
    }
}
