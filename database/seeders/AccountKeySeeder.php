<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountKeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        |-------------------------------------------------------------------------------
        |  Clear existing data
        |-------------------------------------------------------------------------------
        */
        DB::table('account_keys')->truncate();

        /*
        |-------------------------------------------------------------------------------
        | Fetch the existing codes from the `keys` table
        |-------------------------------------------------------------------------------
        */
        $codes = DB::table('keys')->pluck('code')->toArray(); // Fetch codes as an array

        /*
        |-------------------------------------------------------------------------------
        | Define the mapping of codes to account keys
        |-------------------------------------------------------------------------------
        */
        $accountKeys = [
            '21' => [
                ['account_key' => '2103', 'name_account_key' => 'សំណង់អគារ និងការកែលម្អ'],
            ],
            '60' => [
                ['account_key' => '6001', 'name_account_key' => 'សម្ភារផ្គត់ផ្គង់ថែទាំ'],
                ['account_key' => '6002', 'name_account_key' => 'សម្ភារផ្គត់ផ្គង់ផ្នែករដ្ឋបាល'],
                ['account_key' => '6003', 'name_account_key' => 'ស្បៀងអាហារ និងផលិតផលកសិកម្ម'],
                ['account_key' => '6004', 'name_account_key' => 'សំលៀកបំពាក់ និងការតុបតែង'],
                ['account_key' => '6005', 'name_account_key' => 'សម្ភារតូចតាច សង្ហារឹម និងសម្ភារបរិក្ខារ'],
                ['account_key' => '6006', 'name_account_key' => 'ថាមពល​ និងទឺក'],
                ['account_key' => '6007', 'name_account_key' => 'សម្ភារបរិក្ខារថែទាំសុខភាព'],
            ],
            '61' => [
                ['account_key' => '6101', 'name_account_key' => 'កិច្ចសន្យានៃការផ្តល់សេវាជាមួយសហគ្រាស'],
                ['account_key' => '6102', 'name_account_key' => 'ការជួលមធ្យោបាយដឹកជញ្ជូន'],
                ['account_key' => '6103', 'name_account_key' => 'ថ្លៃឈ្នួល និងបន្ទុក(អសង្ហារឹម) ក្នុងនិងក្រៅប្រទេស'],
                ['account_key' => '6104', 'name_account_key' => 'សោហ៊ុយបណ្តុះបណ្តាល ក្នុងនិងក្រៅប្រទេស'],
                ['account_key' => '6105', 'name_account_key' => 'ការថែទាំនិងជួសជុល'],
                ['account_key' => '6107', 'name_account_key' => 'សោហ៊ុយសិក្សាពិសោធន៍ សោហ៊ុយនៃការប្រើប្រាស់សេវា សោហ៊ុយនៃការប្រើប្រាស់សិទ្ធិ និងសំណងផ្សេងៗ'],
                ['account_key' => '6108', 'name_account_key' => 'សោហ៊ុយដឹកជញ្ជូន'],
                ['account_key' => '6110', 'name_account_key' => 'ទំនាក់ទំនងសាធារណៈ និងផ្សព្វផ្សាយ'],
                ['account_key' => '6111', 'name_account_key' => 'សារព័ត៌មាន និងឯកសារ'],
                ['account_key' => '6112', 'name_account_key' => 'សោហ៊ុយបេសកកម្មក្នុងប្រទេស'],
                ['account_key' => '6113', 'name_account_key' => 'សោហ៊ុយបេសកកម្មក្រៅប្រទេស'],
                ['account_key' => '6114', 'name_account_key' => 'សោហ៊ុយប្រៃសណីយ៍ និងទូរគមនាគមន៍'],
                ['account_key' => '6198', 'name_account_key' => 'សេវាកម្មផ្សេងៗទៀត'],
            ],
            '62' => [
                ['account_key' => '6202', 'name_account_key' => 'ជំនួយសង្គមដល់ប្រជាពលរដ្ឋ'],
                ['account_key' => '6203', 'name_account_key' => 'ឧបត្ថម្ភដល់អង្គភាពដែលមានលក្ខណៈសង្គម និងវប្បធម៌'],
                ['account_key' => '6206', 'name_account_key' => 'ចំណាយអន្តរាគមន៍ផ្នែក​សង្គមកិច្ចនិងវប្បធម៌'],
            ],
            '63' => [
                ['account_key' => '6301', 'name_account_key' => 'លតាប័ត្រ'],
            ],
            '64' => [
                ['account_key' => '6401', 'name_account_key' => 'លាភការ និងប្រាក់បំណាច់នៃអំណាច សាធារណៈ'],
                ['account_key' => '6402', 'name_account_key' => 'លាភការនិងប្រាក់បំណាច់ បុគ្គលិកក្របខ័ណ្ឌ អចិន្ត្រៃយ៍'],
                ['account_key' => '6403', 'name_account_key' => 'ប្រាក់បំណាច់ផ្សេងៗ'],
                ['account_key' => '6404', 'name_account_key' => 'លាភការ និងប្រាក់បំណាច់បុគ្គលិកមិនមែនក្របខ័ណ្ឌ'],
                ['account_key' => '6405', 'name_account_key' => 'ប្រាក់វិភាជន៍សង្គមសម្រាប់មន្ត្រីរាជការ និងបុគ្គលិកផ្សេងៗ'],
                ['account_key' => '6406', 'name_account_key' => 'ប្រាក់វិភាជន៍សង្គមសម្រាប់គ្រួសារមន្ត្រីរាជការ'],
                ['account_key' => '6498', 'name_account_key' => 'បន្ទុកបុគ្គលិកផ្សេងៗទៀត'],
            ],
            '65' => [
                ['account_key' => '6502', 'name_account_key' => 'ឧបត្ថម្ភធនដល់អង្គការសាធារណៈ'],
                ['account_key' => '6503', 'name_account_key' => 'ឧបត្ថម្ភធនដល់គ្រឹះស្ថានសាធារណៈមាន លក្ខណៈរដ្ឋបាល'],
                ['account_key' => '6506', 'name_account_key' => 'វិភាគទាន​ដល់​អង្គការ​ សមាគម សហព័ន្ធអន្តរជាតិ​នានា'],
            ],
        ];

        /*
        |-------------------------------------------------------------------------------
        | Prepare data for insertion
        |-------------------------------------------------------------------------------
        */
        $dataToInsert = [];
        foreach ($codes as $code) {
            if (isset($accountKeys[$code])) {
                foreach ($accountKeys[$code] as $keyData) {
                    $dataToInsert[] = [
                        'code' => $code,
                        'account_key' => $keyData['account_key'],
                        'name_account_key' => $keyData['name_account_key'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        /*
        |-------------------------------------------------------------------------------
        | Insert data into account_keys table
        |-------------------------------------------------------------------------------
        */
        DB::table('account_keys')->insert($dataToInsert);
    }
}
