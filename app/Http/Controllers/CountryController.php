<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function index(Request $request)
    { 
        Log::info('Filtering country: '.$request);
        $resource = Country::all();
        return response()->json($resource, 200);
    }

    public function store(Request $request)
    {
        Log::info('Creating country: '.$request);
        $input = $request->json()->all();
        $resource = Country::create($input);
        return response()->json($resource, 201);
    }

    public function show($id)
    {
        Log::info('Showing country: '.$id);
        $resource = Country::find($id);
        return response()->json($resource, 200);
    }

    public function update(Request $request, $id)
    { 
        Log::info('Updating country: '.$id);
        $input = $request->json()->all();
        $resource = Country::findOrFail($id);
        $resource->fill($input);
        $resource->save();
        return response()->json($resource, 200);
    }

    public function destroy($id)
    {
        Log::info('Deleting country: '.$id);
        $resource = Country::findOrFail($id);
        $resource->delete();
        return response()->json('country removed successfully', 200);
    }
}
