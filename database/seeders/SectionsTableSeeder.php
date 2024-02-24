<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SectionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sections')->delete();
        
        \DB::table('sections')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Information Technology',
                'description' => 'Information Technology Section that covers all IT related certifications',
                'is_active' => 1,
                'details' => 'Information Technology Section that covers all IT related certifications',
                'user_id' => 1,
                'created_at' => '2023-06-04 06:30:25',
                'updated_at' => '2023-06-04 06:30:25',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Geography Section',
                'description' => 'Geography Section is all about certifications for Geography ',
                'is_active' => 1,
                'details' => 'Geography Section is all about certifications for Geography ',
                'user_id' => 1,
                'created_at' => '2023-06-04 06:31:01',
                'updated_at' => '2023-06-04 06:31:01',
            ),
        ));
        
        
    }
}