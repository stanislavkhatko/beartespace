<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Media;

class UserController extends Controller {

	public function store( Request $request ) {

		$user = User::find( $request['id'] );

		$user->update( $request->except( 'photo' ) );

		return [ 'status' => 'success', 'message' => 'Saved', 'data' => $user ];
	}
}
