<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Tables\TableFacade;
use App\Tables\Business\LeadTable;
use Illuminate\Http\Request;

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
        return view( 'business.leads.index' )->with('lead', new Lead);
    }

    /**
     * Lấy danh sách Lead cho trang table ở trang index
     * @return string
     */
    public function table() {
    	return ( new TableFacade( new LeadTable() ) )->getDataTable();
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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
			'name' => 'required'
		]);
        $requestData = $request->all();
        Lead::create($requestData);

        return redirect(route('leads.index'))->with('message', __( 'Data created successfully' ));
    }

    /**
     * Trang xem chi tiết Lead.
     *
     * @param  Lead $lead
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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Lead $lead)
    {
        $this->validate($request, [
			'name' => 'required'
		]);
        $requestData = $request->all();
        $lead->update($requestData);

        return redirect(route('leads.index'))->with('message', __( 'Data edited successfully' ));
    }

    /**
     * Xóa Lead.
     *
     * @param Lead $lead
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Lead $lead)
    {
        try {
        	  $lead->delete();
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
     * Xóa nhiều Lead.
     *
     * @return mixed|\Symfony\Component\HttpFoundation\ParameterBag
     * @throws \Exception
     */
    public function destroys() {
        try {
            $ids = \request()->get( 'ids' );
            Lead::destroy( $ids );
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
     * Lấy danh sách Lead theo dạng json
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function leads() {
        $query  = request()->get( 'query', '' );
        $page   = request()->get( 'page', 1 );
        $excludeIds = request()->get( 'excludeIds', [] );
        $offset = ( $page - 1 ) * 10;
        $leads  = Lead::query()->select( [ 'id', 'name' ] );

        $leads->filterWhere( [
            [ 'name', 'like', $query ],
            ['id', '!=', $excludeIds]
        ]);

        $totalCount = $leads->count();
        $leads      = $leads->offset($offset)->limit(10)->get();

        return response()->json( [
            'total_count' => $totalCount,
            'items'       => $leads->toArray(),
        ] );
    }
}