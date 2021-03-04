<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClicksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clicks', function (Blueprint $table) {

            $table->engine = 'InnoDB';

            //fix Specified key was too long
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->id();
            $table->string('ua')->default('no');//->nullable();
            $table->ipAddress('ip')->default('no');
            $table->string('ref')->default('no');
            $table->string('param1')->default('no');
            $table->string('param2')->default('no');
            $table->integer('error')->default(0);
            $table->boolean('bad_domain')->default(0);

            $table->unique(['ua', 'ip', 'ref', 'param1'], 'id_click');//'HASH'??
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clicks');
    }
}
