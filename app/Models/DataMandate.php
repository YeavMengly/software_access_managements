<?php

namespace App\Models;

use App\Models\Code\Loans;
use App\Models\Code\Report;
use App\Models\Code\SubAccountKey;
use App\Models\Code\Year;
use App\Models\Mandates\Mandate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMandate extends Model
{
    use HasFactory;

    protected $table = 'data_mandates';
    protected $fillable = [
        'sub_account_key',
        'report_key',
        'name_report_key',
        'fin_law',
        'current_loan',
        'date_year',
        'new_credit_status',
        'early_balance',
        'apply',
        'deadline_balance',
        'credit',
        'law_average',
        'law_correction',
    ];

    protected $casts = [
        'date_year' => 'date:Y-m-d', // Ensure proper date format
    ];
    protected $dates = ['date_column'];

    public function year()
    {
        return $this->belongsTo(Year::class, 'date_year', 'id');
    }
    public function subAccountKey()
    {
        return $this->belongsTo(SubAccountKey::class, 'sub_account_key', 'sub_account_key'); // Ensure 'sub_account_key_id' matches your database column
    }

    public function mandate()
    {
        return $this->hasOne(Mandate::class, 'report_key', 'report_key');
    }

    public function report()
    {
        return $this->belongsTo(Report::class, 'report_key', 'report_key');
    }



    public static function getReportSql()
    {
        return self::select([
            'keys.name',
            'keys.code',
            'ak.account_key as account_key',
            'ak.name_account_key as name_account_key',
            'sak.sub_account_key as sub_account_key',
            'sak.name_sub_account_key as name_sub_account_key',
            'data_mandates.report_key as report_key',
            'data_mandates.fin_law as fin_law',
            'data_mandates.current_loan as current_loan',

            'data_mandates.new_credit_status as new_credit_status',
            'data_mandates.early_balance as early_balance',
            'data_mandates.apply as apply',
            'data_mandates.deadline_balance as deadline_balance',
            'data_mandates.credit as credit',
            'data_mandates.law_average as law_average',
            'data_mandates.law_correction as law_correction',

            'loans.internal_increase',
            'loans.unexpected_increase',
            'loans.additional_increase',
            'loans.total_increase',
            'loans.decrease',
            'loans.editorial',
            'cd.value_mandate',
            'cd.amount',

            // 'mp.pay_mission',
            // 'mp.name_mission_type'

        ])
            ->join('sub_account_keys as sak', 'sak.id', '=', 'data_mandates.sub_account_key')
            ->join('account_keys as ak', 'ak.id', '=', 'sak.account_key')
            ->join('keys', 'keys.code', '=', 'ak.code')
            ->leftJoin('mandates', 'mandates.report_key', '=', 'data_mandates.id');
            // ->leftJoin('loans', 'loans.report_key', '=', 'data_mandates.id');
        // ->leftJoin('mission_plannings as mp','mp.report_key', '=' , 'reports.id');
    }
}
