<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReportExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $data;
    protected $reportType;

    public function __construct(Collection $data, string $reportType)
    {
        $this->data = $data;
        $this->reportType = $reportType;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // تحويل البيانات إلى تنسيق مناسب للتصدير
        return $this->data->map(function ($item) {
            $row = [
                'ID' => $item->id,
                'Property' => $item->property->name ?? 'N/A',
                'Date' => $item->created_at->format('Y-m-d'),
                'Amount' => $item->amount,
                'Description' => $item->description ?? $item->title,
                'Category' => $item->category ?? 'N/A',
                'Created By' => $item->createdBy->name ?? 'N/A',
            ];

            if ($this->reportType === 'payment') {
                $row['Tenant'] = $item->tenant->name ?? 'N/A';
                $row['Contract'] = $item->contract->id ?? 'N/A';
            }

            return $row;
        });
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        $headings = [
            'ID',
            'Property',
            'Date',
            'Amount',
            'Description/Title',
            'Category',
            'Created By',
        ];

        if ($this->reportType === 'payment') {
            $headings[] = 'Tenant';
            $headings[] = 'Contract ID';
        }

        return $headings;
    }
}
