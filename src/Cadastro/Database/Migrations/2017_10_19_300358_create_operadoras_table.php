<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperadorasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operadoras', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->double('porcentagem_credito', 15,2);
            $table->double('porcentagem_credito_parcelado', 15,2);
            $table->double('porcentagem_debito', 15,2);
            
            $table->integer('max_parcelas')->default(3);

            $table->integer('repasse_debito_dias')->default(1);

            $table->boolean('ativo')->default(true);
            $table->softDeletes();
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
        Schema::dropIfExists('operadoras');
    }
}
