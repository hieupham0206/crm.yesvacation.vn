<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Tables\Admin\ActivityLogTable;
use App\Tables\TableFacade;

class ActivityLogsController extends Controller
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
        return view('admin.activity_logs.index');
    }

    /**
     * @return string
     */
    public function table()
    {
        return (new TableFacade(new ActivityLogTable()))->getDataTable();
    }

    public function viewDetail()
    {
        $logId       = request()->get('logId');
        $activityLog = ActivityLog::find($logId);

        return view('admin.activity_logs.activity_log_detail', ['log' => $activityLog]);
    }

    public function getMoreLogs()
    {
        $page = request()->get('page', 1);

        $logs = ActivityLog::query()->latest()->offset($page * 10)->limit(10)->get(['description', 'created_at']);

        return response()->json([
            'datas'   => $logs,
            'isEmpty' => $logs->isEmpty()
        ]);
    }
}
