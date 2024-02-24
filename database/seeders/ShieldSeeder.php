<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["view_answer","view_any_answer","create_answer","update_answer","delete_answer","delete_any_answer","force_delete_answer","force_delete_any_answer","view_certification","view_any_certification","create_certification","update_certification","delete_certification","delete_any_certification","force_delete_certification","force_delete_any_certification","view_domain","view_any_domain","create_domain","update_domain","delete_domain","delete_any_domain","force_delete_domain","force_delete_any_domain","view_my::quizzes","view_any_my::quizzes","create_my::quizzes","update_my::quizzes","delete_my::quizzes","delete_any_my::quizzes","force_delete_my::quizzes","force_delete_any_my::quizzes","view_question","view_any_question","create_question","update_question","delete_question","delete_any_question","force_delete_question","force_delete_any_question","view_quiz","view_any_quiz","create_quiz","update_quiz","delete_quiz","delete_any_quiz","force_delete_quiz","force_delete_any_quiz","view_quiz::header","view_any_quiz::header","create_quiz::header","update_quiz::header","delete_quiz::header","delete_any_quiz::header","force_delete_quiz::header","force_delete_any_quiz::header","view_quote","view_any_quote","create_quote","update_quote","delete_quote","delete_any_quote","force_delete_quote","force_delete_any_quote","view_role","view_any_role","create_role","update_role","delete_role","delete_any_role","view_section","view_any_section","create_section","update_section","delete_section","delete_any_section","force_delete_section","force_delete_any_section","view_subscriptions","view_any_subscriptions","create_subscriptions","update_subscriptions","delete_subscriptions","delete_any_subscriptions","force_delete_subscriptions","force_delete_any_subscriptions","view_user","view_any_user","create_user","update_user","delete_user","delete_any_user","force_delete_user","force_delete_any_user","page_MyProfilePage","page_Quiz","page_QuizDetailPage","widget_RandomQuoteWidget","widget_StatsOverview","widget_UserQuizChart","widget_QuizHeadersChart","widget_CommulativeAdminStatsWidget","widget_ComulativeAdminQuizQuestionsStatsWidget"]},{"name":"user","guard_name":"web","permissions":["view_my::quizzes","view_any_my::quizzes","delete_my::quizzes","view_subscriptions","view_any_subscriptions","page_MyProfilePage","page_Quiz","page_QuizDetailPage","widget_RandomQuoteWidget","widget_StatsOverview","widget_UserQuizChart","widget_QuizHeadersChart"]}]';
        $directPermissions = '{"99":{"name":"widget_AdminStatsWidget","guard_name":"web"},"100":{"name":"widget_AdminQuizQstnStatsWidget","guard_name":"web"}}';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
