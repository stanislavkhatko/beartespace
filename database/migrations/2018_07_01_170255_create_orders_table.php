<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'orders', function ( Blueprint $table ) {
			$table->increments( 'id' );
			$table->integer( 'user_id' )->nullable();
			$table->json( 'address' )->nullable();
			$table->longText('content')->nullable();
			$table->decimal( 'amount' )->nullable();
			$table->enum('status', ['initial','pending','success','failed','declined','dispute'])->nullable()->default('initial');

			//payment created column will be use by gateway
			$table->timestamp( 'confirmed_at' )->nullable();
			$table->timestamps();
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'orders' );
	}
}
