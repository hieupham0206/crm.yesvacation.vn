<?php

use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $inputFileName = database_path('files/Provinces.xlsx');

        /** Load $inputFileName to a Spreadsheet Object  **/
        try {
            $inputFileType = 'Xlsx';
            $provinces     = [];

            /**  Create a new Reader of the type defined in $inputFileType  **/
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
            /**  Advise the Reader of which WorkSheets we want to load  **/
            $reader->setReadDataOnly(true);
            /**  Load $inputFileName to a Spreadsheet Object  **/
            $spreadsheet = $reader->load($inputFileName);

            $datas = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            foreach ($datas as $key => $data) {
                $provinces[] = [
                    'name' => $data['B'],
                ];
            }

            \App\Models\Province::insert($provinces);

        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            var_dump($e);
        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
            var_dump($e);
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
}
