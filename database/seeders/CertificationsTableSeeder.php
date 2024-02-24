<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CertificationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('certifications')->delete();
        
        \DB::table('certifications')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'CISSP',
                'description' => 'Certified Information Systems Security Professional CISSP',
                'is_active' => 1,
                'details' => 'Certified Information Systems Security Professional CISSP',
                'user_id' => 1,
                'section_id' => 1,
                'created_at' => '2023-06-04 06:31:39',
                'updated_at' => '2023-06-04 06:31:39',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'CCNA',
                'description' => 'Cisco Certified Network Administrator',
                'is_active' => 1,
                'details' => ' Cisco Certified Network Administrator  Cisco Certified Network Administrator',
                'user_id' => 1,
                'section_id' => 1,
                'created_at' => '2023-06-04 06:32:22',
                'updated_at' => '2023-06-04 06:32:22',
            ),
        ));
        
        
    }
}