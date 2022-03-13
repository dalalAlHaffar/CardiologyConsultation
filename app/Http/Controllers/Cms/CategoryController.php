<?php

namespace App\Http\Controllers\Cms;

use App\DataTable\Category\CategoriesDataTable;
use App\Helper\BaseResponse;
use App\Helper\ImageHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function __construct()
    {

        $this->response = new BaseResponse();
        $this->CategoriesDataTable = new CategoriesDataTable();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('cms.Category.index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexData(Request $request)
    {
        return $this->CategoriesDataTable->ajax($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cms.Category.create');
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
        if ($file = $request->file('image')) {
            $fileData = ImageHandler::uploads($file, 'Category/', 'Category');
            $data['image'] = $fileData['fileName'];
        }
        $Category = Category::create($data);


        return redirect()->back()->with('success', 'Category Was Added Successfully !!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('cms.Category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Category $Category)
    {
        $data = $request->validated();
        if ($file = $request->file('image')) {
            ImageHandler::delete($Category->image, 'Category');
            $fileData = ImageHandler::uploads($file, 'Category/', 'Category');
            $data['image'] = $fileData['fileName'];
        }
        $Category->update($data);

        return redirect()->back()->with('success', 'Category Was Updated Successfully !!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Category = Category::findOrFail($id);
        $Category->delete();
        return response()->json(['success' => 'success Result'], 200);
    }
    public function selectData(Request $request)
    {
      $page        = $request->get('page');
      $offset      = ($page - 1) * 10;
      $data        = Category::select('id', 'title','image');
  
      if($request->term != null){
        $data = $data->where(function($query) use($request){
          $query =	$query->whereRaw( DB::raw( "LOWER(name) LIKE '%".$request->term."%'") )  ;
        });
      }
  
      $totalRows =  $data->count();
      $lastRow   =  $offset + 10;
      $morePages =  $lastRow < $totalRows;
      $data      =  $data->orderBy('title')->skip($offset)->take(10)->get();
  
      $results = [
        "results"    => $data->map(function($item){
          return [
            "id"   =>  $item['id'] ,
            "text" =>  $item['title'],
            "image" =>  url("storage/category/"  . $item['image'])  
          ];
        }),
        "pagination" => ["more" => $morePages ]
      ];
  
      return response()->json($results);
    }
}
