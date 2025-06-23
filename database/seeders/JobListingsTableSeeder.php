<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class JobListingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          {
        // \App\Models\User::factory(10)->create();
        // User::create([
        //     'name' => 'John Doe',
        //     'title' => 'Mr',
        //     'phone' => '1234567890',
        //     'id_passport' => 'A12345678',
        //     'kra_pin' => 'KRA123456',
        //     'email' => 'john.doe@example.com',
        //     'password' => Hash::make('password123'), // Hash the password
        // ]);

        // User::create([
        //     'name' => 'Jane Smith',
        //     'title' => 'Mrs',
        //     'phone' => '0987654321',
        //     'id_passport' => 'B87654321',
        //     'kra_pin' => 'KRA654321',
        //     'email' => 'jane.smith@example.com',
        //     'password' => Hash::make('password123'), // Hash the password
        // ]);

     

        
        DB::table('job_listings')->insert([
            [
                    
                'title' => 'Software Engineer',
                'code' => 'SE-001',
                'location' => 'New York, NY',
                'deadline' => Carbon::now()->addDays(30), // 30 days from now
                'description' => 'We are looking for a Software Engineer to join our team.',
                'created_by' => 1, // Assuming user with ID 1 exists
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                    
                'title' => 'Product Manager',
                'code' => 'PM-002',
                'location' => 'San Francisco, CA',
                'deadline' => Carbon::now()->addDays(45), // 45 days from now
                'description' => 'Seeking a Product Manager to lead our product development.',
                'created_by' => 1, // Assuming user with ID 1 exists
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                    
                'title' => 'Data Analyst',
                'code' => 'DA-003',
                'location' => 'Remote',
                'deadline' => Carbon::now()->addDays(60), // 60 days from now
                'description' => 'Looking for a Data Analyst to analyze data and provide insights.',
                'created_by' => 1, // Assuming user with ID 1 exists
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
//
    }

