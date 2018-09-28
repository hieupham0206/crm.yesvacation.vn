<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Tables\Department\EventTable;
use App\Tables\TableFacade;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    protected $name = 'event';

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
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('department.events.index');
    }

    /**
     * Index table
     * @return string
     */
    public function table()
    {
        return (new TableFacade(new EventTable()))->getDataTable();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $action = route('events.store');

        return view('department.events._form')->with('action', $action);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'    => 'required',
            'start_at' => 'required'
        ]);
        $requestData = $request->all();

        $start = $requestData['start_at'];
        $end   = $requestData['end_at'];

        $requestData['start_at'] = date('Y-m-d H:i:s', strtotime($start));
        $requestData['end_at'] = date('Y-m-d H:i:s', strtotime($end));

        if ($end == '') {
            $requestData['end_at'] = date('Y-m-d', strtotime($start)) . ' 23:59:59';
        }

        Event::create($requestData);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => __('Data created successfully')
            ]);
        }

        return redirect(route('events.index'))->with('message', __('Data created successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Event $event
     *
     * @return \Illuminate\View\View
     */
    public function show(Event $event)
    {
        return view('department.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Event $event
     *
     * @return \Illuminate\View\View
     */
    public function edit(Event $event)
    {
        $action = route('events.update', $event);

        return view('department.events._form', compact('event'))->with('action', $action)->with('method', 'put');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  Event $event
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Event $event)
    {
        $this->validate($request, [
            'title'    => 'required',
            'start_at' => 'required'
        ]);
        $requestData = $request->all();
        $event->update($requestData);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => __('Data edited successfully')
            ]);
        }

        return redirect(route('events.index'))->with('message', __('Data edited successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Event $event
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Event $event)
    {
        try {
            $event->delete();
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Error: {$e->getMessage()}"
            ], $e->getCode());
        }

        return response()->json([
            'message' => __('Data deleted successfully')
        ]);
    }

    /**
     * Remove multiple resource from storage.
     *
     * @return mixed|\Symfony\Component\HttpFoundation\ParameterBag
     * @throws \Exception
     */
    public function destroys()
    {
        try {
            $ids = \request()->get('ids');
            Event::destroy($ids);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Error: {$e->getMessage()}"
            ], $e->getCode());
        }

        return response()->json([
            'message' => __('Data deleted successfully')
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function events(Request $request)
    {
        $query  = $request->get('query', '');
        $start  = $request->get('start', '');
        $end    = $request->get('end', '');
        $page   = $request->get('page', 1);
        $limit  = $request->get('limit', 10);
        $offset = ($page - 1) * 10;
        $events = Event::query()->select([
            'id',
            'title',
            'description',
            'start_at as start',
            'end_at as end',
            'color',
            'all_day'
        ]);

        if ($query) {
            $events = $events->where('title', 'like', "%{$query}%");
        }

        if ($start) {
            $events = $events->whereBetween('start_at', [
                date('Y-m-d', $start),
                date('Y-m-d', $end)
            ]);
        }

        return response()->json([
            'total_count' => $events->count(),
            'items'       => $events->offset($offset)->limit($limit)->get()->toArray(),
        ]);
    }
}