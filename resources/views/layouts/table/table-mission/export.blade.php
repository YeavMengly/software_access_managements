<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        /* Add your styles here */
        .table-border {
            border-collapse: collapse;
            width: 100%;
        }

        .table-border th, .table-border td {
            border: 1px solid black;
            text-align: center;
            padding: 5px;
        }

        .first-header h4, .second-header h4, .third-header h4 {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="first-header">
        <h4>ព្រះរាជាណាចក្រកម្ពុជា</h4>
        <h3>ជាតិ​ សាសនា ព្រះមហាក្សត្រ</h3>
    </div>
    <div class="second-header">
        <h4>ក្រសួងការងារ និងបណ្តុះបណ្តាលវិជ្ជាជីវៈ</h4>
        <h4>អគ្គនាយកដ្ឋានរដ្ឋបាល និងហិរញ្ញវត្ថុ</h4>
        <h4>នាយកដ្ឋានហិរញ្ញវត្ថុ និងទ្រព្យសម្បត្តិរដ្ឋ</h4>
        <h4>ការិយាល័យហិរញ្ញវត្ថុ</h4>
    </div>
    <div class="third-header">
        <h4>តារាងរបាយការណ៍ចំណាយបេសកកម្មក្នុងប្រទេសឆ្នាំ ២០២៤</h4>
        <h4>របស់អគ្គនាយករដ្ឋបាល និងហិរញ្ញវត្ថុ</h4>
    </div>
    <table class="table-border">
        <thead>
            <tr>
                <th>ល.រ</th>
                <th>គោត្តនាម​​ និងនាម</th>
                <th>តួនាទី</th>
                <th>ប្រភេទមុខតំណែង</th>
                <th>លេខលិខិតបញ្ជាបេសកកម្ម</th>
                <th>កាលបរិច្ឆេទលិខិតបញ្ជាបេសកកម្ម</th>
                <th>កម្មវត្ថុនៃការចុះបេសកកម្ម</th>
                <th>ទីកន្លែង</th>
                <th>កាលបរិច្ឆេទចុះបេសកកម្មចាប់ផ្ដើម</th>
                <th>កាលបរិច្ឆេទចុះបេសកកម្មត្រឡប់</th>
                <th>ចំនួនថ្ងៃ</th>
                <th>ចំនួនយប់</th>
                <th>សោហ៊ុយធ្វើដំណើរ</th>
                <th>ប្រាក់ហោប៉ៅរបប</th>
                <th>ប្រាក់ហោប៉ៅសរុប</th>
                <th>ប្រាក់ហូបចុករបប</th>
                <th>ប្រាក់ហូបចុកសរុប</th>
                <th>ប្រាក់ស្នាក់នៅរបប</th>
                <th>ប្រាក់ស្នាក់នៅសរុប</th>
                <th>សោហ៊ុយផ្សេងៗ</th>
                <th>ទឹកប្រាក់សរុប</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($missions as $index => $mission)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $mission->name }}</td>
                    <td>{{ $mission->role }}</td>
                    <td>{{ $mission->position_type }}</td>
                    <td>{{ $mission->letter_number }}</td>
                    <td>{{ $mission->letter_date }}</td>
                    <td>{{ $mission->mission_objective }}</td>
                    <td>{{ $mission->location }}</td>
                    <td>{{ $mission->mission_start_date }}</td>
                    <td>{{ $mission->mission_end_date }}</td>
                    <td>{{ $mission->days_count }}</td>
                    <td>{{ $mission->nights_count }}</td>
                    <td>{{ number_format($mission->travel_allowance, 0, '.', ',') }}</td>
                    <td>{{ number_format($mission->pocket_money, 0, '.', ',') }}</td>
                    <td>{{ number_format($mission->total_pocket_money, 0, '.', ',') }}</td>
                    <td>{{ number_format($mission->meal_money, 0, '.', ',') }}</td>
                    <td>{{ number_format($mission->total_meal_money, 0, '.', ',') }}</td>
                    <td>{{ number_format($mission->accommodation_money, 0, '.', ',') }}</td>
                    <td>{{ number_format($mission->total_accommodation_money, 0, '.', ',') }}</td>
                    <td>{{ number_format($mission->other_allowances, 0, '.', ',') }}</td>
                    <td>{{ number_format($mission->final_total, 0, '.', ',') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
