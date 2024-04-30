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
            'nom' => 'benevole'
        ]);

        DB::table('addresse')->insert([
            'id' => 1,
            'premiere_ligne' => "1 rue du chene",
            'code_postal' => 75100,
            'ville' => 'Paris',
        ]);

        DB::table('utilisateur')->insert([
            'id' => 1,
            'prenom' => 'Admin',
            'nom' => 'Admin',
            'mail' => 'admin@gmail.com',
            'mot_de_passe_hash' => 'aebb25da59d0a4aa3a7a807af30b63556d50f7c89703eb5ad7064be5b5150a8a',
            'sel' => 'CKbcDWszB6',
            'mail_verifie' => true,
            'addresse' => 1
        ]);

        DB::table('est_un')->insert([
            'utilisateur' => 1,
            'role' => 1
        ]);

        DB::table('utilisateur')->insert([
            'id' => 2,
            'prenom' => 'user',
            'nom' => 'benevole',
            'mail' => 'benevole@gmail.com',
            'mot_de_passe_hash' => 'aebb25da59d0a4aa3a7a807af30b63556d50f7c89703eb5ad7064be5b5150a8a',
            'sel' => 'CKbcDWszB6',
            'mail_verifie' => true,
            'addresse' => 1
        ]);

        DB::table('est_un')->insert([
            'utilisateur' => 2,
            'role' => 2
        ]);

        DB::table('utilisateur')->insert([
            'id' => 3,
            'prenom' => 'nico',
            'nom' => 'beneficiaire',
            'mail' => 'beneficiaire@gmail.com',
            'mot_de_passe_hash' => 'aebb25da59d0a4aa3a7a807af30b63556d50f7c89703eb5ad7064be5b5150a8a',
            'sel' => 'CKbcDWszB6',
            'mail_verifie' => true,
            'addresse' => 1
        ]);

        DB::table('type_activite')->insert([
            'id' => 1,
            'nom' => 'Aide alimentaire',
            'description' => 'Aide alimentaire'
        ]);

        DB::table('type_activite')->insert([
            'id' => 2,
            'nom' => 'Aide administratif',
            'description' => 'Aide administratif'
        ]);

        DB::table('type_activite')->insert([
            'id' => 3,
            'nom' => 'Aide au transport',
            'description' => 'Aide au transport'
        ]);

        DB::table('type_activite')->insert([
            'id' => 4,
            'nom' => 'Formations',
            'description' => 'Formations'
        ]);

        DB::table('type_activite')->insert([
            'id' => 5,
            'nom' => 'Autre',
            'description' => 'Autre'
        ]);
    }
}
