<?php

namespace App\Tables\Business;

use App\Models\Lead;
use App\Tables\DataTable;

class LeadTable extends DataTable
{
    public function getColumn(): string
    {
        $column = $this->column;

        switch ($column) {
            case '1':
                $column = 'leads.name';
                break;
            case '2':
                $column = 'leads.title';
                break;
            case '3':
                $column = 'leads.email';
                break;
            case '4':
                $column = 'leads.';
                break;
            case '5':
                $column = 'leads.gender';
                break;
            case '6':
                $column = 'leads.dob';
                break;
            case '7':
                $column = 'leads.address';
                break;
            case '8':
                $column = 'leads.phone';
                break;
            case '9':
                $column = 'leads.state';
                break;
            case '10':
                $column = 'leads.comment';
                break;
            default:
                $column = 'leads.id';
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
        $leads        = $this->getModels();
        $dataArray    = [];
        $modelName    = (new Lead)->classLabel(true);

        $canUpdateLead = can('update-lead');
        $canDeleteLead = can('delete-lead');

        /** @var Lead[] $leads */
        foreach ($leads as $lead) {
            $btnEdit = $btnDelete = '';

            if ($canUpdateLead) {
                $btnEdit = ' <a href="' . route('leads.edit', $lead, false) . '" class="btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--pill" title="' . __('Edit') . '">
					<i class="fa fa-edit"></i>
				</a>';
            }

            if ($canDeleteLead) {
                $btnDelete = ' <button type="button" data-title="' . __('Delete') . ' ' . $modelName . ' ' . $lead->name . ' !!!" class="btn btn-sm btn-danger btn-delete m-btn m-btn--icon m-btn--icon-only m-btn--pill"
                data-url="' . route('leads.destroy', $lead, false) . '" title="' . __('Delete') . '">
                    <i class="fa fa-trash"></i>
                </button>';
            }
            $dataArray[] = [
                '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"><input type="checkbox" value="' . $lead->id . '"><span></span></label>',
                $lead->name,
                $lead->title,
                $lead->email,
//                $lead->gender_text,
                optional($lead->birthday)->format('d-m-Y'),
                $lead->address,
                $lead->phone,
                $lead->state_text,

                '<a href="' . route('leads.show', $lead, false) . '" class="btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--pill" title="' . __('View') . '">
					<i class="fa fa-eye"></i>
				</a>' . $btnEdit . $btnDelete
            ];
        }

        return $dataArray;
    }

    /**
     * @return Lead[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getModels()
    {
        $leads = Lead::query();

        $this->totalFilteredRecords = $this->totalRecords = $leads->count();

        if ($this->isFilterNotEmpty) {
            $leads->filters($this->filters);

            $this->totalFilteredRecords = $leads->count();
        }

        return $leads->limit($this->length)->offset($this->start)
                     ->orderBy($this->column, $this->direction)->get();
    }
}