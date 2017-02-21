<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFiles extends Migration
{
    public function up()
    {
        Schema::create('files', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('filename');
            $table->string('mime');
            $table->string('original_filename');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('files');
    }
}
