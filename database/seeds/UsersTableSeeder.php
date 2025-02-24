<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\User::class)->make([
            'id' => 1,
            'first_name' => 'Clark',
            'middle_name' => '',
            'last_name' => 'Kent',
            'email' => 'sa@journey.test',
            'password' => Hash::make('secret'),
            'role_id' => Config::get('roles')['Super Admin'],
            'organization_id' => null
        ])->save(['unprotected' => true]);

        $organization = \App\Models\Organization\Organization::withoutGlobalScopes()->find(1);
        $facility = $organization->facilities()->withoutGlobalScopes()->first();

        factory(\App\Models\User::class)->make([
            'id' => 2,
            'first_name' => 'Sylvester',
            'middle_name' => 'Silver',
            'last_name' => 'Pine',
            'email' => 'oa@silverpine.test',
            'password' => Hash::make('secret'),
            'role_id' => Config::get('roles')['Organization Admin'],
            'organization_id' => $organization->id
        ])->save(['unprotected' => true]);

        factory(\App\Models\User::class)->make([
            'id' => 3,
            'first_name' => 'Superior',
            'middle_name' => 'Silver',
            'last_name' => 'Pine',
            'email' => 'um@silverpine.test',
            'password' => Hash::make('secret'),
            'role_id' => Config::get('roles')['Upper Management'],
            'organization_id' => $organization->id
        ])->save(['unprotected' => true]);

        factory(\App\Models\User::class)->make([
            'id' => 4,
            'first_name' => 'Sylvia',
            'middle_name' => 'Silver',
            'last_name' => 'Pine',
            'email' => 'fa@silverpine.test',
            'password' => Hash::make('secret'),
            'role_id' => Config::get('roles')['Facility Admin'],
            'organization_id' => $organization->id,
            'facility_id' => $facility->id,
        ])->save(['unprotected' => true]);

        factory(\App\Models\User::class)->make([
            'id' => 5,
            'first_name' => 'Samuel',
            'middle_name' => 'Silver',
            'last_name' => 'Pine',
            'email' => 'mu@silverpine.test',
            'password' => Hash::make('secret'),
            'role_id' => Config::get('roles')['Master User'],
            'organization_id' => $organization->id,
            'facility_id' => $facility->id,
            'color_id' => 1,
        ])->save(['unprotected' => true]);

        factory(\App\Models\User::class)->make([
            'id' => 6,
            'first_name' => 'Samantha',
            'middle_name' => 'Silver',
            'last_name' => 'Pine',
            'email' => 'ad@silverpine.test',
            'password' => Hash::make('secret'),
            'role_id' => Config::get('roles')['Administrator'],
            'organization_id' => $organization->id,
            'facility_id' => $facility->id,
        ])->save(['unprotected' => true]);

        factory(\App\Models\User::class)->make([
            'id' => 8,
            'first_name' => 'Jones',
            'middle_name' => 'Silver',
            'last_name' => 'Pine',
            'email' => 'mu2@silverpine.test',
            'password' => Hash::make('secret'),
            'role_id' => Config::get('roles')['Master User'],
            'organization_id' => $organization->id,
            'facility_id' => $facility->id,
            'color_id' => 3,
        ])->save(['unprotected' => true]);

        $organization = \App\Models\Organization\Organization::withoutGlobalScopes()->find(2);

        factory(\App\Models\User::class)->make([
            'id' => 7,
            'first_name' => 'Gabriel',
            'middle_name' => 'Garcia',
            'last_name' => 'Gold',
            'email' => 'oa@goldenyears.test',
            'password' => Hash::make('secret'),
            'role_id' => Config::get('roles')['Organization Admin'],
            'organization_id' => $organization->id
        ])->save(['unprotected' => true]);
    }
}
