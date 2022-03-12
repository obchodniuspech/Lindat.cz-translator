<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('translate_history', function (Blueprint $table) {
            $table->id();
            $table->string("langFrom")->nullable(true);
            $table->string("langTo")->nullable(true);
            $table->text("textFrom")->nullable(true);
            $table->text("textTo")->nullable(true);
            $table->integer("userId")->nullable(true);
            $table->boolean("star")->nullable(true);
            $table->boolean("status")->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
