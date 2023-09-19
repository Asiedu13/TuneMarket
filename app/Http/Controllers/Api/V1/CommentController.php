<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comment = Comment::paginate(10);
        return response()->json(
            [
                'status' => true,
                'data' => $comment
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
    public function store(StoreCommentRequest $request)
    {
         $validatedRequest = Validator::make($request->all(), [
            'song_id' => 'required|integer',
            'comment_content' => 'required',
            'user_id' => 'required|integer',
        ]);

        if($validatedRequest->fails())
        {
            return response()->json([
                'status' => false,
                'data' => $validatedRequest->messages(),
            ]);
        }

        $comment = new Comment();
        $comment->song_id = $request->input('song_id');
        $comment->comment_content = $request->input ('comment_content');
        $comment->user_id = $request->input('user_id');

        $comment->save();
        
        return response()->json([
            'status' => true,
            'data' => Comment::find($comment->id),
        ], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show($comment)
    {
         $comment = Comment::find($comment);

        if(!isset($comment)) {
            return response()->json([
                'status' => false,
                'data' => 'comment does not exist in our records',
            ]);
        }
        return response()->json(
            [
                'status' => true,
                'data' => $comment
            ], 200
            );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, $comment)
    {
        $validatedRequest = Validator::make($request->all(), [
            'song_id' => 'required|integer',
            'comment_content' => 'required',
            'user_id' => 'required|integer',
        ]);

        if($validatedRequest->fails())
        {
            return response()->json([
                'status' => false,
                'data' => $validatedRequest->messages(),
            ]);
        }

        $comment = Comment::find($comment);

        if (! isset($comment)) {
             return response()->json([
                'status' => false,
                'data' => 'comment does not exist in records',
            ]);
        }

        $comment->song_id = $request->input('song_id');
        $comment->comment_content = $request->input ('comment_content');
        $comment->user_id = $request->input('user_id');

        $comment->update();

        return response()->json(
            [
                'status' => true,
                'data' => $comment
            ], 200
        );
        
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
         $comment = Comment::find($comment);

        if (! isset($comment)) {
             return response()->json([
                'status' => false,
                'data' => 'comment does not exist in records',
            ]);
        }

        $comment->delete();

        return response()->json(
            [
                'status' => true,
                'data' => $comment
            ], 200
        );
    }
}
