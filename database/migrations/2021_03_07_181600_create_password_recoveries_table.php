<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordRecoveriesTable extends Migration{
    public function up(){
        Schema::create('password_recoveries', function (Blueprint $table) {
            $table->integer('user_id');
            $table->string('recovery_uri');

            $table->primary(['user_id', 'recovery_uri']);
        });
    }

    public function down(){
        Schema::dropIfExists('password_recoveries');
    }
}
