<?php

namespace App\Models\Code;

use App\Models\Certificates\Certificate;
use App\Models\Certificates\CertificateData;
use App\Models\DataMandate;
use App\Models\LoanMandate;
use App\Models\Mandates\Mandate;
use App\Models\Mission\MissionPlanning;
use App\Models\Totals\Total;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'reports';
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


    // belong table to subAccount class
    public function subAccountKey()
    {
        return $this->belongsTo(SubAccountKey::class, 'sub_account_key', 'sub_account_key'); // Adjust this if needed
    }


    // Point to total class
    public function total()
    {
        return $this->hasMany(Total::class, 'fin_law');
    }

    // Point to certificateData Class
    public function certificateData()
    {
        return $this->hasOne(CertificateData::class, 'report_key', 'report_key');
    }

    public function certificate()
    {
        return $this->hasOne(Certificate::class, 'early_balance');
    }

    public function mandate()
    {
        return $this->hasOne(Mandate::class, 'report_key', 'report_key');
    }


    public function loans()
    {
        return $this->hasOne(Loans::class, 'report_key', 'report_key');
    }

    public function year()
    {
        return $this->belongsTo(Year::class, 'date_year', 'id'); // Correctly reference year_id
    }

    public function scopeFilterByMonthYear($query, $month, $year)
    {
        return $query->whereMonth('created_at', $month)->whereYear('created_at', $year);
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
            'reports.report_key as report_key',
            'reports.fin_law as fin_law',
            'reports.current_loan as current_loan',

            'reports.new_credit_status as new_credit_status',
            'reports.early_balance as early_balance',
            'reports.apply as apply',
            'reports.deadline_balance as deadline_balance',
            'reports.credit as credit',
            'reports.law_average as law_average',
            'reports.law_correction as law_correction',

            'loans.internal_increase',
            'loans.unexpected_increase',
            'loans.additional_increase',
            'loans.total_increase',
            'loans.decrease',
            'loans.editorial',
            'cd.value_certificate',
            'cd.amount',

            // 'mp.pay_mission',
            // 'mp.name_mission_type'

        ])
            ->join('sub_account_keys as sak', 'sak.id', '=', 'reports.sub_account_key')
            ->join('account_keys as ak', 'ak.id', '=', 'sak.account_key')
            ->join('keys', 'keys.code', '=', 'ak.code')
            ->leftJoin('certificate_data as cd', 'cd.report_key', '=', 'reports.id')
            ->leftJoin('loans', 'loans.report_key', '=', 'reports.id');
        // ->leftJoin('mission_plannings as mp','mp.report_key', '=' , 'reports.id');
    }

    public function delete()
    {
        if ($this->loans()->exists()) {
            $this->loans()->delete();
        }

        if ($this->certificateData()->exists()) {
            $this->certificateData()->delete();
        }
        return parent::delete();
    }

    public function scopeFilterReports($query, $year, $month = null)
    {
        $query->whereYear('date_year', $year);

        if ($month) {
            $query->whereMonth('created_at', $month);
        }
    }

    public function missionPlanning()
    {
        return $this->hasMany(MissionPlanning::class, 'report_key');
    }

    public function loanMandate()
    {
        return $this->hasMany(LoanMandate::class, 'report_key');
    }

    public function dataMandate()
    {
        return $this->hasMany(DataMandate::class, 'report_key', 'report_key');
    }
}
