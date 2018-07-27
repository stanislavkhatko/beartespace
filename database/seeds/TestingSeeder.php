<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Artwork;
use App\Article;

class TestingSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
//		factory(App\User::class, 50)->create();

		if ( App::environment() !== 'production' ) {
			factory( App\User::class, 50 )->create()->each( function ( $u ) {
				$u->artworks()->save( factory( App\Artwork::class )->make( [
					'user_id' => $u->id
				] ) );
			} );
		}

		$users = User::all();

		foreach ( $users as $user ) {
			if ( $user->user_type = 'artist' ) {
				$user->artworks()->saveMany( factory( App\Artwork::class, 10 )->make() );
				$user->avatar()->save( factory( App\Media::class )->make( [
					'url' => 'https://picsum.photos/290/290',
				] ) );

				$user->image()->save( factory( App\Media::class )->make( [
					'url' => 'https://picsum.photos/' . random_int( 1, 1920 ) . '/' . random_int( 1, 1920 ),
				] ) );

				$user->articles()->saveMany( factory( App\Article::class, 5 )->make() );
			}
		}

		$artworks = Artwork::all();

		foreach ( $artworks as $artwork ) {
			$artwork->images()->saveMany( factory( App\Media::class, random_int( 1, 4 ) )->make() );
		}

		$articles = Article::all();

		foreach ( $articles as $article ) {
			$article->image()->save( factory( App\Media::class )->make() );
		}
	}
}
