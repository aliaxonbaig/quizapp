<?php

use Illuminate\Support\Facades\DB;

echo "\n=== USERS ===\n";
$users = DB::table('users')->select('id', 'name', 'email', 'is_admin', 'is_active')->get();
foreach ($users as $user) {
    echo "ID: {$user->id} | Name: {$user->name} | Email: {$user->email} | Admin: " . ($user->is_admin ? 'Yes' : 'No') . " | Active: " . ($user->is_active ? 'Yes' : 'No') . "\n";
    
    // Get roles
    $roles = DB::table('model_has_roles')
        ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->where('model_has_roles.model_id', $user->id)
        ->where('model_has_roles.model_type', 'App\\Models\\User')
        ->pluck('roles.name');
    
    if ($roles->count() > 0) {
        echo "  Roles: " . $roles->implode(', ') . "\n";
    } else {
        echo "  Roles: NONE\n";
    }
    
    // Get certifications
    $certs = DB::table('certification_user')
        ->join('certifications', 'certification_user.certification_id', '=', 'certifications.id')
        ->where('certification_user.user_id', $user->id)
        ->pluck('certifications.name');
    
    if ($certs->count() > 0) {
        echo "  Subscribed Certifications: " . $certs->implode(', ') . "\n";
    } else {
        echo "  Subscribed Certifications: NONE\n";
    }
    
    // Get quiz count
    $quizCount = DB::table('quiz_headers')->where('user_id', $user->id)->count();
    echo "  Quiz Headers: {$quizCount}\n";
    
    echo "\n";
}

echo "\n=== QUIZ SUMMARY ===\n";
echo "Total Quiz Headers: " . DB::table('quiz_headers')->count() . "\n";
echo "Total Quiz Answers: " . DB::table('quizzes')->count() . "\n";
echo "Completed Quizzes: " . DB::table('quiz_headers')->where('completed', true)->count() . "\n";
echo "Total Certification Subscriptions: " . DB::table('certification_user')->count() . "\n";
