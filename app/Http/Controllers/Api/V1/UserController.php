<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('comments')->paginate(10);
        return response()->json(
            [
                'status' => true,
                'data' => $users
            ], 200
            );
        
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
        $validatedRequest = Validator::make($request->all(), [
            'name' => 'required|alpha-dash',
            'stage_name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'type' => 'required',
        ]);

        if($validatedRequest->fails())
        {
            return response()->json([
                'status' => false,
                'data' => $validatedRequest->messages(),
            ]);
        }

        $user = new User();
        $user->name = $request->input('name');
        $user->stage_name = $request->input ('stage_name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));

        
        return response()->json([
            'status' => true,
            'data' => $user,
        ], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show($user)
    {
        $user = User::with('comments')->get($user);

        if(!isset($user)) {
            return response()->json([
                'status' => false,
                'data' => 'user does not exist in our records',
            ]);
        }
        return response()->json(
            [
                'status' => true,
                'data' => $user
            ], 200
            );
    }

    public function showWriters($writer)
    {
        $writers = User::where('type', 'W')->get();

        return response()->json(
            [
                'status' => true,
                'data' => $writers
            ], 200
            );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $user)
    {
         $validatedRequest = Validator::make($request->all(), [
            'name' => 'required|alpha-dash',
            'stage_name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'type' => 'required',
        ]);

        if($validatedRequest->fails())
        {
            return response()->json([
                'status' => false,
                'data' => $validatedRequest->messages(),
            ]);
        }

        $user = User::find($user);

        if (! isset($user)) {
             return response()->json([
                'status' => false,
                'data' => 'User does not exist in records',
            ]);
        }

        $user->name = $request->input('name');
        $user->stage_name = $request->input ('stage_name');
        $user->email = $request->input('email');
        $user->password = $request->input('password');

        $user->update();

        return response()->json(
            [
                'status' => true,
                'data' => $user
            ], 200
        );
        
       

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($user)
    {
        $user = User::find($user);

        if (! isset($user)) {
             return response()->json([
                'status' => false,
                'data' => 'user does not exist in records',
            ]);
        }

        $user->delete();

        return response()->json(
            [
                'status' => true,
                'data' => $user
            ], 200
        );
     
    }
}
