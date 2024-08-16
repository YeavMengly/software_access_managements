<?php

namespace App\Exports;

use App\Models\Result\CambodiaMission;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CambodiaExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $search;

    public function __construct($search = null)
    {
        $this->search = $search;
    }

    public function query()
    {
        return CambodiaMission::query()
            ->when($this->search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->select(
                        'id',
                        'name',
                        'role',
                        'position_type',
                        'letter_number',
                        'letter_date',
                        'pocket_money',
                        'meal_money',
                        'mission_objective',
                        'location',
                        'mission_start_date',
                        'mission_end_date',
                        'days_count',
                        'nights_count',
                        'pocket_money',
                        'meal_money',
                        'accommodation_money',
                        'total_pocket_money',
                        'total_meal_money',
                        'total_accommodation_money',
                        'travel_allowance',
                        'final_total'
                    );
            });
    }

    public function headings(): array
    {
        if ($this->search) {
            return [
                'ល.រ',
                'គោត្តនាម​​ និងនាម',
                'តួនាទី',
                'ប្រភេទមុខតំណែង',
                'លេខលិខិតបញ្ជាបេសកកម្ម',
                'កាលបរិច្ឆេទលិខិតបញ្ជាបេសកកម្ម',
                'កម្មវត្ថុនៃការចុះបេសកកម្ម',
                'ទីកន្លែង',
                'កាលបរិច្ឆេទចុះបេសកកម្មចាប់ផ្ដើម',
                'កាលបរិច្ឆេទចុះបេសកកម្មត្រឡប់',
                'ចំនួនថ្ងៃ',
                'ចំនួនយប់',
                'សោហ៊ុយធ្វើដំណើរ',
                'ប្រាក់ហោប៉ៅរបប',
                'ប្រាក់ហោប៉ៅសរុប',
                'ប្រាក់ហូបចុករបប',
                'ប្រាក់ហូបចុកសរុប',
                'ប្រាក់ស្នាក់នៅរបប',
                'ប្រាក់ស្នាក់នៅសរុប',
                'សោហ៊ុយផ្សេងៗ',
                'ទឹកប្រាក់សរុប',
            ];
        } else {
            return [
                'ល.រ',
                'គោត្តនាម​​ និងនាម',
                'តួនាទី',
                'ប្រភេទមុខតំណែង',
                'លេខលិខិតបញ្ជាបេសកកម្ម',
                'កាលបរិច្ឆេទលិខិតបញ្ជាបេសកកម្ម',
                'កម្មវត្ថុនៃការចុះបេសកកម្ម',
                'ទីកន្លែង',
                'កាលបរិច្ឆេទចុះបេសកកម្មចាប់ផ្ដើម',
                'កាលបរិច្ឆេទចុះបេសកកម្មត្រឡប់',
                'ចំនួនថ្ងៃ',
                'ចំនួនយប់',
                'សោហ៊ុយធ្វើដំណើរ',
                'ប្រាក់ហោប៉ៅរបប',
                'ប្រាក់ហោប៉ៅសរុប',
                'ប្រាក់ហូបចុករបប',
                'ប្រាក់ហូបចុកសរុប',
                'ប្រាក់ស្នាក់នៅរបប',
                'ប្រាក់ស្នាក់នៅសរុប',
                'សោហ៊ុយផ្សេងៗ',
                'ទឹកប្រាក់សរុប',
            ];
        }
    }

    public function map($mission): array
    {
        if ($this->search) {
            return [
                $mission->id,
                $mission->name,
                $mission->role,
                $mission->position_type,
                $mission->letter_number,
                $mission->letter_date,
                $mission->mission_objective,
                $mission->location,
                $mission->mission_start_date,
                $mission->mission_end_date,
                $mission->days_count,
                $mission->nights_count,
                number_format($mission->travel_allowance, 0, '.', ','),
                number_format($mission->pocket_money, 0, '.', ','),
                number_format($mission->total_pocket_money, 0, '.', ','),
                number_format($mission->meal_money, 0, '.', ','),
                number_format($mission->total_meal_money, 0, '.', ','),
                number_format($mission->accommodation_money, 0, '.', ','),
                number_format($mission->total_accommodation_money, 0, '.', ','),
                number_format($mission->other_allowances, 0, '.', ','),
                number_format($mission->final_total, 0, '.', ','),
            ];
        } else {
            return [
                $mission->id,
                $mission->name,
                $mission->role,
                $mission->position_type,
                $mission->letter_number,
                $mission->letter_date,
                $mission->mission_objective,
                $mission->location,
                $mission->mission_start_date,
                $mission->mission_end_date,
                $mission->days_count,
                $mission->nights_count,
                number_format($mission->travel_allowance, 0, '.', ','),
                number_format($mission->pocket_money, 0, '.', ','),
                number_format($mission->total_pocket_money, 0, '.', ','),
                number_format($mission->meal_money, 0, '.', ','),
                number_format($mission->total_meal_money, 0, '.', ','),
                number_format($mission->accommodation_money, 0, '.', ','),
                number_format($mission->total_accommodation_money, 0, '.', ','),
                number_format($mission->other_allowances, 0, '.', ','),
                number_format($mission->final_total, 0, '.', ','),
            ];
        }

        
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return 'Cambodia Export';
    }
}
