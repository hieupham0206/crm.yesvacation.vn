<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected $name = '';

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware(['auth', 'active']);
        $this->middleware(['rolepermission:view-' . $this->name], ['only' => ['index', 'show']]);
        $this->middleware(['rolepermission:create-' . $this->name], ['only' => ['create', 'store']]);
        $this->middleware(['rolepermission:update-' . $this->name], ['only' => ['edit', 'update']]);
        $this->middleware(['rolepermission:delete-' . $this->name], ['only' => ['destroy']]);
    }

    public function asJson(array $params = [], $code = 200)
    {
        return response()->json($params, $code);
    }
}
