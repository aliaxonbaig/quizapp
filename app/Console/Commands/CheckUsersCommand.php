<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class CheckUsersCommand extends Command
{
    protected $signature = 'check:users';
    protected $description = 'Check users, roles, subscriptions, and quizzes';

    public function handle()
    {
        $this->info('=== USERS ===');
        
        $users = User::with('roles')->get();
        
        foreach ($users as $user) {
            $this->line("ID: {$user->id} | Name: {$user->name} | Email: {$user->email}");
            $this->line("  Admin: " . ($user->is_admin ? 'Yes' : 'No') . " | Active: " . ($user->is_active ? 'Yes' : 'No'));
            
            if ($user->roles->count() > 0) {
                $this->line("  Roles: " . $user->roles->pluck('name')->implode(', '));
            } else {
                $this->warn("  Roles: NONE");
            }
            
            $certs = DB::table('certification_user')
                ->join('certifications', 'certification_user.certification_id', '=', 'certifications.id')
                ->where('certification_user.user_id', $user->id)
                ->pluck('certifications.name');
            
            if ($certs->count() > 0) {
                $this->line("  Subscribed Certifications: " . $certs->implode(', '));
            } else {
                $this->warn("  Subscribed Certifications: NONE - USER CANNOT SEE QUIZZES!");
            }
            
            $quizCount = DB::table('quiz_headers')->where('user_id', $user->id)->count();
            $this->line("  Quiz Headers: {$quizCount}");
            
            $this->newLine();
        }
        
        $this->info('=== QUIZ SUMMARY ===');
        $this->line("Total Quiz Headers: " . DB::table('quiz_headers')->count());
        $this->line("Total Quiz Answers: " . DB::table('quizzes')->count());
        $this->line("Completed Quizzes: " . DB::table('quiz_headers')->where('completed', true)->count());
        $this->line("Total Certification Subscriptions: " . DB::table('certification_user')->count());
    }
}
