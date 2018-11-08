<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Tables\Admin\AppointmentTable;
use App\Tables\TableFacade;
use Illuminate\Http\Request;

class AppointmentsController extends Controller
{
    /**
     * Tên dùng để phân quyền
     * @var string
     */
    protected $name = 'appointment';

    /**
     * Hiển thị trang danh sách Appointment.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.appointments.index')->with('appointment', new Appointment);
    }

    /**
     * Lấy danh sách Appointment cho trang table ở trang index
     * @return string
     */
    public function table()
    {
        return (new TableFacade(new AppointmentTable()))->getDataTable();
    }

    /**
     * Trang tạo mới Appointment.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.appointments.create')->with('appointment', new Appointment);
    }

    /**
     * Lưu Appointment mới.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $requestData = $request->all();
        Appointment::create($requestData);

        return redirect(route('appointments.index'))->with('message', __('Data created successfully'));
    }

    /**
     * Trang xem chi tiết Appointment.
     *
     * @param  Appointment $appointment
     *
     * @return \Illuminate\View\View
     */
    public function show(Appointment $appointment)
    {
        return view('admin.appointments.show', compact('appointment'));
    }

    /**
     * Trang cập nhật Appointment.
     *
     * @param  Appointment $appointment
     *
     * @return \Illuminate\View\View
     */
    public function edit(Appointment $appointment)
    {
        return view('admin.appointments.edit', compact('appointment'));
    }

    /**
     * Cập nhật Appointment tương ứng.
     *
     * @param \Illuminate\Http\Request $request
     * @param  Appointment $appointment
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Appointment $appointment)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $requestData = $request->all();
        $appointment->update($requestData);

        return redirect(route('appointments.index'))->with('message', __('Data edited successfully'));
    }

    /**
     * Xóa Appointment.
     *
     * @param Appointment $appointment
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Appointment $appointment)
    {
        try {
            $appointment->delete();
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Error: {$e->getMessage()}",
            ], $e->getCode());
        }

        return response()->json([
            'message' => __('Data deleted successfully'),
        ]);
    }

    /**
     * Xóa nhiều Appointment.
     *
     * @return mixed|\Symfony\Component\HttpFoundation\ParameterBag
     * @throws \Exception
     */
    public function destroys()
    {
        try {
            $ids = \request()->get('ids');
            Appointment::destroy($ids);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Error: {$e->getMessage()}",
            ], $e->getCode());
        }

        return response()->json([
            'message' => __('Data deleted successfully'),
        ]);
    }

    /**
     * Lấy danh sách Appointment theo dạng json
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function appointments()
    {
        $query        = request()->get('query', '');
        $page         = request()->get('page', 1);
        $leadId       = request()->get('leadId', '');
        $excludeIds   = request()->get('excludeIds', []);
        $offset       = ($page - 1) * 10;
        $appointments = Appointment::query()->with(['lead', 'user']);

        $appointments->andFilterWhere([
            ['name', 'like', $query],
            ['id', '!=', $excludeIds],
            ['lead_id', '=', $leadId],
        ]);

        $totalCount   = $appointments->count();
        $appointments = $appointments->offset($offset)->limit(10)->get();

        return response()->json([
            'total_count' => $totalCount,
            'items'       => $appointments->toArray(),
        ]);
    }

    public function cancel(Appointment $appointment)
    {
        $appointment->cancel();

        return response()->json([
            'message' => __('Data edited successfully'),
        ]);
    }

    public function doQueue(Appointment $appointment)
    {
        $doQueue = request()->get('notQueue', false);

        $appointment->update(['is_queue' => $doQueue ? 1 : -1]);

        if ($doQueue == 1) {
            //note: lưu event data
            $requestData['appointment_id'] = $appointment->id;

            EventData::create([
                'appointment_id' => $appointment->id,
                'lead_id'        => $appointment->lead_id,
            ]);
        }

        return response()->json([
            'message' => __('Data edited successfully'),
        ]);
    }

    public function notShowUp(Appointment $appointment)
    {
        $appointment->notShowUp();

        return response()->json([
            'message' => __('Data edited successfully'),
        ]);
    }

    public function formChangeAppointment()
    {
        return view('admin.appointments._form_change_appointment');
    }
}