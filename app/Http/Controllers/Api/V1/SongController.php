<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Song;


use App\Http\Requests\StoreSongRequest;
use App\Http\Requests\UpdateSongRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $songs = Song::with('comments')->paginate(10);
        return response()->json(
            [
                'status' => true,
                'data' => $songs
            ], 200
            );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSongRequest $request)
    {
        $validatedRequest = Validator::make($request->all(), [
            'title' => 'required',
            'story' => 'required|min:20',
            'user_id' => 'required|integer',
            'main_audio_link' => 'required',
            'preview_link' => 'required',
            'lyrics' => 'required',
            'producer_name' => 'required',
            'duration' => 'required|integer',
            'number_of_verses' => 'required|integer',
            'original_instrumental' => 'required|boolean',
            'has_sample' => 'required|boolean',
            'is_explicit' => 'required|boolean',
        ]);

        if($validatedRequest->fails())
        {
            return response()->json([
                'status' => false,
                'data' => $validatedRequest->messages(),
            ]);
        }

        $song = Song::create($request->all());
        
        return response()->json([
            'status' => true,
            'data' => $song,
        ], 200);

        
    }

    /**
     * Display the specified resource.
     */
    public function show($song)
    {
        $song = Song::find($song);

        if(!isset($song)) {
            return response()->json([
                'status' => false,
                'data' => 'Song does not exist in our records',
            ]);
        }
        return response()->json(
            [
                'status' => true,
                'data' => $song
            ], 200
            );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Song $song)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSongRequest $request, $song)
    {
        $validatedRequest = Validator::make($request->all(), [
            'title' => 'required',
            'story' => 'required|min:20',
            'user_id' => 'required|integer',
            'main_audio_link' => 'required',
            'preview_link' => 'required',
            'lyrics' => 'required',
            'producer_name' => 'required|alpha',
            'duration' => 'required',
            'number_of_verses' => 'required',
            'original_instrumental' => 'required|boolean',
            'has_sample' => 'required|boolean',
            'is_explicit' => 'required|boolean',
        ]);

        if($validatedRequest->fails())
        {
            return response()->json([
                'status' => false,
                'data' => $validatedRequest->messages(),
            ]);
        }

        
        $song = Song::find($song);

        if (! isset($song)) {
             return response()->json([
                'status' => false,
                'data' => 'Song does not exist in records',
            ]);
        }

        $song->title = $request->input('title');
        $song->story = $request->input('story') ;
        $song->user_id = $request->input('user_id');
        $song->main_audio_link = $request->input('main_audio_link');
        $song->preview_link = $request->input('preview_link');
        $song->lyrics = $request->input('lyrics');
        $song->number_of_listens = $request->input('number_of_listens');
        $song->producer_name = $request->input('producer_name');
        $song->duration = $request->input('duration');
        $song->number_of_verses = $request->input('number_of_verses');
        $song->original_instrumental = $request->input('original_instrumental');
        $song->has_sample = $request->input('has_sample');
        $song->is_explicit = $request->input('is_explicit');

        $song->update();

        return response()->json(
            [
                'status' => true,
                'data' => $song
            ], 200
        );

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($song)
    {
        $song = Song::find($song);

        if (! isset($song)) {
             return response()->json([
                'status' => false,
                'data' => 'Song does not exist in records',
            ]);
        }

        $song->delete();

        return response()->json(
            [
                'status' => true,
                'data' => $song
            ], 200
        );
        
    }
}
