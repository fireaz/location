<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('local_ward', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->nullable();
            $table->string('code')->nullable();
            $table->string('parent_code')->nullable();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('slug')->nullable();
            $table->string('slug_path')->nullable();
            $table->string('slug_path_with_type')->nullable();
            $table->string('name_with_type')->nullable();
            $table->string('path')->nullable();
            $table->string('path_with_type')->nullable();
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
        Schema::dropIfExists('local_ward');
    }
};
