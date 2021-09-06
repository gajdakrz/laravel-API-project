<?php

namespace App\Http\Controllers;

use Log;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function index(Request $request)
    { 
        Log::info('Filtering user: '.$request);
        $resource = User::all();
        return response()->json($resource, 200);
    }

    public function store(Request $request)
    {
        Log::info('Creating user: '.$request);
        $input = $request->json()->all();
        $resource = User::create($input);
        return response()->json($resource, 201);
    }

    public function show($id)
    {
        Log::info('Showing user: '.$id);
        $resource = User::find($id);
        return response()->json($resource, 200);
    }

    public function update(Request $request, $id)
    { 
        Log::info('Updating user: '.$id);
        
        $input = $request->json()->all();
        $resource = User::findOrFail($id);
        $resource->fill($input);
        $resource->save();
        return response()->json($resource, 200);
    }

    public function destroy($id)
    {
        Log::info('Deleting user: '.$id);
        $resource = User::findOrFail($id);
        $resource->delete();
        return response()->json('user removed successfully', 200);
    }
}
