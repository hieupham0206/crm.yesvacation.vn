<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Tables\TableFacade;
use App\Tables\Admin\DepartmentTable;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
     /**
      * Tên dùng để phân quyền
      * @var string
      */
	 protected $name = 'department';

    /**
     * Hiển thị trang danh sách Department.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view( 'admin.departments.index' )->with('department', new Department);
    }

    /**
     * Lấy danh sách Department cho trang table ở trang index
     * @return string
     */
    public function table() {
    	return ( new TableFacade( new DepartmentTable() ) )->getDataTable();
    }

    /**
     * Trang tạo mới Department.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.departments.create')->with('department', new Department);
    }

    /**
     * Lưu Department mới.
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
        Department::create($requestData);

        return redirect(route('departments.index'))->with('message', __( 'Data created successfully' ));
    }

    /**
     * Trang xem chi tiết Department.
     *
     * @param  Department $department
     * @return \Illuminate\View\View
     */
    public function show(Department $department)
    {
        return view('admin.departments.show', compact('department'));
    }

    /**
     * Trang cập nhật Department.
     *
     * @param  Department $department
     * @return \Illuminate\View\View
     */
    public function edit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }

    /**
     * Cập nhật Department tương ứng.
     *
     * @param \Illuminate\Http\Request $request
     * @param  Department $department
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Department $department)
    {
        $this->validate($request, [
			'name' => 'required'
		]);
        $requestData = $request->all();
        $department->update($requestData);

        return redirect(route('departments.index'))->with('message', __( 'Data edited successfully' ));
    }

    /**
     * Xóa Department.
     *
     * @param Department $department
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Department $department)
    {
        try {
        	  $department->delete();
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
     * Xóa nhiều Department.
     *
     * @return mixed|\Symfony\Component\HttpFoundation\ParameterBag
     * @throws \Exception
     */
    public function destroys() {
        try {
            $ids = \request()->get( 'ids' );
            Department::destroy( $ids );
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
     * Lấy danh sách Department theo dạng json
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function departments() {
        $query  = request()->get( 'query', '' );
        $page   = request()->get( 'page', 1 );
        $excludeIds = request()->get( 'excludeIds', [] );
        $offset = ( $page - 1 ) * 10;
        $departments  = Department::query()->select( [ 'id', 'name' ] );

        $departments->filterWhere( [
            [ 'name', 'like', $query ],
            ['id', '!=', $excludeIds]
        ]);

        $totalCount = $departments->count();
        $departments      = $departments->offset($offset)->limit(10)->get();

        return response()->json( [
            'total_count' => $totalCount,
            'items'       => $departments->toArray(),
        ] );
    }
}