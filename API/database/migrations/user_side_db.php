<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("addresse", function (Blueprint $t){
            $t->id();
            $t->string("premiere_ligne");
            $t->integer("code_postal");
            $t->string("ville");
        });

        Schema::create('utilisateur', function (Blueprint $t){
            $t->id();
            $t->string("prenom");
            $t->string("nom");
            $t->string("mail");
            $t->string("mot_de_passe_hash");
            $t->string("sel");
            $t->boolean("mail_verifie")->default(false);
            $t->dateTime("derniere_connexion")->default(DB::raw('CURRENT_TIMESTAMP'));
            $t->foreignId("addresse")->references("id")->on("addresse");
        });

        Schema::create("role", function (Blueprint $t){
            $t->id();
            $t->string("nom");
        });

        Schema::create("est_un", function (Blueprint $t){
            $t->foreignId("utilisateur")->references("id")->on("utilisateur");
            $t->foreignId("role")->references("id")->on("role");
            $t->primary(["utilisateur", "role"]);
        });

        Schema::create("competence", function (Blueprint $t){
            $t->id();
            $t->string("nom");
            $t->text("description");
        });

        Schema::create("a_une_competence", function (Blueprint $t){
            $t->foreignId("utilisateur")->references("id")->on("utilisateur");
            $t->foreignId("competence")->references("id")->on("competence");
            $t->primary(["utilisateur", "competence"]);
        });

        Schema::create("type_activite", function (Blueprint $t){
            $t->id();
            $t->string("nom");
            $t->text("description");
        });

        Schema::create("demande", function (Blueprint $t){
            $t->id();
            $t->text("description");
            $t->boolean("statut")->nullable();
            $t->foreignId("utilisateur")->references("id")->on("utilisateur");
            $t->foreignId("type")->references("id")->on("type_activite");
        });

        Schema::create("activite", function (Blueprint $t){
            $t->id();
            $t->string("nom");
            $t->text("description");
            $t->foreignId("type")->references("id")->on("type_activite");
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('activite');
        Schema::dropIfExists('demande');
        Schema::dropIfExists('type_activite');
        Schema::dropIfExists('a_une_competence');
        Schema::dropIfExists('competence');
        Schema::dropIfExists('est_un');
        Schema::dropIfExists('role');
        Schema::dropIfExists('utilisateur');
        Schema::dropIfExists('addresse');
    }
};
