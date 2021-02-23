<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailConfirmationsTable extends Migration{
    public function up(){
        Schema::create('email_confirmations', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('confirmation_uri');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('email_confirmations');
    }
}
