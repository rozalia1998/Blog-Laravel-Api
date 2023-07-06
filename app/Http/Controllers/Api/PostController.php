<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $posts = Post::where('user_id', auth()->user()->id)->get();
        $posts=Post::all();
        return $this->apiResponse($posts,'All posts');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post=Post::create([
            'title'=>$request->title,
            'body'=>$request->body,
            'user_id'=>auth()->user()->id
        ]);

        return $this->SuccessResponse('Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post=Post::findOrFail($id);
        $this->authorize('update',$post);
        // if($request->user()->id !== $post->user_id){
        //     return $this->errorResponse('Unauthorized',403);
        //     // abort(403, 'Unauthorized action.');
        // }
        $posts = Post::findOrFail($id)->update([
            'title'=>$request->title,
            'body'=>$request->body,
            'user_id'=>auth()->user()->id
        ]);

        return $this->SuccessResponse('Updated Post');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {

        Post::findOrFail($id)->delete();
        Post::destroy($id);
        return $this->SuccessResponse('Deleted Successfully');

        $post=Post::findOrFail($id)->where('deleted_at','!==',NULL);
        if ($post){
            return $this->errorResponse('Post Not Found',404);
        }
    }

    public function softPosts(){
        $posts=Post::onlyTrashed()->get();
        return $this->apiResponse($posts);
    }

    public function restorePost($id){
        $post=Post::withTrashed()->where('id',$id)->restore();
        return $this->SuccessResponse('Restored Post');
    }

    public function restoreAll(){
        $posts=Post::onlyTrashed()->restore();
        return $this->SuccessResponse('Restored All Posts');
    }
}
