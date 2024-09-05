<?php

namespace App\Exports\Results;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ResultExport implements FromCollection, WithHeadings, WithMapping
{

    protected $results;

    public function __construct(Collection $results)
    {
        $this->results = $results;
    }

    public function collection()
    {
        return $this->results;
    }

    public function headings(): array
    {
        return [
            'ល.រ',
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
        ];
    }

    public function map($result): array
    {
        return [
            $result->id,
            $result->subAccountKey->accountKey->key->code,
            $result->subAccountKey->accountKey->account_key,
            $result->subAccountKey->sub_account_key,
            $result->result_key,
            $result->name_result_key,
            $result->fin_law,
            $result->current_loan,
            $result->internal_increase,
            $result->unexpected_increase,
            $result->additional_increase,
            $result->decrease,
            $result->editorial,
            $result->new_credit_status,
            $result->early_balance,
            $result->apply,
            $result->deadline_balance,
            $result->credit,
            $result->law_average,
            $result->law_correction
        ];
    }
}