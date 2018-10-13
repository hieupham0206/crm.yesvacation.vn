<?php

namespace App\Tables\Admin;

use App\Models\Appointment;
use App\Tables\DataTable;

class AppointmentTable extends DataTable
{
    public function getColumn(): string
    {
        $column = $this->column;

        switch ($column) {
            case '1':
                $column = 'appointments.name';
                break;
            case '2':
                $column = 'appointments.title';
                break;
            case '3':
                $column = 'appointments.created_at';
                break;
            default:
                $column = 'appointments.id';
                break;
        }

        return $column;
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function getData(): array
    {
        $this->column = $this->getColumn();
        $appointments = $this->getModels();
        $dataArray    = [];
        $modelName    = (new Appointment)->classLabel(true);

        $canUpdateAppointment = can('update-appointment');
        $canDeleteAppointment = can('delete-appointment');

        /** @var Appointment[] $appointments */
        foreach ($appointments as $appointment) {
            $btnEdit = $btnDelete = '';

            if ($canUpdateAppointment) {
                $btnEdit = ' <a href="' . route('appointments.edit', $appointment, false) . '" class="btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--pill" title="' . __('Edit') . '">
					<i class="fa fa-edit"></i>
				</a>';
            }

            if ($canDeleteAppointment) {
                $btnDelete = ' <button type="button" data-title="' . __('Delete') . ' ' . $modelName . ' ' . $appointment->name . ' !!!" class="btn btn-sm btn-danger btn-delete m-btn m-btn--icon m-btn--icon-only m-btn--pill"
                data-url="' . route('appointments.destroy', $appointment, false) . '" title="' . __('Delete') . '">
                    <i class="fa fa-trash"></i>
                </button>';
            }

            $dataArray[] = [
                "<a class='link-lead-name m-link m--font-brand' href='javascript:void(0)' data-lead-id='{$appointment->lead_id}'>{$appointment->lead->name}</a>",
                $appointment->lead->title,
                optional($appointment->appointment_datetime)->format('d-m-Y H:i'),

                $btnEdit . $btnDelete
            ];
        }

        return $dataArray;
    }

    /**
     * @return Appointment[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getModels()
    {
        $appointments = Appointment::query();

        $this->totalFilteredRecords = $this->totalRecords = $appointments->count();

        if ($this->isFilterNotEmpty) {
            $appointments->filters($this->filters);

            $this->totalFilteredRecords = $appointments->count();
        }

        return $appointments->limit($this->length)->offset($this->start)
                            ->orderBy($this->column, $this->direction)->get();
    }
}