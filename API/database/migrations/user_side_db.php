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

        Schema::create("nature_demande", function (Blueprint $t){
            $t->id();
            $t->string("nom");
        });

        Schema::create("demande", function (Blueprint $t){
            $t->id();
            $t->text("description");
            $t->foreignId("utilisateur")->references("id")->on("utilisateur");
            $t->foreignId("nature")->references("id")->on("nature_demande");
        });

        Schema::create("type_activite", function (Blueprint $t){
            $t->id();
            $t->string("nom");
            $t->text("description");
        });

        Schema::create("activite", function (Blueprint $t){
            $t->id();
            $t->string("nom");
            $t->text("description");
            $t->foreignId("type")->references("id")->on("type_activite");
        });

        Schema::create("session", function (Blueprint $t){
            $t->id();
            $t->string("nom");
            $t->text("emplacement");
            $t->dateTime("horaire");
            $t->text("description");
            $t->foreignId("activite")->references("id")->on("activite");
        });

        Schema::create("beneficie", function (Blueprint $t){
            $t->foreignId("beneficiaire")->references("id")->on("utilisateur");
            $t->foreignId("session")->references("id")->on("session");
            $t->primary(["beneficiaire", "session"]);
        });

        Schema::create("intervient", function (Blueprint $t){
            $t->foreignId("intervenant")->references("id")->on("utilisateur");
            $t->foreignId("session")->references("id")->on("session");
            $t->primary(["intervenant", "session"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intervient');
        Schema::dropIfExists('beneficie');
        Schema::dropIfExists('session');
        Schema::dropIfExists('activite');
        Schema::dropIfExists('type_activite');
        Schema::dropIfExists('demande');
        Schema::dropIfExists('nature_demande');
        Schema::dropIfExists('a_une_competence');
        Schema::dropIfExists('competence');
        Schema::dropIfExists('est_un');
        Schema::dropIfExists('role');
        Schema::dropIfExists('utilisateur');
        Schema::dropIfExists('addresse');
    }
};
