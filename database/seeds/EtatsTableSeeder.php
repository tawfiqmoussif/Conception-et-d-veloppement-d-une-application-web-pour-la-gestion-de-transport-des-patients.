<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EtatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('etats')->insert([
            'libelle' => "En attente"]);
        DB::table('etats')->insert([
            'libelle' => "En traitement"]);
        DB::table('etats')->insert([
            'libelle' => "Problème"]);
        DB::table('etats')->insert([
            'libelle' => "Terminée Avec réserve"]);
        DB::table('etats')->insert([
            'libelle' => "Terminée"]);
    }
}
