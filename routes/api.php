<?php

use App\Http\Controllers\Api\V1\CommentController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\SongController;
use App\Http\Controllers\Api\V1\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1', 'middleware' => 'auth:sanctum'], function(){
    Route::apiResource('/songs', SongController::class);
    
    Route::apiResource('/users', UserController::class);

    Route::get('/users/writers', [UserController::class, 'showWriters']);

    Route::apiResource('/comments', CommentController::class);
});


Route::post('/register', function(Request $request){ 
    $credentials = [
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'password' => $request->input('password'),
        'stage_name' => $request->input('stage_name'),
        'type' => $request->input('type')
    ];

    if(!Auth::attempt($credentials))
    {
        $user = new User();
        $user->name = $credentials['name'];
        $user->email = $credentials['email'];
        $user->password = Hash::make($credentials['password']);
        $user->stage_name = $credentials['stage_name'];
        $user->type = $credentials['type'];

        $user->save();

        if(Auth::attempt($credentials))
        {
            $user = User::where('email', $user->email)->first();

            $token = $user->createToken('apiToken');

            return response()->json([
                'status' => true,
                'token' => $token->plainTextToken
            ]);
        }
    }

});