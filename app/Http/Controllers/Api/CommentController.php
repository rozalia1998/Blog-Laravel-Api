<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    use ApiResponse;

    public function show($pid){

        $post=Post::findOrFail($pid);
        $res=$post->comments()->with('user:id,name')->get();
        $data=[];
        foreach($res as $r){
            $data[]=[
                'comment'=>$r->body,
                'user'=>$r->user->name
            ];
        }

        return $this->apiResponse($data,'Show All comments for this post ');

    }

    public function add(Request $request,$pid){

        $comment=Comment::create([
            'user_id'=> auth()->user()->id,
            'post_id'=> $pid,
            'body'=>$request->body
        ]);

        return $this->SuccessResponse('comment added',200);

    }

    public function update($pid){

        $comment=Comment::update([
            'user_id'=> auth()->user()->id,
            'post_id'=> $pid,
            'body'=>$request->body
        ]);

        return $this->SuccessResponse('comment updated',200);
    }
}
