<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Category;
use App\Models\Division;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleAdmin = Role::create([
            'id' => 1,
            'name' => 'Administrator',
        ]);
        $roleStaff = Role::create([
            'id' => 2,
            'name' => 'Staff',
        ]);

        $divisionPimpinan = Division::create([
            'id' => 1,
            'name' => 'Pimpinan',
            'description' => 'Digunakan untuk pimpinan perusahaan',
        ]);

        $categoryFulltime = Category::create([
            'id' => 1,
            'name' => 'Fulltime',
            'description' => 'Karyawan tetap',
        ]);

        User::create([
            'name' => 'Administrator',
            'email' => 'johan@schooltech.biz.id',
            'password' => bcrypt('Sendyjoan43v3r!'),
            'role_id' => $roleAdmin->id,
            'division_id' => $divisionPimpinan->id,
            'category_id' => $categoryFulltime->id,
        ]);
    }
}
