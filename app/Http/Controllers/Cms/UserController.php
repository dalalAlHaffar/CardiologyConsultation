<?php

namespace App\Http\Controllers\Cms;

use App\DataTable\User\UsersDataTable;
use App\Helper\BaseResponse;
use App\Helper\ImageHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function __construct()
    {

        $this->response = new BaseResponse();
        $this->UsersDataTable = new UsersDataTable();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('cms.User.index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexData(Request $request)
    {
        return $this->UsersDataTable->ajax($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cms.User.create');
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
            $fileData = ImageHandler::uploads($file, 'User/', 'User');
            $data['image'] = $fileData['fileName'];
        }
        $data['password'] = bcrypt($data['password']);
        $User = User::create($data);
        return redirect()->back()->with('success', 'User Was Added Successfully !!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('cms.User.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, User $User)
    {
        $data = $request->validated();
        if ($file = $request->file('image')) {
            ImageHandler::delete($User->image, 'User');
            $fileData = ImageHandler::uploads($file, 'User/', 'User');
            $data['image'] = $fileData['fileName'];
        }
        $User->update($data);

        return redirect()->back()->with('success', 'User Was Updated Successfully !!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $User = User::findOrFail($id);
        $User->delete();
        return response()->json(['success' => 'success Result'], 200);
    }
    public function selectData(Request $request)
    {
      $page        = $request->get('page');
      $offset      = ($page - 1) * 10;
      $data        = User::select('id', 'title','image');
  
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
            "image" =>  url("storage/user/"  . $item['image'])  
          ];
        }),
        "pagination" => ["more" => $morePages ]
      ];
  
      return response()->json($results);
    }
}
