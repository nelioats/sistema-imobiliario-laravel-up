<!-- defini o arquivo como txt pois tava apreesntando erro no momento de migrar -->
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->boolean('sale')->nullable();//ela pode ser nula, pois não é obrigatorio sua marcação
            $table->boolean('rent')->nullable();//ela pode ser nula, pois não é obrigatorio sua marcação
            $table->string('category');
            $table->string('type');
            $table->unsignedInteger('user');//chave estrangeira - inteiro que nao pode ser negativo

            //preços e valores
            $table->decimal('sale_price',10,2)->nullable();//('campo',tamanho,casas decimais)
            $table->decimal('rent_price',10,2)->nullable();//('campo',tamanho,casas decimais)
            $table->decimal('tribute',10,2)->nullable();//('campo',tamanho,casas decimais)
            $table->decimal('condominium',10,2)->nullable();//('campo',tamanho,casas decimais)

            //description
            $table->text('description')->nullable();
            $table->integer('bedrooms')->default('0');
            $table->integer('suites')->default('0');
            $table->integer('bathrooms')->default('0');
            $table->integer('rooms')->default('0');
            $table->integer('garage')->default('0');
            $table->integer('garage_covered')->default('0');
            $table->integer('area_total')->default('0');
            $table->integer('area_util')->default('0');

            //endereço
            $table->string('zipcode')->nullable();
            $table->string('street')->nullable();
            $table->string('number')->nullable();
            $table->string('complement')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();

            //estrutura
            $table->boolean('air_conditioning')->nullable();
            $table->boolean('bar')->nullable();
            $table->boolean('library')->nullable();
            $table->boolean('barbecue_grill')->nullable();
            $table->boolean('american_kitchen')->nullable();
            $table->boolean('fitted_kitchen')->nullable();
            $table->boolean('pantry')->nullable();
            $table->boolean('edicule')->nullable();
            $table->boolean('office')->nullable();
            $table->boolean('bathtub')->nullable();
            $table->boolean('fireplace')->nullable();
            $table->boolean('lavatory')->nullable();
            $table->boolean('furnished')->nullable();
            $table->boolean('pool')->nullable();
            $table->boolean('steam_room')->nullable();
            $table->boolean('view_of_the_sea')->nullable();

            $table->timestamps();

            //criando a relação com a tabela usuarios 
            //$table->foreign('user')->references('id da tabela users')->on('tabela que faz referencia -> users')->onDelete('CASCADE');
            $table->foreign('user')->references('id')->on('users')->onDelete('CASCADE');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
}
