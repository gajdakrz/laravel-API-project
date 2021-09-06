<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Delegation;
use App\Models\Country;
use Illuminate\Http\Request;

class DelegationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function index(Request $request)
    { 
        $params = $request->except('_token');
        $resource = Delegation::filter($params)->get();
        Log::info('Filtering delegation: '.$request);
        return response()->json($resource, 200);
    }

    public function store(Request $request)
    {
        $input = $request->json()->all();
        

        $countries = Country::all();
        $validate = Delegation::validate($input, $countries);
        list($error_message, $new_input) = $validate;

        if ($error_message === '') {
            $resource = Delegation::create($new_input);   
            Log::info('Creating delegation: '.$request);
            return response()->json($resource, 201);
        } else {
            return response()->json($error_message, 422);
        }
    }

    public function show($id)
    {
        $resource = Delegation::find($id);
        Log::info('Showing delegation: '.$id);
        return response()->json($resource, 200);
    }

    public function update(Request $request, $id)
    { 
        $input = $request->json()->all();
        $resource = Delegation::findOrFail($id);
        $resource->fill($input);
        $resource->save();
        Log::info('Updating delegation: '.$id);
        return response()->json($resource, 200);
    }

    public function destroy($id)
    {
        $resource = Delegation::findOrFail($id);
        $resource->delete();
        Log::info('Deleting delegation: '.$id);
        return response()->json('delegation removed successfully', 200);
    }
}
