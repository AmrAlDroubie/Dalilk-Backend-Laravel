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
        Schema::create("pharmacies", function (Blueprint $table) {
            $table->id()->primary();
            $table->string("name");
            $table->string("city");
            $table->string("address");
            $table->string("map_url");
            $table->string("first_name");
            $table->string("last_name");
            $table->string("full_name")->virtualAs("CONCAT(first_name,' ', last_name)");
            $table->string("email")->unique();
            $table->string("phone_number")->unique();
            $table->string("password");
            $table->boolean('status')->default(false);
            $table->text("map_iframe")->nullable();
            $table->timestamps();
        });


        Schema::create('medcines', function (Blueprint $table) {
            $table->id()->primary();
            $table->string("med_name");
            $table->string("price");
            $table->integer("quantity");
            $table->foreignId("pharmacy_id");
            $table->foreign("pharmacy_id")->references("id")->on("pharmacies");
            $table->string("keywords")->nullable();
            $table->timestamps();
        });


        Schema::create("admin", function (Blueprint $table) {
            $table->id()->primary();
            $table->string("email");
            $table->string("password");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medcines');
        Schema::dropIfExists('admin');
        Schema::dropIfExists('pharmacies');
    }
};
