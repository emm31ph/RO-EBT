<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UtruckerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $data = [['id' => '1', 'fulltitle' => ''],
                ['id' => '2', 'fulltitle' => 'AA1-2071'],
                ['id' => '3', 'fulltitle' => 'RJV-279'],
                ['id' => '4', 'fulltitle' => 'RJT-976'],
                ['id' => '5', 'fulltitle' => 'YCA-764'],
                ['id' => '6', 'fulltitle' => 'TSB-928'],
                ['id' => '7', 'fulltitle' => 'RJR-439'],
                ['id' => '8', 'fulltitle' => 'RJY-725'],
                ['id' => '9', 'fulltitle' => 'XCK-354'],
                ['id' => '10', 'fulltitle' => 'WTR-600'],
                ['id' => '11', 'fulltitle' => 'WDA-456'],
                ['id' => '12', 'fulltitle' => 'AAN-4656'],
                ['id' => '13', 'fulltitle' => 'ABA-9344'],
                ['id' => '14', 'fulltitle' => 'LMN-408'],
                ['id' => '15', 'fulltitle' => 'Third Party'],
                ['id' => '16', 'fulltitle' => 'Interbranch'],
                ['id' => '17', 'fulltitle' => 'WRQ-167'],
                ['id' => '18', 'fulltitle' => 'RGS-266'],
                ['id' => '19', 'fulltitle' => 'NDB-3308'],
                ['id' => '20', 'fulltitle' => 'ALA-8860'],
                ['id' => '21', 'fulltitle' => 'ALA-8294'],
                ['id' => '22', 'fulltitle' => 'NDB 3307'],
                ['id' => '23', 'fulltitle' => 'Cancelled'],
                ['id' => '24', 'fulltitle' => 'UUE-954'],
                ['id' => '25', 'fulltitle' => 'NBA-6289'],
                ['id' => '26', 'fulltitle' => 'NBA-6288'],
                ['id' => '27', 'fulltitle' => 'Pick up'],
                ['id' => '28', 'fulltitle' => 'RJV-310'],
                ['id' => '29', 'fulltitle' => 'AAN-3736'],
                ['id' => '30', 'fulltitle' => 'ACM-2089'],
                ['id' => '31', 'fulltitle' => 'CAO-2275'],
                ['id' => '32', 'fulltitle' => 'NBB-6909'],
                ['id' => '33', 'fulltitle' => 'NAZ-4994'],
                ['id' => '34', 'fulltitle' => 'NAZ-4978'],
                ['id' => '35', 'fulltitle' => 'UTE-389'],
                ['id' => '36', 'fulltitle' => 'USX-921'],
                ['id' => '37', 'fulltitle' => 'RAA-602'],
                ['id' => '38', 'fulltitle' => 'XCT-175'],
                ['id' => '39', 'fulltitle' => 'RCJ-471'],
                ['id' => '40', 'fulltitle' => 'ALA-9234'],
            ];
       DB::table('utrucker')->insert($data);
    }
}
