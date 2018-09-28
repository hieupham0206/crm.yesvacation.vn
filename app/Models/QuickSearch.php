<?php

namespace App\Models;

use App\Traits\Core\Searchable;

/**
 * App\Models\QuickSearch
 *
 * @property int $id
 * @property string|null $model_type Loại model lưu để index
 * @property string|null $route
 * @property string $search_text
 * @property-read \App\Models\ActivityLog $createdBy
 * @property-read \App\Models\ActivityLog $deletedBy
 * @property-read mixed $created_at
 * @property-read \App\Models\ActivityLog $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel andFilterWhere($conditions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel dateBetween($dates, $column = 'created_at', $format = 'd-m-Y', $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel filters($filterDatas, $boolean = 'and', $filterConfigs = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel orFilterWhere($conditions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuickSearch search($term)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuickSearch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuickSearch whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuickSearch whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuickSearch whereSearchText($value)
 * @mixin \Eloquent
 */
class QuickSearch extends \App\Models\Base\QuickSearch
{
    use Searchable;

    protected $fillable = [
        'search_text',
        'model_type',
        'route',
    ];

    protected $searchable = [
        'search_text'
    ];
}
