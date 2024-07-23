<?php

namespace App\Exports;

use App\Http\Models\project_registry;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ProjectsExport implements  WithHeadings, FromQuery, WithEvents, ShouldAutoSize
{
    use Exportable;
    public $fieldColumn;
    public $search;

    public function headings(): array
    {
        return [
            '#',
            'Project_Code',
            'Project_Short_name',
            'project_type',
            'project_team',
            'Project_Status',
            'Project_Client',
            'Project_Title',
            'Project_Contract_No',
            'project_tender_no',
            'tender_id',
            'project_contract_period',
            'Project_PO_No',
            'contract_original_value',
            'contract_vo_value',
            'Tarikh_Pesanan',
            'Project_Commencement_Date',
            'Project_Completion_Date',
            'contract_eot',
            'Project_Close_Date',
            'Project_Liquidity_And_Damages',
            'Project_Defect_Liability_Period',
            'Project_Prepared_by',
            'Project_Date_Prepared',
            'Project_Important_Note',
            'Retention',
            'EntryDate',
            'zone_code',
            'location',
            'isdelete',
            'jt_project_code'
        ];
    }
   
    protected $dataToExcel;

    public function __construct($fieldColumn, $search)
    {
        $this->fieldColumn = $fieldColumn;
        $this->search = $search;

    }

    public function query()
    {
        if(!is_null($this->search)) {
            return project_registry::query()->where('project_registry'.'.'.$this->fieldColumn, 'LIKE', "%".$this->search."%");
        }
        else{
            return project_registry::query();
        }
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:AL1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);
            },
        ];
    }
}