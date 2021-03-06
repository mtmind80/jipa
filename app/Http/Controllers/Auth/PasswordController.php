<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\CommonController;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends CommonController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    public $redirectTo;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->redirectTo = $this->afterResetPasswordGoTo;

        $this->middleware('guest');

        /*
        $image = \App\HomeSlider::active()->random(1)->pluck('image');
        \View::share('backgroundImage', $image);
		*/
    }
}
