<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtworksTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'artworks', function ( Blueprint $table ) {
			$table->increments( 'id' );
			$table->integer( 'user_id' );
			$table->string( 'slug' )->nullable();
			$table->string('url')->nullable();
			$table->string( 'name' );
			$table->string( 'made_by' )->nullable()->default( null );
			$table->text( 'description' );
			$table->text( 'inspiration' )->nullable();
			$table->boolean( 'optional_size' )->nullable();
			$table->decimal( 'height', 5, 2 )->nullable();
			$table->decimal( 'b_height', 5, 2 )->nullable();
			$table->decimal( 'width', 5, 2 )->nullable();
			$table->decimal( 'b_width', 5, 2 )->nullable();
			$table->decimal( 'depth', 5, 2 )->nullable();
			$table->decimal( 'b_depth', 5, 2 )->nullable();
			$table->decimal( 'weight', 8, 2 )->nullable();
			$table->decimal( 'b_weight', 8, 2 )->nullable();
			$table->timestamp( 'date_of_completion' );
			$table->decimal( 'price', 12, 2 );
			$table->string( 'currency' )->nullable();
			$table->integer( 'country_id' )->nullable();
			$table->string( 'processing_time' )->nullable();
			$table->string( 'category' );
			$table->json( 'tags' )->nullable();
			$table->json( 'medium' )->nullable();
			$table->json( 'direction' )->nullable();
			$table->json( 'theme' )->nullable();
			$table->json( 'color' )->nullable();
			$table->string( 'shape' )->nullable();
			$table->integer( 'image_id' );
			$table->integer( 'quantity' )->default( 1 );

			$table->enum( 'status', [ 'pending', 'reserved', 'available', 'unavailable', 'sold' ] )->nullable();
			$table->enum( 'auction_status', ['todo'] )->nullable();
			$table->decimal( 'auction_price', 12, 2 )->nullable();
			$table->timestamp( 'auction_start' )->nullable();
			$table->timestamp( 'auction_end' )->nullable();
			$table->string( 'sold_by' )->nullable();
			$table->timestamp( 'auction_start_at' )->nullable();
			$table->timestamp( 'auction_end_at' )->nullable();
			$table->timestamp( 'sold_at' )->nullable();
			$table->timestamps();
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop( 'artworks' );
	}
}
