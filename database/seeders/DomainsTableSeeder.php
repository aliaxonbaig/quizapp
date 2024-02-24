<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DomainsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('domains')->delete();
        
        \DB::table('domains')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Information and Risk Management',
                'description' => 'Information and Risk Management',
                'is_active' => 1,
                'details' => 'Information and Risk Management',
                'user_id' => 1,
                'certification_id' => 1,
                'created_at' => '2023-06-04 06:32:43',
                'updated_at' => '2023-06-04 06:32:43',
            ),
        ));
        
        
    }
}