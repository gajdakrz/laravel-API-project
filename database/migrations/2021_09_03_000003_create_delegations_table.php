<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDelegationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delegations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->datetime('start');
            $table->datetime('end');
            $table->string('country');
            $table->decimal('amount_due', 3, 2);
            $table->string('currency')->default('PLN');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            
            $table->index('id_user');
            
            Schema::table('delegations', function (Blueprint $table){
                $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('country')->references('country')->on('countries')->onDelete('cascade');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delegations');
    }
}