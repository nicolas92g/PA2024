<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("annexe", function (Blueprint $t){
            $t->id();
            $t->string("nom");
            $t->foreignId("addresse")->references("id")->on("addresse")->onDelete('cascade');
        });

        Schema::create("entrepot", function (Blueprint $t){
            $t->id();
            $t->string("nom");
            $t->foreignId("addresse")->references("id")->on("addresse")->onDelete('cascade');
        });

        Schema::create("fournisseur", function (Blueprint $t){
            $t->id();
            $t->string("nom");
            $t->foreignId("addresse")->references("id")->on("addresse");
        });

        Schema::create("camion", function (Blueprint $t){
            $t->id();
            $t->string("marque");
            $t->string("modele");
            $t->integer("annee");
            $t->string("immatriculation");
            $t->foreignId("annexe")->references("id")->on("annexe");
        });

        Schema::create("session", function (Blueprint $t){
            $t->id();
            $t->string("nom");
            $t->text("emplacement");
            $t->text("emplacement_arrive")->nullable();
            $t->dateTime("horaire");
            $t->dateTime("horaire_fin")->nullable();
            $t->text("description");
            $t->integer("max_participants")->nullable();
            $t->integer("quantite")->nullable();
            $t->foreignId("camion")->nullable()->references("id")->on("camion");
            $t->foreignId("entrepot")->nullable()->references("id")->on("entrepot");
            $t->foreignId("activite")->references("id")->on("activite");
        });

        Schema::create("produit", function (Blueprint $t){
            $t->id();
            $t->string("quantite");
            $t->date("date_limite")->nullable();
            $t->string("nom");
            $t->text("description");
            $t->foreignId("fournisseur")->nullable()->references("id")->on("fournisseur");
            $t->foreignId("entrepot")->nullable()->references("id")->on("entrepot");
            $t->foreignId("maraude")->nullable()->references("id")->on("session")->onDelete('cascade');
        });

        Schema::create("ramassage", function (Blueprint $t){
            $t->id();
            $t->dateTime("horaire_debut");
            $t->foreignId("camion")->references("id")->on("camion");
            $t->foreignId("utilisateur")->references("id")->on("utilisateur");
        });

        Schema::create("ramasse", function (Blueprint $t){
            $t->foreignId("produit")->references("id")->on("produit");
            $t->foreignId("ramassage")->references("id")->on("ramassage");
            $t->integer("ordre")->nullable();
            $t->primary(["produit", "ramassage"]);
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

        Schema::create("etape", function (Blueprint $t){
            $t->foreignId("addresse")->references("id")->on("addresse")->onDelete('cascade');
            $t->foreignId("maraude")->references("id")->on("session");
            $t->primary(["addresse", "maraude"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etape');
        Schema::dropIfExists('intervient');
        Schema::dropIfExists('beneficie');
        Schema::dropIfExists('ramasse');
        Schema::dropIfExists('ramassage');
        Schema::dropIfExists('produit');
        Schema::dropIfExists('session');
        Schema::dropIfExists('camion');
        Schema::dropIfExists('fournisseur');
        Schema::dropIfExists('entrepot');
        Schema::dropIfExists('annexe');
    }
};
