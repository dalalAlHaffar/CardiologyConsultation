<?php

namespace App\DataTable\User;


use App\DataTable\BaseDataTables;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UsersDataTable extends BaseDataTables
{
    protected $table            = 'users';
    protected $selectedColumns  = [
        'users.id as id',
        'users.name as name', 'users.email as email','users.role as role', 'users.created_at as created_at','users.image as image'
    ];

    protected $defaultTimeStamp = "users.created_at";

    protected function initSelect(Request $request = null)
    {
        $this->query  =   User::select($this->selectedColumns);
        return $this;
    }

    protected function getFilteredColumns()
    {
        return ['users.id', 'users.name', 'users.email','users.role', 'users.created_at'];
    }
}
