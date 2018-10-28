<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\EventData;
use App\Models\Lead;
use App\Tables\Admin\EventDataTable;
use App\Tables\TableFacade;
use Illuminate\Http\Request;

class EventDatasController extends Controller
{
    /**
     * Tên dùng để phân quyền
     * @var string
     */
    protected $name = 'eventData';

    /**
     * Hiển thị trang danh sách EventData.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.event_datas.index')->with('eventData', new EventData);
    }

    /**
     * Lấy danh sách EventData cho trang table ở trang index
     * @return string
     */
    public function table()
    {
        return (new TableFacade(new EventDataTable()))->getDataTable();
    }

    /**
     * Trang tạo mới EventData.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.event_datas.create', [
            'eventData' => new EventData,
            'action'    => route('event_datas.store'),
        ]);
    }

    /**
     * Lưu EventData mới.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
//        $this->validate($request, [
//            'name' => 'required',
//        ]);
        $requestData = $request->all();
        $eventData   = EventData::create($requestData);

        $appointmentId = $request->get('appointment_id');
        if ($appointmentId) {
            Appointment::find($appointmentId)->update([
                'show_up' => 1,
            ]);
        }

        if ($request->wantsJson()) {
            return $this->asJson([
                'message' => __('Data created successfully'),
            ]);
        }

        return redirect(route('event_datas.show', $eventData))->with('message', __('Data created successfully'));
    }

    /**
     * Trang xem chi tiết EventData.
     *
     * @param  EventData $eventData
     *
     * @return \Illuminate\View\View
     */
    public function show(EventData $eventData)
    {
        return view('admin.event_datas.show', compact('eventData'));
    }

    /**
     * Trang cập nhật EventData.
     *
     * @param  EventData $eventData
     *
     * @return \Illuminate\View\View
     */
    public function edit(EventData $eventData)
    {
        return view('admin.event_datas.edit', [
            'eventData' => $eventData,
            'method'    => 'put',
            'action'    => route('event_datas.update', $eventData),
        ]);
    }

    /**
     * Cập nhật EventData tương ứng.
     *
     * @param \Illuminate\Http\Request $request
     * @param  EventData $eventData
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, EventData $eventData)
    {
//        $this->validate($request, [
//            'name' => 'required',
//        ]);
        $requestData = $request->all();
        $eventData->update($requestData);

        if ($request->wantsJson()) {
            return $this->asJson([
                'message' => __('Data edited successfully'),
            ]);
        }

        return redirect(route('event_datas.show', $eventData))->with('message', __('Data edited successfully'));
    }

    /**
     * Xóa EventData.
     *
     * @param EventData $eventData
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(EventData $eventData)
    {
        try {
            $eventData->delete();
        } catch (\Exception $e) {
            return $this->asJson([
                'message' => "Error: {$e->getMessage()}",
            ], $e->getCode());
        }

        return $this->asJson([
            'message' => __('Data deleted successfully'),
        ]);
    }

    /**
     * Xóa nhiều EventData.
     *
     * @return mixed|\Symfony\Component\HttpFoundation\ParameterBag
     * @throws \Exception
     */
    public function destroys()
    {
        try {
            $ids = \request()->get('ids');
            EventData::destroy($ids);
        } catch (\Exception $e) {
            return $this->asJson([
                'message' => "Error: {$e->getMessage()}",
            ], $e->getCode());
        }

        return $this->asJson([
            'message' => __('Data deleted successfully'),
        ]);
    }

    /**
     * Lấy danh sách EventData theo dạng json
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function eventDatas()
    {
        $query      = request()->get('query', '');
        $page       = request()->get('page', 1);
        $excludeIds = request()->get('excludeIds', []);
        $offset     = ($page - 1) * 10;
        $eventDatas = EventData::query()->select(['id', 'name']);

        $eventDatas->andFilterWhere([
            ['name', 'like', $query],
            ['id', '!=', $excludeIds],
        ]);

        $totalCount = $eventDatas->count();
        $eventDatas = $eventDatas->offset($offset)->limit(10)->get();

        return $this->asJson([
            'total_count' => $totalCount,
            'items'       => $eventDatas->toArray(),
        ]);
    }

    /**
     * @param Request $request
     * @param EventData $eventData
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeState(Request $request, EventData $eventData)
    {
        $state = $request->post('state');

        try {
            $leadId = $eventData->lead_id;
            $lead   = Lead::find($leadId);

            if ($state !== null && $eventData->update(['deal' => $state])) {
                if ($state == -1) {
                    $lead->update(['state' => 9]);
                } else {
                    $lead->update(['state' => 10]);
                }

                return response()->json([
                    'message' => __('Data edited successfully'),
                ]);
            }

            return response()->json([
                'message' => __('Data edited unsuccessfully'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Error: {$e->getMessage()}",
            ], $e->getCode());
        }
    }
}