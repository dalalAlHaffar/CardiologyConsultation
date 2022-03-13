<?php

namespace App\DataTable\Blog;


use App\DataTable\BaseDataTables;
use App\Models\Blog;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class BlogsDataTable extends BaseDataTables
{
    protected $table            = 'blogs';
    protected $selectedColumns  = [
        'blogs.id as id',
        'blogs.title as title', 'blogs.brief_description as brief_description', 'blogs.created_at as created_at','blogs.image as image'
    ];

    protected $defaultTimeStamp = "blogs.created_at";

    protected function initSelect(Request $request = null)
    {
        $this->query  =   Blog::select($this->selectedColumns)->with('tags:blog_id,title');
        return $this;
    }

    protected function getFilteredColumns()
    {
        return ['blogs.id', 'blogs.title', 'blogs.brief_description', 'blogs.created_at'];
    }
}
