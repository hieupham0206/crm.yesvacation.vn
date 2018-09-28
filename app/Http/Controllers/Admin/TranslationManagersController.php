<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Core\TranslateManager;
use App\Http\Controllers\Controller;
use App\Tables\Admin\TranslationManagerTable;
use App\Tables\TableFacade;

class TranslationManagersController extends Controller
{
    protected $name = 'user';

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
        return view('admin.translation_managers.index');
    }

    /**
     * @return string
     */
    public function table()
    {
        return (new TableFacade(new TranslationManagerTable))->getDataTable();
    }

    public function edit()
    {
        $key            = request()->get('key');
        $translatedText = request()->get('translatedText');

        return view('admin.translation_managers.translation_detail', compact('key', 'translatedText'));
    }

    public function update()
    {
        $key            = request()->get('key');
        $translatedText = request()->get('text');

        $manager = new TranslateManager();

        try {
            if ($manager->importTranslation($key, $translatedText)) {
                return response()->json([
                    'message' => __('Data edited successfully')
                ]);
            }

            return response()->json([
                'message' => __('Data edited unsuccessfully'),
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'message' => __('Data edited unsuccessfully') . ": {$e->getMessage()}",
            ], $e->getStatusCode());
        }
    }
}
