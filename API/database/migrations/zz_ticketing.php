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
        Schema::create("ticket_publication", function (Blueprint $t){
            $t->id();
            $t->string("titre")->nullable();
            $t->text("contenu");
            $t->string("etat")->nullable();
            $t->dateTime("horaire");
            $t->foreignId("utilisateur")->references("id")->on("utilisateur");
            $t->foreignId("parent")->nullable()->references("id")->on("ticket_publication");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_publication');
    }
};
