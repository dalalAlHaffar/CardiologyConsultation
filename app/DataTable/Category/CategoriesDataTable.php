<?php

namespace App\DataTable\Category;


use App\DataTable\BaseDataTables;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class CategoriesDataTable extends BaseDataTables
{
    protected $table            = 'categories';
    protected $selectedColumns  = [
        'categories.id as id',
        'categories.title as title',  'categories.created_at as created_at','categories.image as image'
    ];

    protected $defaultTimeStamp = "categories.created_at";

    protected function initSelect(Request $request = null)
    {
        $this->query  =   Category::select($this->selectedColumns);
        return $this;
    }

    protected function getFilteredColumns()
    {
        return ['categories.id', 'categories.title', 'categories.created_at'];
    }
}
