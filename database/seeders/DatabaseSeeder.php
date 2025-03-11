<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\City;
use App\Models\Region;
use App\Models\Classe;
use App\Models\Sector;
use App\Models\Department;
use App\Models\Skill;
use App\Models\Status;
use App\Models\Postal_Code;


class DatabaseSeeder extends Seeder
{
    /** 
     * Seed the application's database.
     */
    public function run(): void
    {                
        // Appel des seeder
        $this->call([
            RegionSeeder::class,
            CitySeeder::class,
            //PostalsCodesSeeder::class,
            ClassesSeeder::class,
            SectorSeeder::class,
            DepartmentSeeder::class,
            SkillSeeder::class,
            StatusesSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            CompanySeeder::class,
            CompanySectorSeeder::class,]);
    }
}