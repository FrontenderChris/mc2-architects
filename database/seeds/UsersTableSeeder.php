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
        \App\Models\User::truncate(true);

        App\Models\User::create([
            'name' => 'Administrator',
            'email' => 'admin@brownpaperbag.co.nz',
            'password' => Hash::make('bpbdev005'),
        ]);

        // Make sure all users have a role_id
        if (hasLoginPackage()) {
            $result = \DB::select('SELECT id FROM roles WHERE slug = "administrator";');
            if (!empty($result[0]) && !empty($result[0]->id)) {
                DB::table('users')->update(['role_id' => $result[0]->id]);
            }
        }
    }
}
