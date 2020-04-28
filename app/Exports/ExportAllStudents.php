<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportAllStudents implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents {

    private $data;

    public function __construct($data) {
        $this->data = $data;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection() {
        try {
            $result = $this->data;
            return $result;
        } catch (\Exception $e) {
            \Log::emergency($e);
            return 'Failed';
        }
    }

    public function headings(): array {

        return [
            'ID',
            'Name',
            'Class',
            'City',
            'State',
            'PinCode',
            'Address',
            'Created At',
            'Updated At'
        ];
    }

    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
            },
        ];
    }

}
