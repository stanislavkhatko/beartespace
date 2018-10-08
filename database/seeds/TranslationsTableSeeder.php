<?php

use Illuminate\Database\Seeder;
use Spatie\TranslationLoader\LanguageLine;

class TranslationsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		$translations = [
			'portal'       => [
				[ 'Sign in', '' ],
				[ 'Register', '' ],
				[ 'Artists', '' ],
				[ 'Artworks', '' ],
				[ 'Auction', '' ],
				[ 'About Us', '' ],
				[ 'Information', '' ],
				[ 'Contact', '' ],
				[ 'Category', '' ],
				[ 'Direction', '' ],
				[ 'Medium', '' ],
				[ 'Theme', '' ],
				[ 'Color', '' ],
				[ 'Technique', '' ],
				[ 'Basic', '' ],
				[ 'Expanded', '' ],
				[ 'Trial', '' ],
			],
			'category'     => [
				[ 'Painting', 'Maleri' ],
				[ 'Sculpture', 'Skulptur' ],
				[ 'Drawing', '' ],
				[ 'Glass Art', '' ],
				[ 'Ceramic', '' ],
			],
			'direction'    => [
				[ 'Abstraction', 'Abstraktion' ],
				[ 'Colorism', '' ],
				[ 'Impressionism', '' ],
				[ 'Realisme', '' ],
				[ 'Surrealisme', '' ],
				[ 'Cubisme', '' ],
				[ 'Fantasy Realism', '' ],
				[ 'Street Art', '' ],
			],
			'medium'       => [
				[ 'Oil', '' ],
				[ 'Acrylic', '' ],
				[ 'Watercolor', '' ],
				[ 'Coal', '' ],
				[ 'Pencil', '' ],
				[ 'Pastels', '' ],
				[ 'Mixed Technique', '' ],
				[ 'Bronze', '' ],
				[ 'Wood', '' ],
				[ 'Glass', '' ],
			],
			'theme'        => [
				[ 'Figurative', '' ],
				[ 'Abstract', '' ],
				[ 'Portrait', '' ],
				[ 'Plants/flowers', '' ],
				[ 'Landscapes', '' ],
				[ 'Still Life', '' ],
				[ 'Animals/fish etc', '' ],
				[ 'Maritime', '' ],
				[ 'City Landscape', '' ],
			],
			'shape'        => [
				[ 'Square', '' ],
				[ 'Oval/Round', '' ],
				[ 'Horizontal', '' ],
				[ 'Vertical', '' ],
			],
			'color'        => [
				[ 'Red', '' ],
				[ 'Green', '' ],
				[ 'Yellow', '' ],
				[ 'Blue', '' ],
				[ 'Orange', '' ],
				[ 'Purple', '' ],
				[ 'Cyan', '' ],
				[ 'Magenta', '' ],
				[ 'Lime', '' ],
				[ 'Pink', '' ],
				[ 'Teal', '' ],
				[ 'Lavender', '' ],
				[ 'Brown', '' ],
				[ 'Beige', '' ],
				[ 'Maroon', '' ],
				[ 'Olive', '' ],
				[ 'Coral', '' ],
				[ 'Navy', '' ],
				[ 'Grey', '' ],
				[ 'White', '' ],
				[ 'Black', '' ],
			],
			'profession'   => [
				[ 'Sculptor', 'Sculpturer' ],
				[ 'Cartoonist', '' ],
				[ 'Illustrator', '' ],
				[ 'Painter', 'Painter' ],
				[ 'Academic teacher', '' ]
			],
			'education'    => [
				[ 'High Scool Graduate', '' ],
				[ 'Bachelor', '' ],
				[ 'Master', '' ],
				[ 'Professor', '' ],
				[ 'Ph.D.', '' ]
			],
			'gender'       => [
				[ 'Male', 'Man' ],
				[ 'Female', 'Kwine' ],
				[ 'Third', '' ],
				[ 'None', '' ]
			],
			'stock-status' => [
				[ 'Available', '' ],
				[ 'Temporarily unavailable', '' ],
				[ 'Unavailable', '' ],
				[ 'Sold', '' ],
			],
			'processing-time' => [
				['7 business days', ''],
				['2 weeks', ''],
				['1 month', ''],
				['Unknown', ''],
			]
		];

		foreach ( $translations as $group => $trans ) {

			foreach ( $trans as $tran ) {
				$key = str_slug( $tran[0], '-' );

				LanguageLine::create( [
					'group' => $group,
					'key'   => $key,
					'text'  => [ 'en' => $tran[0], 'da' => $tran[1] ],
				] );
			}
		}
	}
}
