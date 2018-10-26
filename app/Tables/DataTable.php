<?php

namespace App\Tables;

/**
 * Class DataTable
 * @property integer $draw
 * @property integer $length
 * @property integer $start
 * @property mixed $searchValue
 * @property integer $column
 * @property string $direction
 * @property integer $totalRecords
 * @property integer $totalFilteredRecords
 * @property array $data
 * @property array $filters
 * @property boolean $isFilterNotEmpty
 * @package common\utils\table
 */
abstract class DataTable
{
    public $draw = 1;
    public $length = 10;
    public $start = 0;
    public $searchValue = '';
    public $column = 'id';
    public $direction = 'desc';
    public $totalRecords = 0;
    public $totalFilteredRecords = 0;
    public $filters = [];
    public $isFilterNotEmpty = false;
    public $data = [];

    public function __construct(array $args = null)
    {
        $arguments         = $args ?? request()->post();
        $this->draw        = $arguments['draw'];
        $this->length      = ! isset($arguments['length']) || $arguments['length'] < 0 ? 10 : $arguments['length'];
        $this->start       = $arguments['start'];
        $this->searchValue = $arguments['search']['value'];
        if (array_key_exists('data', $arguments)) {
            $this->data = $arguments['data'];
        }
        if (array_key_exists('order', $arguments)) {
            $this->column    = $arguments['order'][0]['column'];
            $this->direction = $arguments['order'][0]['dir'];
        }
        if (array_key_exists('filters', $arguments)) {
            $filters       = json_decode($arguments['filters'], JSON_FORCE_OBJECT);
            $this->filters = collect($filters)->mapWithKeys(function ($filter) {
                return [$filter['name'] => $filter['value']];
            })->toArray();
        }

        $this->isFilterNotEmpty = collect($this->filters)->filter(function ($filter) {
            return ! isValueEmpty($filter);
        })->isNotEmpty();
    }

    abstract public function getData(): array;

    abstract public function getModels();

    public function getColumn(): string
    {
        return $this->column;
    }
}