<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => "admin"]);
        DB::table('roles')->insert([
            'name' => "coordinateur"]);
        DB::table('roles')->insert([
            'name' => "major"]);
        DB::table('roles')->insert([
            'name' => "demandeur"]);
        DB::table('roles')->insert([
            'name' => "brancardier"]);
        DB::table('roles')->insert([
            'name' => "not_active"]);
    }
}
