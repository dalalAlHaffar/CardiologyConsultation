<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware(['auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $blogs = Blog::with('category','user');
        if(request()->has('category_id')){
            $blogs->where('category_id',$request->category_id);
        }
        $blogs= $blogs->orderby('views','desc')->paginate(9);
        return view('web.home.index',compact('blogs'));
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
