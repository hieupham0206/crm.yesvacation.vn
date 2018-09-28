<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Tables\Admin\SystemLogTable;
use App\Tables\TableFacade;

class SystemLogsController extends Controller
{
    protected $name = 'log';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.system_logs.index');
    }

    /**
     * @return string
     */
    public function table()
    {
        return (new TableFacade(new SystemLogTable()))->getDataTable();
    }

    public function viewDetail()
    {
        $content = request()->get('content');
        $stack   = request()->get('stack');

        return view('admin.system_logs._detail', compact('content', 'stack'));
    }
}
