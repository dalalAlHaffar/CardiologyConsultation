<?php

namespace App\Http\Controllers\Cms;

use App\DataTable\Blog\BlogsDataTable;
use App\Helper\BaseResponse;
use App\Helper\ImageHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\StoreRequest;
use App\Http\Requests\Blog\UpdateRequest;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class BlogController extends Controller
{
    public function __construct()
    {

        $this->response = new BaseResponse();
        $this->blogsDataTable = new BlogsDataTable();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('cms.blog.index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexData(Request $request)
    {
        return $this->blogsDataTable->ajax($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cms.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = request()->user()->id;
        if ($file = $request->file('image')) {
            $fileData = ImageHandler::uploads($file, 'blog/', 'Blog');
            $data['image'] = $fileData['fileName'];
        }
        $blog = Blog::create(Arr::except($data, ['tags']));
        foreach ($data['tags'] as $tag)
            $blog->tags()->create(['title' => $tag]);

        return redirect()->back()->with('success', 'Blog Was Added Successfully !!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        return view('cms.blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Blog $blog)
    {
        $data = $request->validated();
        if ($file = $request->file('image')) {
            ImageHandler::delete($blog->image , 'blog');
            $fileData = ImageHandler::uploads($file, 'blog/', 'Blog');
            $data['image'] = $fileData['fileName'];
        }
         $blog->update(Arr::except($data, ['tags']));
         $blog->tags()->delete();
        foreach ($data['tags'] as $tag)
            $blog->tags()->create(['title' => $tag]);

        return redirect()->back()->with('success', 'Blog Was Updated Successfully !!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog= Blog::findOrFail($id);
        $blog->tags()->delete();
        $blog->delete();
        return response()->json(['success' => 'success Result'], 200);
    }
}
