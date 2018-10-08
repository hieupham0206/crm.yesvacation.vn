<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Callback;
use App\Models\Lead;
use App\Models\Province;
use App\Models\TimeBreak;
use App\Tables\Business\LeadTable;
use App\Tables\TableFacade;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LeadsController extends Controller
{
    /**
     * Tên dùng để phân quyền
     * @var string
     */
    protected $name = 'lead';

    /**
     * Hiển thị trang danh sách Lead.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('business.leads.index')->with('lead', new Lead);
    }

    /**
     * Lấy danh sách Lead cho trang table ở trang index
     * @return string
     */
    public function table()
    {
        return (new TableFacade(new LeadTable()))->getDataTable();
    }

    /**
     * Trang tạo mới Lead.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('business.leads.create')->with('lead', new Lead);
    }

    /**
     * Lưu Lead mới.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        $requestData = $request->all();
        Lead::create($requestData);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => __('Data created successfully')
            ]);
        }

        return redirect(route('leads.index'))->with('message', __('Data created successfully'));
    }

    /**
     * Trang xem chi tiết Lead.
     *
     * @param  Lead $lead
     *
     * @return \Illuminate\View\View
     */
    public function show(Lead $lead)
    {
        return view('business.leads.show', compact('lead'));
    }

    /**
     * Trang cập nhật Lead.
     *
     * @param  Lead $lead
     *
     * @return \Illuminate\View\View
     */
    public function edit(Lead $lead)
    {
        return view('business.leads.edit', compact('lead'));
    }

    /**
     * Cập nhật Lead tương ứng.
     *
     * @param \Illuminate\Http\Request $request
     * @param  Lead $lead
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Lead $lead)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        $requestData = $request->all();
        $lead->update($requestData);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => __('Data edited successfully')
            ]);
        }

        return redirect(route('leads.index'))->with('message', __('Data edited successfully'));
    }

    /**
     * Xóa Lead.
     *
     * @param Lead $lead
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Lead $lead)
    {
        try {
            $lead->delete();
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
     * Xóa nhiều Lead.
     *
     * @return mixed|\Symfony\Component\HttpFoundation\ParameterBag
     * @throws \Exception
     */
    public function destroys()
    {
        try {
            $ids = \request()->get('ids');
            Lead::destroy($ids);
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
     * Lấy danh sách Lead theo dạng json
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function leads()
    {
        $query      = request()->get('query', '');
        $leadId     = request()->get('leadId', '');
        $isNew      = request()->get('isNew', '');
        $page       = request()->get('page', 1);
        $excludeIds = request()->get('excludeIds', []);
        $offset     = ($page - 1) * 10;
        $leads      = Lead::query();

        $leads->andFilterWhere([
            ['name', 'like', $query],
            ['id', '!=', $excludeIds],
        ]);

        if ($isNew) {
            $leads->getAvailable();
        }

        if ($leadId) {
            $leads->whereKey($leadId);
        }

        $totalCount = $leads->count();
        $leads      = $leads->offset($offset)->limit(10)->get();

        return response()->json([
            'total_count' => $totalCount,
            'items'       => $leads->toArray(),
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function formImport()
    {
        return view('business.leads._form_import');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function import(Request $request)
    {
        $this->validate($request, [
            'file_import' => 'required',
        ]);

        if ($request->hasFile('file_import')) {
            $fileImport = $request->file('file_import');
            $fileName   = $fileImport->getClientOriginalName();

            $inputFileType = 'Xlsx';

            $reader = IOFactory::createReader($inputFileType);
            $reader->setReadDataOnly(true);

            $spreadsheet = $reader->load($fileImport);
            $sheetData   = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            $totalFail    = 0;
            $totalSuccess = 0;
            $datas        = $dataFails = [];
//            $provinces    = Province::get();
            $currentPhones = [];

            foreach ($sheetData as $rowIndex => $value) {
                $message = '';
                if ($rowIndex === 1) {
                    continue;
                }

                $title        = trim($value['A']);
                $name         = trim($value['B']);
                $email        = trim($value['C']);
                $birthday     = trim($value['D']);
                $address      = trim($value['E']);
                $provinceName = trim($value['F']);
                $phone        = trim($value['G']);

                if (empty($name)) {
                    $message = 'Tên lead bị rỗng.';
                }

                if ($message) {
                    $dataFails[] = [
                        'reason' => $message,
                        'row'    => $rowIndex,
                    ];
                    $totalFail++;
                    continue;
                }

                $isPhoneUnique = Lead::isPhoneUnique($phone);

                if ( ! $isPhoneUnique || \in_array($phone, $currentPhones, true)) {
                    $totalFail++;
                    $message     = 'Lead đã tồn tại.';
                    $dataFails[] = [
                        'reason' => $message,
                        'row'    => $rowIndex,
                    ];
                    continue;
                }

                try {

                    $customerAttributes = array_merge(compact('name', 'phone', 'email', 'title', 'address'), [
                        'created_at'  => now()->toDateTimeString(),
                        'birthday'    => null,
                        'province_id' => null
                    ]);
                    if ($birthday) {
                        $birthday                       = Carbon::parse(trim($birthday))->toDateString();
                        $customerAttributes['birthday'] = $birthday;
                    }
                    if ($provinceName) {
                        $province = Province::where('name', 'like', "%$provinceName%")->first();
                        if ($province) {
                            $customerAttributes['province_id'] = $province->id;
                        }
                    }
                    $datas[]         = $customerAttributes;
                    $currentPhones[] = $phone;

                    $totalSuccess++;
                } catch (\Exception $e) {
                    dd($e->getMessage());
                }

            }
            Lead::insert($datas);
            $fileFailName = '';
            if ($dataFails) {
                $excel = new Spreadsheet();

                $sheet = $excel->setActiveSheetIndex(0);
                $sheet->setCellValue('A1', 'Dòng')
                      ->setCellValue('B1', 'Lí do');
                $row = 2;
                foreach ($dataFails as $dataFail) {
                    $sheet->setCellValue('A' . $row, $dataFail['row'])
                          ->setCellValue('B' . $row, $dataFail['reason']);
                    $row++;
                }
                $excelWriter   = new Xlsx($excel);
                $fileNames     = explode('.', $fileName);
                $time          = time();
                $fileFailName  = "{$fileNames[0]}_{$time}_error.xlsx";
                $excelFileName = storage_path() . '/app/public/leads/' . $fileFailName;
                $excelWriter->save($excelFileName);
            }

            $textFail = $totalFail;
            if ($totalFail > 0) {
                $textFail = ' <a download href="' . asset("storage/leads/{$fileFailName}") . '" class=" m-link m--font-danger" title="' . __('Download error file') . '">' . $totalFail . '</a>';
            }

            return response()->json([
                'message' => 'File ' . $fileImport->getClientOriginalName() . __(' import successfully') . ". Số dòng thành công: {$totalSuccess}. Số dòng thất bại: {$textFail}",
            ]);
        }

        return response()->json([
            'message' => __('File not found')
        ], 500);
    }

    /**
     * @param Lead $lead
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function formChangeState(Lead $lead)
    {
        return view('business.leads._form_change_state', ['lead' => $lead]);
    }

    /**
     * @param Lead $lead
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeState(Lead $lead, Request $request)
    {
        $newState = $request->state;
        $comment  = $request->comment;

        if ($newState) {
            $lead->update([
                'state'   => $newState,
                'comment' => $comment
            ]);

            //state = 8: lưu vào bảng appointment
            if ($newState == 8) {
                Appointment::create([
                    'lead_id' => $lead->id,
                    'user_id' => auth()->id()
                ]);
            }

            //state = 7: lưu vào bảng callback
            if ($newState == 7) {
                Callback::create([
                    'lead_id' => $lead->id,
                    'user_id' => auth()->id()
                ]);
            }

            return response()->json([
                'message' => __('Data edited successfully')
            ]);
        }

        return response()->json([
            'message' => __('Data edited unsuccessfully')
        ]);
    }
}