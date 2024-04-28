<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //DEFAULT ROLES
        DB::table('role')->insert([
            'id' => 1,
            'nom' => 'admin'
        ]);

        DB::table('role')->insert([
            'id' => 2,
            'nom' => 'content'
        ]);

        //SUPER ADMIN (FIRST USER)
        DB::table('addresse')->insert([
            'id' => 1,
            'premiere_ligne' => "1 rue du chene",
            'code_postal' => 75100,
            'ville' => 'Paris',
        ]);

        DB::table('utilisateur')->insert([
            'id' => 1,
            'prenom' => 'Super',
            'nom' => 'Admin',
            'mail' => 'nicolas.guillot.esgi@gmail.com',
            'mot_de_passe_hash' => 'aebb25da59d0a4aa3a7a807af30b63556d50f7c89703eb5ad7064be5b5150a8a',
            'sel' => 'CKbcDWszB6',
            'mail_verifie' => true,
            'addresse' => 1
        ]);

        DB::table('est_un')->insert([
            'utilisateur' => 1,
            'role' => 1
        ]);

        DB::table('type_activite')->insert([
            'id' => 1,
            'nom' => ''
        ]);
    }
}
