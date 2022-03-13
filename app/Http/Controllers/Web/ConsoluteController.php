<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Consulate\StoreRequest;
use App\Http\Requests\Consulate\UpdateRequest;
use App\Models\Consulate;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ConsoluteController extends Controller
{
    // public function __construct()
    // {

    //     $this->response = new BaseResponse();
    //     $this->ConsulatessDataTable = new ConsulatessDataTable();
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       $Consulates =  Consulate::where('user_id',$request->user()->id)->orderby('created_at','desc')->paginate(9);
        return view('web.Consulate.index',compact('Consulates'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function indexData(Request $request)
    // {
    //     return $this->ConsulatessDataTable->ajax($request);
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('web.Consulate.create');
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
        $data['user_id'] = $request->user()->id;
        $Consulate = Consulate::create(Arr::only($data,['title','description','medical_history','user_id']));
        $request->user()->update(Arr::only($data,['age','phone','name','gender']));
        return redirect()->back()->with('success', 'Consulate Was Added Successfully, OUr Doctor Will response Soon !!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $Consulate =Consulate::findOrFail($request->consolute);
        if($Consulate->user_id != Auth::id()){
            abort(403);
        }
        if($Consulate->answer != null){
            abort(403);
        }
        return view('web.Consulate.edit', compact('Consulate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request, Consulate $Consulate)
    {
        $data = $request->validated();
        $Consulate->update(Arr::only($data,['title','description','medical_history']));
        $request->user()->update(Arr::only($data,['age','phone','name','gender']));
        return redirect()->back()->with('success', 'Consulate Was Updated Successfully !!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Consulate = Consulate::findOrFail($id);
        if($Consulate->answer != null){
            abort(403);
        }
        $Consulate->delete();
        return response()->json(['success' => 'success Result'], 200);
    }
}
