<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HistoryCall;
use App\Tables\TableFacade;
use App\Tables\Admin\HistoryCallTable;
use Illuminate\Http\Request;

class HistoryCallsController extends Controller
{
     /**
      * Tên dùng để phân quyền
      * @var string
      */
	 protected $name = 'historyCall';

    /**
     * Hiển thị trang danh sách HistoryCall.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view( 'admin.history_calls.index' )->with('historyCall', new HistoryCall);
    }

    /**
     * Lấy danh sách HistoryCall cho trang table ở trang index
     * @return string
     */
    public function table() {
    	return ( new TableFacade( new HistoryCallTable() ) )->getDataTable();
    }

    /**
     * Trang tạo mới HistoryCall.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.history_calls.create')->with('historyCall', new HistoryCall);
    }

    /**
     * Lưu HistoryCall mới.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
			'name' => 'required'
		]);
        $requestData = $request->all();
        HistoryCall::create($requestData);

        return redirect(route('history_calls.index'))->with('message', __( 'Data created successfully' ));
    }

    /**
     * Trang xem chi tiết HistoryCall.
     *
     * @param  HistoryCall $historyCall
     * @return \Illuminate\View\View
     */
    public function show(HistoryCall $historyCall)
    {
        return view('admin.history_calls.show', compact('historyCall'));
    }

    /**
     * Trang cập nhật HistoryCall.
     *
     * @param  HistoryCall $historyCall
     * @return \Illuminate\View\View
     */
    public function edit(HistoryCall $historyCall)
    {
        return view('admin.history_calls.edit', compact('historyCall'));
    }

    /**
     * Cập nhật HistoryCall tương ứng.
     *
     * @param \Illuminate\Http\Request $request
     * @param  HistoryCall $historyCall
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, HistoryCall $historyCall)
    {
        $this->validate($request, [
			'name' => 'required'
		]);
        $requestData = $request->all();
        $historyCall->update($requestData);

        return redirect(route('history_calls.index'))->with('message', __( 'Data edited successfully' ));
    }

    /**
     * Xóa HistoryCall.
     *
     * @param HistoryCall $historyCall
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(HistoryCall $historyCall)
    {
        try {
        	  $historyCall->delete();
        } catch ( \Exception $e ) {
            return response()->json( [
                'message' => "Error: {$e->getMessage()}"
            ], $e->getCode() );
        }

        return response()->json( [
            'message' => __('Data deleted successfully')
        ] );
    }

    /**
     * Xóa nhiều HistoryCall.
     *
     * @return mixed|\Symfony\Component\HttpFoundation\ParameterBag
     * @throws \Exception
     */
    public function destroys() {
        try {
            $ids = \request()->get( 'ids' );
            HistoryCall::destroy( $ids );
        } catch ( \Exception $e ) {
            return response()->json( [
                'message' => "Error: {$e->getMessage()}"
            ], $e->getCode() );
        }

        return response()->json( [
            'message' => __( 'Data deleted successfully' )
        ] );
    }

    /**
     * Lấy danh sách HistoryCall theo dạng json
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function historyCalls() {
        $query  = request()->get( 'query', '' );
        $page   = request()->get( 'page', 1 );
        $excludeIds = request()->get( 'excludeIds', [] );
        $offset = ( $page - 1 ) * 10;
        $historyCalls  = HistoryCall::query()->select( [ 'id', 'name' ] );

        $historyCalls->andFilterWhere( [
            [ 'name', 'like', $query ],
            ['id', '!=', $excludeIds]
        ]);

        $totalCount = $historyCalls->count();
        $historyCalls      = $historyCalls->offset($offset)->limit(10)->get();

        return response()->json( [
            'total_count' => $totalCount,
            'items'       => $historyCalls->toArray(),
        ] );
    }
}