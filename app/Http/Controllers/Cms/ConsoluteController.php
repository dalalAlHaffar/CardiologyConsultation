<?php

namespace App\Http\Controllers\Cms;

use App\DataTable\Consulate\ConsulatesDataTable;
use App\DataTable\Consolute\ConsoluteDataTable;
use App\Helper\BaseResponse;
use App\Helper\ImageHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Consulate\StoreRequest;
use App\Http\Requests\Consulate\UpdateRequest;
use App\Models\Consulate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class ConsoluteController extends Controller
{
    public function __construct()
    {

        $this->response = new BaseResponse();
        $this->consoluteDataTable = new ConsoluteDataTable();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('cms.Consulate.index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexData(Request $request)
    {
        return $this->consoluteDataTable->ajax($request);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$Consulate)
    {
        $data = Consulate::with('user')->findOrFail($Consulate);
        return response()->json(['result' =>$data   ], 200);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $Consulate)
    {
        $Consulate = Consulate::findOrFail($Consulate);
        if($request->answer == null){
            return redirect()->back()->with('error', 'Answer Is Required');
        }
        $Consulate->update(['answer' => $request->answer]);
        return redirect()->back()->with('success', 'Answer Was Updated Successfully !!');
    }
}
