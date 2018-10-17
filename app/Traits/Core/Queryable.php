<?php

namespace App\Traits\Core;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

trait Queryable
{
    private $conditions = [];

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $conditions
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeAndFilterWhere($query, $conditions)
    {
        if (isValueEmpty($conditions)) {
            return $query;
        }

        if (\is_array($conditions[0])) {
            foreach ($conditions as $condition) {
                $this->addCondition($condition);
            }

            return $this->build($query);
        }
        $this->addCondition($conditions);

        return $this->build($query);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $conditions
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeOrFilterWhere($query, $conditions)
    {
        if (isValueEmpty($conditions)) {
            return $query;
        }

        if (\is_array($conditions[0])) {
            foreach ($conditions as $condition) {
                $this->addCondition($condition, 'or');
            }

            return $this->build($query);
        }
        $this->addCondition($conditions, 'or');

        return $this->build($query);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $dates
     * @param string $column
     * @param string $format
     * @param string $boolean
     * @param bool $not
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeDateBetween($query, $dates, $column = 'created_at', $format = 'd-m-Y', $boolean = 'and', $not = false)
    {
        [$fromDate, $toDate] = $dates;
        if (isValueEmpty($fromDate) || isValueEmpty($toDate)) {
            return $query;
        }

        $fromDate = Carbon::createFromFormat($format, $fromDate);
        $toDate   = Carbon::createFromFormat($format, $toDate);

        return $query->whereBetween($column, [
            $fromDate->toDateString() . ' 00:00:00',
            $toDate->toDateString() . ' 23:59:59'
        ], $boolean, $not);
    }

    /**
     * @param $query
     * @param $filterDatas         Data dùng để filter
     * @param string $boolean
     * @param array $filterConfigs Custom filter config
     *
     * @return mixed
     */
    public function scopeFilters($query, $filterDatas, $boolean = 'and', array $filterConfigs = null)
    {
        if (isValueEmpty($filterDatas) || ! property_exists($this, 'filters')) {
            return $query;
        }

        //property $filters của model
        $filters = $this->filters;
        if ($filterConfigs) {
            $filters = array_merge($filters, $filterConfigs);
        }

        foreach ($filters as $column => $operator) {
            if (isset($filterDatas[$column])) {
                $filterVal = $filterDatas[$column];
                $this->addCondition([$column, $operator, $filterVal], $boolean);
            }
        }

        return $this->build($query);
    }

    /**
     * @param $configs
     * @param string $boolean
     *
     * @return void
     */
    private function addCondition($configs, $boolean = 'and')
    {
        [$column, $operator, $value] = $configs;

        if ( ! isValueEmpty($value)) {
            [$column, $isForeignKey, $relation, $value, $table] = $this->preparedParam($operator, $column, $value);

            $this->conditions[] = [$column, $value, $boolean, $operator, $isForeignKey, $relation, $table];
        }
    }

    /**
     * @param Builder $query
     *
     * @return mixed
     */
    private function build(Builder $query)
    {
        return $query->where(function (Builder $subQuery) {
            foreach ($this->conditions as $condition) {
                [$column, $value, $boolean, $operator, $isForeignKey, $relation, $table] = $condition;
                if ($isForeignKey) {
                    return $subQuery->whereHas($relation, function (Builder $q) use ($column, $value, $operator, $boolean, $table) {
                        if (\is_array($value)) {
                            $q->whereIn($column, $value, $boolean, $operator === '!=');
                        } else {
                            $q->where("$table.$column", $operator, $value, $boolean);
                        }
                    });
                }

                if (\is_array($value) && $value) {
                    $subQuery->whereIn($column, $value, $boolean, $operator === '!=');
                }

                $subQuery->where($column, $operator, $value, $boolean);
            }

            return $subQuery;
        });
    }

    /**
     * @param $operator
     * @param $column
     * @param $value
     *
     * @return array
     */
    private function preparedParam($operator, $column, $value): array
    {
        $isForeignKey = $relation = false;
        $table        = '';
        if (strpos($column, '.') !== false) {
            $columns = collect(explode('.', $column));
            $column  = $columns->last();

            $isForeignKey = true;
            $relation     = $columns->implode('.');

            if (strpos($relation, '.') !== false) {
                $tableAndColumn = collect(explode('.', $relation));

                $tableAndColumn->pop();
                $relation = $tableAndColumn->pop();
                $table    = $tableAndColumn->first();
            }
        }

        if (strtolower($operator) === 'like') {
            $value = "%$value%";
        }

        return [$column, $isForeignKey, $relation, $value, $table];
    }
}