<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 1/23/2018
 * Time: 2:01 PM
 */

namespace App\Tables\Admin;

use App\Entities\Core\TranslateManager;
use App\Models\ActivityLog;
use App\Tables\DataTable;

class TranslationManagerTable extends DataTable
{
    public function getColumn(): string
    {
        $column = $this->column;

        switch ($column) {
            default:
                $column = 'activity_log.id';
                break;
        }

        return $column;
    }

    public function getData(): array
    {
        $this->column = $this->getColumn();
        $texts        = $this->getModels();
        $dataArray    = [];
        /** @var ActivityLog[] $texts */
        foreach ($texts as $key => $text) {
            $dataArray[] = [
                $key,
                $text,
                '<button type="button" data-url="' . route('translation_managers.edit_detail') . '"
                                            class="btn btn-sm btn-edit-translation btn-info m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--outline-2x m-btn--pill" title="' . __('Edit') . '">
                                        <i class="la la-edit"></i>
                                    </button>'
            ];
        }

        return $dataArray;
    }

    /**
     * @return array
     */
    public function getModels(): array
    {
        $manager = new TranslateManager();

        $fileTranslations = $manager->findTranslations();
        $translatedTexts  = $manager->readFileTranslate();

        $untranslatedTexts = array_values(array_diff($fileTranslations, array_keys($translatedTexts)));
        $untranslatedTexts = array_reduce(array_map(function ($obj) {
            return ! starts_with($obj, 'action.') ? ['key' => $obj] : null;
        }, $untranslatedTexts), function ($result, $item) {
            if ($item !== null) {
                $result[$item['key']] = '';
            }

            return $result;
        });
        $search            = $this->searchValue;
        $mergedTexts       = array_merge($translatedTexts, $untranslatedTexts);

        $texts = collect($mergedTexts);

        if ($search) {
            $texts = $texts->filter(function ($obj, $key) use ($search) {
                return strpos($key, $search) !== false || strpos($obj, $search) !== false;
            });
        }

        $this->totalFilteredRecords = $this->totalRecords = $texts->count();

        return $texts->sort()->all();
    }
}