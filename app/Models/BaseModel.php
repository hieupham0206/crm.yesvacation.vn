<?php

namespace App\Models;

use App\Traits\Core\Labelable;
use App\Traits\Core\Linkable;
use App\Traits\Core\Modelable;
use App\Traits\Core\Queryable;
use App\Traits\Core\Responsible;

/**
 * App\Models\BaseModel
 *
 * @property-read \App\Models\ActivityLog $createdBy
 * @property-read \App\Models\ActivityLog $deletedBy
 * @property-read \App\Models\ActivityLog $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel andFilterWhere($conditions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel dateBetween($dates, $column = 'created_at', $format = 'd-m-Y', $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel filters($filterDatas, $boolean = 'and', $filterConfigs = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel orFilterWhere($conditions)
 * @mixin \Eloquent
 */
class BaseModel extends \Illuminate\Database\Eloquent\Model
{
    use Responsible, Labelable, Queryable, Linkable, Modelable;

    /**
     * Tên custom action dùng để lưu log hoạt động
     * @var string
     */
    public $action = '';

    /**
     * Custom message log
     * @var string
     */
    public $message = '';

    /**
     * Route của model dùng cho Linkable trait
     * @var string
     */
    public $route = '';

    /**
     * Column dùng để hiển thị cho model (Default là name)
     * @var string
     */
    public $displayAttribute = 'name';

    /**
     * Text hiển thị cho column
     * @var array
     */
    public $labels = [];

    /**
     * Định nghĩa các field cho filter
     * @var array
     */
    public $filters = [];
}