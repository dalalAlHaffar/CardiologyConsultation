<?php

namespace App\DataTable\Consolute;


use App\DataTable\BaseDataTables;
use App\Models\Consulate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConsoluteDataTable extends BaseDataTables
{
    protected $table            = 'consulates';
    protected $selectedColumns  = [
        'consulates.id as id',
        'consulates.title as title','consulates.description as description', 'consulates.medical_history as medical_history', 'consulates.created_at as created_at','user_id',
    ];

    protected $defaultTimeStamp = "consulates.created_at";

    protected function initSelect(Request $request = null)
    {
        $this->selectedColumns[] = DB::raw('If(answer is null , "NotAnswered","Answered") as status');
        $this->query  =   Consulate::with('user')->select($this->selectedColumns);
        if($request->status == "answered" ){
            $this->query  =  $this->query->whereNotNull('answer');
        }else if($request->status == "notAnswered" ){
            $this->query  =  $this->query->whereNull('answer');
        }
        if(sizeof($this->orders) == 0){
            $this->orders[]  = [
                "column" => "4",
                "dir" => "asc",
              ];
        }
      
        return $this;
    }

    protected function getFilteredColumns()
    {
        return ['consulates.id', 'consulates.title', 'consulates.description','consulates.medical_history', 'consulates.created_at'];
    }
}
