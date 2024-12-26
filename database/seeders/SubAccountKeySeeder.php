<?php

namespace Database\Seeders;

use App\Models\Code\SubAccountKey;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubAccountKeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        |-------------------------------------------------------------------------------
        | Clear existing data
        |-------------------------------------------------------------------------------
        */
        DB::table('sub_account_keys')->truncate();

        $subAccountKeys = [

             /*
            |-------------------------------------------------------------------------------
            | Index of CodeKey 21
            |-------------------------------------------------------------------------------
            */
            ['account_key' => '2103', 'sub_account_key' => '21031', 'name_sub_account_key' => 'សំណង់អគារ'],

            /*
            |-------------------------------------------------------------------------------
            | Index of CodeKey 60
            |-------------------------------------------------------------------------------
            */
            ['account_key' => '6001', 'sub_account_key' => '60011', 'name_sub_account_key' => 'សម្ភារផ្គត់ផ្គង់សម្អាត​ និងអនាម័យ'],
            ['account_key' => '6001', 'sub_account_key' => '60012', 'name_sub_account_key' => 'សម្ភារផ្គត់ផ្គង់សម្រាប់​ថែទាំអគារ ប្រាសាទ និងសំណង់ផ្សេងៗ'],
            ['account_key' => '6001', 'sub_account_key' => '60013', 'name_sub_account_key' => 'សម្ភារផ្គត់ផ្គង់សម្រាប់​ថែទាំផ្លូវថ្នល់ ស្ពាន និងលូ'],
            ['account_key' => '6001', 'sub_account_key' => '60014', 'name_sub_account_key' => 'សម្ភារផ្គត់ផ្គង់សម្រាប់​ថែទាំសម្ភារឧបករណ៍'],
            ['account_key' => '6001', 'sub_account_key' => '60015', 'name_sub_account_key' => 'ប្រេងឥន្ធនៈ និងប្រេងរំអិល'],
            ['account_key' => '6002', 'sub_account_key' => '60021', 'name_sub_account_key' => 'សម្ភារការិយាល័យ'],
            ['account_key' => '6002', 'sub_account_key' => '60022', 'name_sub_account_key' => 'សៀវភៅមើល និងឯកសារ'],
            ['account_key' => '6002', 'sub_account_key' => '60023', 'name_sub_account_key' => 'ការបោះពុម្ព'],
            ['account_key' => '6002', 'sub_account_key' => '60028', 'name_sub_account_key' => 'សម្ភារផ្គត់ផ្គង់ផ្នែករដ្ឋបាលផ្សេងៗ'],
            ['account_key' => '6003', 'sub_account_key' => '60031', 'name_sub_account_key' => 'ស្បៀង'],
            ['account_key' => '6003', 'sub_account_key' => '60037', 'name_sub_account_key' => 'ស្បៀងសម្រាប់​រដ្ឋបាល'],
            ['account_key' => '6004', 'sub_account_key' => '60041', 'name_sub_account_key' => 'ឯកសណ្ឋាន'],
            ['account_key' => '6005', 'sub_account_key' => '60051', 'name_sub_account_key' => 'សម្ភារនិងបរិក្ខារបច្ចេកទេសមិនមែនព័ត៌មានវិទ្យា'],
            ['account_key' => '6005', 'sub_account_key' => '60052', 'name_sub_account_key' => 'សង្ហារឹម'],
            ['account_key' => '6005', 'sub_account_key' => '60053', 'name_sub_account_key' => 'សម្ភារប្រើប្រាស់'],
            ['account_key' => '6005', 'sub_account_key' => '60054', 'name_sub_account_key' => 'សម្ភារ និងឧបករណ៍ដឹកជញ្ជូន'],
            ['account_key' => '6005', 'sub_account_key' => '60055', 'name_sub_account_key' => 'សម្ភារនិងបរិក្ខារបច្ចេកទេសព័ត៌មានវិទ្យា'],
            ['account_key' => '6006', 'sub_account_key' => '60061', 'name_sub_account_key' => 'អគ្គិសនី'],
            ['account_key' => '6006', 'sub_account_key' => '60062', 'name_sub_account_key' => 'ទឹក'],
            ['account_key' => '6006', 'sub_account_key' => '60068', 'name_sub_account_key' => 'ផ្សេងៗ'],
            ['account_key' => '6007', 'sub_account_key' => '60072', 'name_sub_account_key' => 'សម្ភារបរិក្ខារពេទ្យ'],

            /*
            |-------------------------------------------------------------------------------
            | Index of CodeKey 61
            |-------------------------------------------------------------------------------
            */
            ['account_key' => '6101', 'sub_account_key' => '61011', 'name_sub_account_key' => 'សេវាអនាម័យ'],
            ['account_key' => '6101', 'sub_account_key' => '61012', 'name_sub_account_key' => 'សេវារដ្ឋបាល'],
            ['account_key' => '6102', 'sub_account_key' => '61021', 'name_sub_account_key' => 'ការជួលមធ្យោបាយដឹកជញ្ជូន'],
            ['account_key' => '6103', 'sub_account_key' => '61031', 'name_sub_account_key' => 'ថ្លៃឈ្នួល និងបន្ទុក(អសង្ហារឹម) ក្នុងប្រទេស'],
            ['account_key' => '6104', 'sub_account_key' => '61041', 'name_sub_account_key' => 'សោហ៊ុយបណ្តុះបណ្តាលក្នុងនិងក្រៅប្រទេស'],
            ['account_key' => '6105', 'sub_account_key' => '61051', 'name_sub_account_key' => 'ការថែទាំដីធ្លី សួនច្បារ ព្រៃឈើ តំបន់ឆ្នេរ និងដែននេសាទ'],
            ['account_key' => '6105', 'sub_account_key' => '61052', 'name_sub_account_key' => 'ការថែទាំ  ជួសជុលអគារផ្សេងៗ និងប្រាសាទ'],
            ['account_key' => '6105', 'sub_account_key' => '61053', 'name_sub_account_key' => 'ការថែទាំ ជួសជុលផ្លូវ ផ្លូវលំ ស្ពាន ​និងលូ'],
            ['account_key' => '6105', 'sub_account_key' => '61054', 'name_sub_account_key' => 'ការថែទាំបណ្តាញផ្សេងៗ'],
            ['account_key' => '6105', 'sub_account_key' => '61056', 'name_sub_account_key' => 'ការថែទាំ និងជួសជុលមធ្យោបាយដឹកជញ្ជូន'],
            ['account_key' => '6105', 'sub_account_key' => '61057', 'name_sub_account_key' => 'ការថែទាំនិងជួសជុលសម្ភារ និងឧបករណ៍បច្ចេកទេស'],
            ['account_key' => '6105', 'sub_account_key' => '61058', 'name_sub_account_key' => 'ការថែទាំនិងជួសជុលផ្សេងៗ'],
            ['account_key' => '6107', 'sub_account_key' => '61071', 'name_sub_account_key' => 'សោហ៊ុយសិក្សាពិសោធន៍'],
            ['account_key' => '6107', 'sub_account_key' => '61072', 'name_sub_account_key' => 'សោហ៊ុយនៃការប្រើប្រាស់សេវា'],
            ['account_key' => '6107', 'sub_account_key' => '61073', 'name_sub_account_key' => 'សោហ៊ុយនៃការប្រើប្រាស់សិទ្ធិ'],
            ['account_key' => '6108', 'sub_account_key' => '61081', 'name_sub_account_key' => 'សម្ភារ និងទំនិញ'],
            ['account_key' => '6110', 'sub_account_key' => '61101', 'name_sub_account_key' => 'សោហ៊ុយទទួលភ្ញៀវជាតិ'],
            ['account_key' => '6110', 'sub_account_key' => '61102', 'name_sub_account_key' => 'សោហ៊ុយទទួលភ្ញៀវបរទេស'],
            ['account_key' => '6110', 'sub_account_key' => '61103', 'name_sub_account_key' => 'ប្រជុំ សិក្ខាសាលា និងសន្និសីទ'],
            ['account_key' => '6110', 'sub_account_key' => '61104', 'name_sub_account_key' => 'ចំណាយរៀបចំពិធីបុណ្យ'],
            ['account_key' => '6110', 'sub_account_key' => '61105', 'name_sub_account_key' => 'ចំណាយសម្រាប់វត្ថុអនុស្សាវរីយ៍ នៅក្នុងនិងក្រៅប្រទេស'],
            ['account_key' => '6110', 'sub_account_key' => '61106', 'name_sub_account_key' => 'ចំណាយសម្រាប់ការតាំងពិពណ៌ នៅក្នុងនិងក្រៅប្រទេស'],
            ['account_key' => '6110', 'sub_account_key' => '61107', 'name_sub_account_key' => 'ការឃោសនានិងផ្សព្វផ្សាយព័ត៌មានសាធារណៈ'],
            ['account_key' => '6110', 'sub_account_key' => '61108', 'name_sub_account_key' => 'ទំនាក់ទំនងសាធារណៈនឹងផ្សព្វផ្សាយផ្សេងៗ'],
            ['account_key' => '6111', 'sub_account_key' => '61111', 'name_sub_account_key' => 'ចំណាយលើការជាវសារព័ត៌មាន'],
            ['account_key' => '6111', 'sub_account_key' => '61112', 'name_sub_account_key' => 'ចំណាយលើការជាវទស្សនាវដ្ដី'],
            ['account_key' => '6111', 'sub_account_key' => '61118', 'name_sub_account_key' => 'ចំណាយលើការជាវសារព័ត៍មាន​ និងឯកសារផ្សេងៗ'],
            ['account_key' => '6112', 'sub_account_key' => '61121', 'name_sub_account_key' => 'សោហ៊ុយដឹកជញ្ជូន'],
            ['account_key' => '6112', 'sub_account_key' => '61122', 'name_sub_account_key' => 'សោហ៊ុយបេសកកម្ម'],
            ['account_key' => '6112', 'sub_account_key' => '61123', 'name_sub_account_key' => 'សោហ៊ុយស្នាក់នៅ'],
            ['account_key' => '6113', 'sub_account_key' => '61131', 'name_sub_account_key' => 'សោហ៊ុយដឹកជញ្ជូន'],
            ['account_key' => '6113', 'sub_account_key' => '61132', 'name_sub_account_key' => 'សោហ៊ុយបេសកកម្ម'],
            ['account_key' => '6113', 'sub_account_key' => '61133', 'name_sub_account_key' => 'សោហ៊ុយស្នាក់នៅ'],
            ['account_key' => '6114', 'sub_account_key' => '61141', 'name_sub_account_key' => 'សោហ៊ុយប្រៃសណីយ៍'],
            ['account_key' => '6114', 'sub_account_key' => '61142', 'name_sub_account_key' => 'សោហ៊ុយទូរគមនាគមន៍'],
            ['account_key' => '6198', 'sub_account_key' => '61981', 'name_sub_account_key' => 'សេវាកម្មផ្សេងៗទៀត'],

            /*
            |-------------------------------------------------------------------------------
            | Index of CodeKey 62
            |-------------------------------------------------------------------------------
            */
            ['account_key' => '6202', 'sub_account_key' => '62025', 'name_sub_account_key' => 'អាហារូបករណ៍សម្រាប់​ការសិក្សា-ស្រាវជ្រាវ'],
            ['account_key' => '6202', 'sub_account_key' => '62028', 'name_sub_account_key' => 'សេវាកម្មស្រាវជ្រាវ'],
            ['account_key' => '6203', 'sub_account_key' => '62031', 'name_sub_account_key' => 'ឧបត្ថម្ភសហគមន៍ និងរក្សាសណ្តាប់ធ្នាប់ សន្តិសុខសង្គម'],
            ['account_key' => '6203', 'sub_account_key' => '62033', 'name_sub_account_key' => 'ឧបត្ថម្ភដំណើរលំហែ និងសិក្សា'],
            ['account_key' => '6203', 'sub_account_key' => '62036', 'name_sub_account_key' => 'ឧបត្ថម្ភមណ្ឌលស្តារលទ្ធភាពពលកម្ម នីតិសម្បទា និងបណ្តុះបណ្តាលអភិវឌ្ឍន៍'],
            ['account_key' => '6203', 'sub_account_key' => '62038', 'name_sub_account_key' => 'ឧបត្ថម្ភដល់អង្គភាពផ្សេងៗទៀត'],
            ['account_key' => '6206', 'sub_account_key' => '62061', 'name_sub_account_key' => 'សេវាកម្មវិទ្យាសាស្ត្រផ្សេងៗ'],

            /*
            |-------------------------------------------------------------------------------
            | Index of CodeKey 63
            |-------------------------------------------------------------------------------
            */
            ['account_key' => '6301', 'sub_account_key' => '63011', 'name_sub_account_key' => 'លតាប័ត្រ'],

            /*
            |-------------------------------------------------------------------------------
            | Index of CodeKey 64
            |-------------------------------------------------------------------------------
            */
            ['account_key' => '6401', 'sub_account_key' => '64014', 'name_sub_account_key' => 'ប្រាក់បំណាច់ រដ្ឋមន្ត្រី រដ្ឋលេខាធិការ  និងអនុរដ្ឋលេខាធិការ'],
            ['account_key' => '6401', 'sub_account_key' => '64016', 'name_sub_account_key' => 'លាភការទីប្រឹក្សា'],
            ['account_key' => '6401', 'sub_account_key' => '64018', 'name_sub_account_key' => 'លាភការអ្នកជំនួយការ'],
            ['account_key' => '6402', 'sub_account_key' => '64021', 'name_sub_account_key' => 'បៀវត្សមូលដ្ឋាន'],
            ['account_key' => '6402', 'sub_account_key' => '64022', 'name_sub_account_key' => 'ប្រាក់បំណាច់មុខងារ'],
            ['account_key' => '6402', 'sub_account_key' => '64023', 'name_sub_account_key' => 'ប្រាក់បំណាច់ម៉ោងបន្ថែម'],
            ['account_key' => '6403', 'sub_account_key' => '64033', 'name_sub_account_key' => 'រង្វាន់'],
            ['account_key' => '6403', 'sub_account_key' => '64038', 'name_sub_account_key' => 'ប្រាក់បំណាច់ផ្សេងៗ'],
            ['account_key' => '6404', 'sub_account_key' => '64041', 'name_sub_account_key' => 'បៀវត្សមូលដ្ឋាន បុគ្គលិកជាប់កិច្ចសន្យា'],
            ['account_key' => '6405', 'sub_account_key' => '64052', 'name_sub_account_key' => 'អ្នកសម្រាលកូន'],
            ['account_key' => '6405', 'sub_account_key' => '64053', 'name_sub_account_key' => 'មរណៈភាព'],
            ['account_key' => '6405', 'sub_account_key' => '64054', 'name_sub_account_key' => 'ឧបត្ថម្ភនិវត្តជន'],
            ['account_key' => '6405', 'sub_account_key' => '64055', 'name_sub_account_key' => 'ឧបត្ថម្ភដល់អ្នកសុំឈប់ពីការងារ'],
            ['account_key' => '6405', 'sub_account_key' => '64056', 'name_sub_account_key' => 'គ្រោះថ្នាក់ក្នុងការងារនិងទព្វលភាព'],
            ['account_key' => '6406', 'sub_account_key' => '64061', 'name_sub_account_key' => 'កូនមានអាយុចាប់ពី២០ឆ្នាំចុះ'],
            ['account_key' => '6406', 'sub_account_key' => '64063', 'name_sub_account_key' => 'ប្រាក់បំណាច់អ្នកក្នុងបន្ទុក'],
            ['account_key' => '6406', 'sub_account_key' => '64981', 'name_sub_account_key' => 'បន្ទុកបុគ្គលិកផ្សេងៗទៀត'],

            /*
            |-------------------------------------------------------------------------------
            | Index of CodeKey 65
            |-------------------------------------------------------------------------------
            */
            ['account_key' => '6502', 'sub_account_key' => '65022', 'name_sub_account_key' => 'ឧបត្ថម្ភធនដល់អង្គភាពដែលមានលក្ខណៈសង្គម'],
            ['account_key' => '6502', 'sub_account_key' => '65026', 'name_sub_account_key' => 'ឧបត្ថម្ភធនដល់អង្គភាពដែលមានលក្ខណៈរដ្ឋបាល'],
            ['account_key' => '6502', 'sub_account_key' => '65031', 'name_sub_account_key' => 'ឧបត្ថម្ភធនជាហិរញ្ញវត្ថុដល់គ្រឹះស្ថានសាធារណៈមានលក្ខណៈរដ្ឋបាល'],
            ['account_key' => '6502', 'sub_account_key' => '65068', 'name_sub_account_key' => 'អង្គការ សមាគម សហព័ន្ធអន្តរជាតិផ្សេងៗទៀត'],
        ];


        /*
        |-------------------------------------------------------------------------------
        | Insert the sub account keys into the database
        |-------------------------------------------------------------------------------
        */
        foreach ($subAccountKeys as $record) {
            SubAccountKey::updateOrCreate(
                ['sub_account_key' => $record['sub_account_key']],
                $record
            );
        }
    }
}
