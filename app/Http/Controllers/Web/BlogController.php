<?php

namespace App\Http\Controllers\Web;

use App\DataTable\Blog\BlogsDataTable;
use App\Helper\BaseResponse;
use App\Helper\ImageHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\StoreRequest;
use App\Http\Requests\Blog\UpdateRequest;
use App\Models\Blog;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BlogController extends Controller
{



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function details(Request $request)
    {
        $blog= Blog::findOrFail($request->id);
        $blog->increment('views');
        $most_viewed = Blog::where('id','!=',$blog->id)->orderby('views','desc')->limit(5)->get();
        return view('web.Blog.details', compact('blog','most_viewed'));
    }
    public function addComment(Request $request)
    {
       $comment =new BlogComment;
       $comment->user_id =$request->user()->id;
       $comment->text = $request->text;
       $comment->blog_id = $request->id;
       $comment->save();
       $comment = BlogComment::where('id',$comment->id)->with('user')->first();
       $blogCount=Blog::find($request->id)->comments()->count();
        return response()->json(['result' => $comment ,'count' =>$blogCount],200);
    }


}
