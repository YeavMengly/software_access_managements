<?php

namespace App\Exports\Results;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
// use Maatwebsite\Excel\Concerns\WithStyles;
// use Maatwebsite\Excel\Concerns\WithEvents;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// use Maatwebsite\Excel\Events\AfterSheet;
// use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
// use PhpOffice\PhpSpreadsheet\Style\Border;
// use PhpOffice\PhpSpreadsheet\Style\Alignment;
// use PhpOffice\PhpSpreadsheet\Style\Fill;

class ResultExport implements FromCollection, WithHeadings, WithMapping
{
    protected $reports;

    public function __construct(Collection $reports)
    {
        $this->reports = $reports;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->reports;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ល.រ',
            // 'Date',
            'ជំពូក',
            'គណនី',
            'អនុគណនី', 
            'លេខកូដកម្មវិធី',
            'ចំណាត់ថ្នាក់',
            'ច្បាប់ហិរញ្ញវត្ថុ',
            'ឥណទានបច្ចុប្បន្ន',
            'កើនផ្ទៃក្នុង',
            'មិនបានគ្រោងទុក',
            'បំពេញបន្ថែម',
            'ថយ',
            'វិចារណកម្ម',
            'ស្ថានភាពឥណទានថ្មី',
            'សមតុល្យដើមគ្រា',
            'អនុវត្ត',
            'សមតុល្យចុងគ្រា',
            'ឥណទាននៅសល់',
            'ច្បាប់',
            'ច្បាប់កែតម្រូវ'
            // Add other headings as needed
        ];
    }

    /**
     * @param mixed $report
     * @return array
     */
    public function map($report): array
    {
        return [
            $report->id,
            // $report->date ? $report->date->format('m/d/Y') : 'N/A', // Handle null date
            $report->subAccountKey->accountKey->key->code,
            $report->subAccountKey->accountKey->account_key,
            $report->subAccountKey->sub_account_key,
            $report->report_key,
            $report->name_report_key,
            $report->fin_law,
            $report->current_loan,
            $report->internal_increase,
            $report->unexpected_increase,
            $report->additional_increase,
            $report->decrease,
            $report->editorial,
            $report->new_credit_status,
            $report->early_balance,
            $report->apply,
            $report->deadline_balance,
            $report->credit,
            $report->law_average,
            $report->law_correction
            // Add other fields as needed
        ];
    }

    // public function styles(Worksheet $sheet)
    // {
    //     $sheet->getStyle('A1:I1')->applyFromArray([
    //         'font' => [
    //             'bold' => true,
    //             'size' => 12,
    //         ],
    //         'alignment' => [
    //             'horizontal' => Alignment::HORIZONTAL_CENTER,
    //             'vertical' => Alignment::VERTICAL_CENTER,
    //         ],
    //         'borders' => [
    //             'allBorders' => [
    //                 'borderStyle' => Border::BORDER_THIN,
    //             ],
    //         ],
    //         'fill' => [
    //             'fillType' => Fill::FILL_SOLID,
    //             'startColor' => [
    //                 'argb' => 'FFFFF000',
    //             ],
    //         ],
    //     ]);

    //     return [
    //         // Apply styles to the first row, which is the header
    //         1 => ['font' => ['bold' => true]],
    //     ];
    // }

    /**
     * @return array
     */
    // public function registerEvents(): array
    // {
    //     return [
    //         AfterSheet::class => function (AfterSheet $event) {
    //             // Merge cells for the header
    //             $event->sheet->getDelegate()->mergeCells('A1:I1');
    //             // Style the header
    //             $event->sheet->getDelegate()->getStyle('A1:I1')->applyFromArray([
    //                 'font' => [
    //                     'bold' => true,
    //                     'size' => 14,
    //                 ],
    //                 'alignment' => [
    //                     'horizontal' => Alignment::HORIZONTAL_CENTER,
    //                     'vertical' => Alignment::VERTICAL_CENTER,
    //                 ],
    //             ]);
    //         },
    //     ];
    // }
}
