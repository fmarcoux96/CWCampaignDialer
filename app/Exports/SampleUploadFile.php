<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SampleUploadFile implements FromArray, WithHeadings
{
    /**
    * @return array
    */
    public function array(): array
    {
        return [
            [1000, 'Sample', '555-555-5555', 'Source', 'Notes', '2021-01-01']
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Number',
            'Source',
            'Notes',
            'Created At',
        ];
    }
}
