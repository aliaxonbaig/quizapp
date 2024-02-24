<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
class ShieldSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["view_answer","view_any_answer","create_answer","update_answer","delete_answer","delete_any_answer","force_delete_answer","force_delete_any_answer","view_certification","view_any_certification","create_certification","update_certification","delete_certification","delete_any_certification","force_delete_certification","force_delete_any_certification","view_domain","view_any_domain","create_domain","update_domain","delete_domain","delete_any_domain","force_delete_domain","force_delete_any_domain","view_my::quizzes","view_any_my::quizzes","create_my::quizzes","update_my::quizzes","delete_my::quizzes","delete_any_my::quizzes","force_delete_my::quizzes","force_delete_any_my::quizzes","view_question","view_any_question","create_question","update_question","delete_question","delete_any_question","force_delete_question","force_delete_any_question","view_quiz","view_any_quiz","create_quiz","update_quiz","delete_quiz","delete_any_quiz","force_delete_quiz","force_delete_any_quiz","view_quiz::header","view_any_quiz::header","create_quiz::header","update_quiz::header","delete_quiz::header","delete_any_quiz::header","force_delete_quiz::header","force_delete_any_quiz::header","view_quote","view_any_quote","create_quote","update_quote","delete_quote","delete_any_quote","force_delete_quote","force_delete_any_quote","view_role","view_any_role","create_role","update_role","delete_role","delete_any_role","view_section","view_any_section","create_section","update_section","delete_section","delete_any_section","force_delete_section","force_delete_any_section","view_subscriptions","view_any_subscriptions","create_subscriptions","update_subscriptions","delete_subscriptions","delete_any_subscriptions","force_delete_subscriptions","force_delete_any_subscriptions","view_user","view_any_user","create_user","update_user","delete_user","delete_any_user","force_delete_user","force_delete_any_user","page_MyProfilePage","page_Quiz","page_QuizDetailPage","widget_RandomQuoteWidget","widget_StatsOverview","widget_CommulativeAdminStatsWidget","widget_ComulativeAdminQuizQuestionsStatsWidget","widget_UserQuizChart","widget_QuizHeadersChart"]},{"name":"user","guard_name":"web","permissions":["view_my::quizzes","view_any_my::quizzes","delete_my::quizzes","view_subscriptions","view_any_subscriptions","page_MyProfilePage","page_Quiz","page_QuizDetailPage","widget_RandomQuoteWidget","widget_StatsOverview","widget_UserQuizChart","widget_QuizHeadersChart"]}]';
        $directPermissions = '[]';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions,true))) {

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = Utils::getRoleModel()::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name']
                ]);

                if (! blank($rolePlusPermission['permissions'])) {

                    $permissionModels = collect();

                    collect($rolePlusPermission['permissions'])
                        ->each(function ($permission) use($permissionModels) {
                            $permissionModels->push(Utils::getPermissionModel()::firstOrCreate([
                                'name' => $permission,
                                'guard_name' => 'web'
                            ]));
                        });
                    $role->syncPermissions($permissionModels);

                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions,true))) {

            foreach($permissions as $permission) {

                if (Utils::getPermissionModel()::whereName($permission)->doesntExist()) {
                    Utils::getPermissionModel()::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
