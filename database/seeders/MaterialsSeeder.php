<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teacher = \App\Models\User::where('email', 'admin@admin.com')->first();

        if (!$teacher) {
            $this->command->error('Teacher user (admin@admin.com) not found!');
            return;
        }

        $materials = [
            [
                'title' => 'Week 1 - Introduction to Network Security',
                'description' => 'Comprehensive slides covering basic network security concepts, threats, and defense mechanisms.',
                'files' => [], // In real scenario, these would be actual file paths
                'user_id' => $teacher->id,
                'created_at' => now()->subDays(15),
            ],
            [
                'title' => 'CISSP Study Guide - Domain 1',
                'description' => 'Security and Risk Management domain study materials, practice questions, and reference notes.',
                'files' => [],
                'user_id' => $teacher->id,
                'created_at' => now()->subDays(10),
            ],
            [
                'title' => 'CCNA Practice Labs - Routing & Switching',
                'description' => 'Lab exercises and configuration examples for Cisco routing and switching. Includes packet tracer files.',
                'files' => [],
                'user_id' => $teacher->id,
                'created_at' => now()->subDays(7),
            ],
            [
                'title' => 'Midterm Exam Review Materials',
                'description' => 'Review slides, practice questions, and answer keys for the upcoming midterm examination.',
                'files' => [],
                'user_id' => $teacher->id,
                'created_at' => now()->subDays(3),
            ],
            [
                'title' => 'Cybersecurity Best Practices Handbook',
                'description' => 'Industry-standard best practices for cybersecurity professionals. Essential reading for all students.',
                'files' => [],
                'user_id' => $teacher->id,
                'created_at' => now()->subDays(1),
            ],
        ];

        foreach ($materials as $material) {
            \App\Models\Material::create($material);
        }

        $this->command->info('✅ Sample materials created successfully!');
        $this->command->info('💡 To upload actual files, log in as a teacher and use the Filament admin panel.');
    }
}
