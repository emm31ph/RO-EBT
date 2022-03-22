<?php

use Illuminate\Database\Seeder;

class SignatorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('signatories')->insert([
       'type' => '00001',
       'signatory1' => 'Admin',
       'signatory2' => 'Admin 2',
   ]);
    }
}
