<?php

namespace App\Tables;

/**
 * Class TableFacade
 * @property DataTable $dataTable
 * @package common\utils\table
 */
class TableFacade
{
    private $dataTable;

    public function __construct(DataTable $dataTable)
    {
        $this->dataTable = $dataTable;
    }

    private function getData(): array
    {
        return $this->dataTable->getData();
    }

    private function getTotalRecord(): int
    {
        return $this->dataTable->totalRecords;
    }

    private function getDraw(): int
    {
        return $this->dataTable->draw;
    }

    private function getTotalFiltered(): int
    {
        return $this->dataTable->totalFilteredRecords;
    }

    public function getDataTable(): string
    {
        $data = [
            'data'            => $this->getData(),
            'draw'            => $this->getDraw(),
            'recordsTotal'    => $this->getTotalRecord(),
            'recordsFiltered' => $this->getTotalFiltered(),
        ];

        return json_encode($data);
    }
}