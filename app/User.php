<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Laravel\Cashier\Billable;

class User extends Authenticatable {
	use HasApiTokens, Billable, Notifiable, SoftDeletes;

	protected $dates = [ 'deleted_at' ];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];
	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
		'activation_token'
	];

	protected $casts = [
		'technique' => 'array',
	];

	public function country() {
		return $this->belongsTo( Country::class );
	}

	public function artworks() {
		return $this->hasMany( Artwork::class );
	}

	public function articles() {
		return $this->hasMany( Article::class );
	}

	public function favouriteArtworks() {
		return $this->belongsToMany( Artwork::class, 'favorites' );
	}

	public function orders() {
		return $this->hasMany( Order::class );
	}

	public function currency() {
		return $this->belongsTo( Currency::class );
	}

	public function avatar() {
		return $this->hasOne( Media::class, 'avatar_id' );
	}

	public function image() {
		return $this->hasOne( Media::class, 'image_id' );
	}


	public function isAdmin() {
		return $this->user_type == 'admin';
	}

	public function isUser() {
		return $this->user_type == 'user';
	}

	public function isGallery() {
		return $this->user_type == 'gallery';
	}

	public function isArtist() {
		return $this->user_type == 'artist';
	}

	public function scopeArtist( $query ) {
		return $query->where( 'user_type', 'artist' );
	}

	public function getNameAttribute() {
		return trim( $this->first_name ) . ' ' . trim( $this->last_name );
	}

	public function setNameAttribute() {
		return trim( $this->first_name ) . ' ' . trim( $this->last_name );
	}

	public function plans() {
		return $this->hasMany( Plan::class, 'user_type', 'user_type' );
	}


	/**
	 * @param int $s
	 * @param string $d
	 * @param string $r
	 * @param bool $img
	 * @param array $atts
	 *
	 * @return string
	 */
	public function get_gravatar( $s = 40, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
		$parse_url = parse_url( $this->photo );
		$url       = '';
		$email     = $this->email;

		if ( ! empty( $parse_url['scheme'] ) ) {
			$url = $this->photo;
		} else {
			$url = 'http://www.gravatar.com/avatar/';
			$url .= md5( strtolower( trim( $email ) ) );
			$url .= "?s=$s&d=$d&r=$r";

			if ( ! empty( $this->photo ) ) {
				$url = avatar_img_url( $this->photo, $this->photo_storage );
			}

			if ( $img ) {
				$url = '<img src="' . $url . '"';
				foreach ( $atts as $key => $val ) {
					$url .= ' ' . $key . '="' . $val . '"';
				}
				$url .= ' />';
			}
		}

		return $url;
	}

	public function signed_up_datetime() {
		$created_date_time = false;
		if ( $this->created_at ) {
			$created_date_time = $this->created_at->timezone( get_option( 'default_timezone' ) )->format( get_option( 'date_format_custom' ) . ' ' . get_option( 'time_format_custom' ) );
		}

		return $created_date_time;
	}

	public function status_context() {
		$status = $this->active_status;

		$context = '';
		switch ( $status ) {
			case '0':
				$context = 'Pending';
				break;
			case '1':
				$context = 'Active';
				break;
			case '2':
				$context = 'Block';
				break;
		}

		return $context;
	}

}
