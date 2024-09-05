<?php

namespace App\Exports\Loans;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class NewLoan implements FromCollection, WithHeadings, WithMapping
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
}
