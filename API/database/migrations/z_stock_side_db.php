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
            $t->foreignId("addresse")->references("id")->on("addresse");
        });

        Schema::create("entrepot", function (Blueprint $t){
            $t->id();
            $t->string("nom");
            $t->foreignId("addresse")->references("id")->on("addresse");
        });

        Schema::create("fournisseur", function (Blueprint $t){
            $t->id();
            $t->string("nom");
            $t->foreignId("addresse")->references("id")->on("addresse");
        });

        Schema::create("camion", function (Blueprint $t){
            $t->id();
            $t->string("modele");
            $t->float("limite_poids");
            $t->foreignId("annexe")->references("id")->on("annexe");
        });

        Schema::create("produit", function (Blueprint $t){
            $t->id();
            $t->string("quantite");
            $t->date("date_limite");
            $t->string("nom");
            $t->text("description");
            $t->foreignId("fournisseur")->references("id")->on("fournisseur");
            $t->foreignId("entrepot")->references("id")->on("entrepot");
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
            $t->integer("ordre");
            $t->primary(["produit", "ramassage"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ramasse');
        Schema::dropIfExists('ramassage');
        Schema::dropIfExists('produit');
        Schema::dropIfExists('camion');
        Schema::dropIfExists('fournisseur');
        Schema::dropIfExists('entrepot');
        Schema::dropIfExists('annexe');
    }
};
