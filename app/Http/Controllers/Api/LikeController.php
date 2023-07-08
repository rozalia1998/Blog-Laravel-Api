<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Like;
use App\Models\Post;
use App\Models\Comment;

use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    use ApiResponse;

    public function store(Request $request,$id,$type){
        $user=Auth::user();
        if($type=='post'){
            $post=Post::findOrFail($id);
            $like=new Like();
            $like->user_id=$user->id;
            $post->likes()->save($like);
            return $this->SuccessResponse('added like to this post');
        }
        elseif ($type=='comment'){
            $comment=Comment::findOrFail($id);
            $like=new Like();
            $like->user_id=$user->id;
            $comment->likes()->save($like);
            return $this->SuccessResponse('added like to this comment');
        }
    }

    public function cancelLike($id,$type){
        $user=Auth::user();
        if($type=='post'){
            $post=Post::findOrFail($id);
            $like=$post->likes()->where('user_id',$user->id)->first();
            if($like){
                $like->delete();
            return $this->SuccessResponse('cancelled like on this post');
            }
            return $this->errorResponse('like not found on this post');
        }
        elseif($type='comment'){
            $comment=Comment::findOrFail($id);
            $like=$comment->likes()->where('user_id',$user->id)->first();
            $like->delete();
            return $this->SuccessResponse('cancelled like on this comment');
        }
    }
}
