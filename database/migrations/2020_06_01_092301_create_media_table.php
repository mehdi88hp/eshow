<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'media', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->string( 'name' );
            $table->string( 'title' )->nullable();
            $table->string( 'path' )->defaut( '' );
            $table->string( 'disk' );
            $table->string( 'url', 1022 )->nullable();
            $table->string( 'mime_type' )->nullable();
            $table->unsignedBigInteger( 'user_id' )->nullable();

            $table->integer( 'state' );
            $table->bigInteger( 'created_by' )->unsigned()->nullable();
            $table->bigInteger( 'updated_by' )->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        } );

        Schema::table( 'media', function ( Blueprint $table ) {
            $table->foreign( 'created_by' )
                  ->references( 'id' )
                  ->on( 'users' );

            $table->foreign( 'updated_by' )
                  ->references( 'id' )
                  ->on( 'users' );

            $table->foreign( 'user_id' )
                  ->references( 'id' )
                  ->on( 'users' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        DB::statement( 'SET FOREIGN_KEY_CHECKS = 0' );
        Schema::drop( 'media' );
        DB::statement( 'SET FOREIGN_KEY_CHECKS = 1' );
    }
}
