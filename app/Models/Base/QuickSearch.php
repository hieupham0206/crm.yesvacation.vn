<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 04 Jun 2018 17:09:49 +0700.
 */

namespace App\Models\Base;

use App\Models\BaseModel as Eloquent;

/**
 * App\Models\Base\QuickSearch
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\QuickSearch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\QuickSearch whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\QuickSearch whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\QuickSearch whereSearchText($value)
 * @mixin \Eloquent
 */
class QuickSearch extends Eloquent
{
    protected $table = 'quick_searchs';
    public $timestamps = false;

    protected $casts = [
        'model_id' => 'int'
    ];
}
