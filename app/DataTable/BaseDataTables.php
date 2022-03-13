<?php

namespace App\DataTable;

use Barryvdh\Debugbar\Twig\Extension\Debug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

abstract class BaseDataTables extends Model
{

    protected $recordsTotal;
    protected $recordsFiltered;
    protected $draw = 0;
    protected $query;
    protected $collection;
    protected $search = "";
    protected $columns;
    protected $orders = array();
    protected $page = 1;
    protected $limit = 10;
    protected $offset = 0;
    protected $logger;
    protected $selectedColumns = ["*"];
    protected $response;
    protected $defaultTimeStamp = "created_at";
    protected $doItCollection   = false;
    protected $search_query   = "";

    public function ajax(Request $request = null)
    {
        $this->preparedQuery($request)->execute();
        return $this->response;
    }


    private function execute()
    {
        $this->response = DataTables::of($this->query)
            ->with([
                "draw"            => $this->draw,
                "recordsTotal"    => $this->recordsTotal,
                "recordsFiltered" => $this->recordsFiltered
            ])
            ->make(true);

        return $this;
    }

    private function preparedQuery(Request $request = null)
    {
        return $this->handleRequest($request)->initSelect($request)
            ->countTotal()->doFiltering($request)->doOrdering()
            ->doPagination()->doAliasNames();
    }


    protected function handleRequest(Request $request = null)
    {

        if ($request != null) {
            $this->search         =   $request->input('search.value');
            $this->columns        =   $request->get('columns');
            $this->orders         =   $request->has('order') ?  $request->get('order') : [];
            $this->page           =   ($request->get('start') / $request->get('length')) + 1;
            $this->limit          =   $request->get('length');
            $this->offset         =   ($this->page - 1) * $this->limit;
            $this->draw           =   (int)$request->get('draw');
            $this->search_query   =    $request->get('search_query');
        }
        return $this;
    }

    protected function initSelect(Request $request = null)
    {
        $this->query  = $this->select($this->getColumns());
        return $this;
    }

    protected function countTotal()
    {
        $query = $this->query;
        $this->recordsTotal = $query->count("*");
        $this->recordsFiltered = $this->recordsTotal;

        return $this;
    }

    protected function doFiltering(Request $request = null)
    {
        if ($this->search_query != "") {
            $whereCluase = "( ";
            foreach ($this->getFilteredColumns() as $column) {
                $whereCluase .=  $column . " LIKE '%" . $this->search_query . "%' OR ";
            }
            //delete last OR in whereCluause
            $whereCluase = substr($whereCluase, 0, strlen($whereCluase) - 3) . " )";
            $this->query = $this->query->whereRaw(DB::raw($whereCluase));

            $this->recordsFiltered = $this->query->count('*');
            return $this;
        }

        return $this;
    }

    protected function doPagination()
    {
        $this->query->skip($this->offset)->take($this->limit);
        return $this;
    }

    protected function doAliasNames()
    {
        return $this;
    }

    protected function doOrdering()
    {
        foreach ($this->orders as $order) {
            if (isset($this->columns[$order['column']])) {
                if ($this->columns[$order['column']]['data'] == "id") {
                    $this->query->orderBy($this->defaultTimeStamp, $order['dir']);
                } else {
                    $this->query->orderBy($this->columns[$order['column']]['data'], $order['dir']);
                }
            }
        }
        if(sizeof($this->orders) == 0){
            $this->query->orderBy($this->defaultTimeStamp, 'desc');
        }
        return $this;
    }

    protected function getColumns()
    {
        return $this->selectedColumns;
    }

    protected function getFilteredColumns()
    {
        return $this->selectedColumns;
    }
}
