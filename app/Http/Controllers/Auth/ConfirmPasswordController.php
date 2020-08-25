<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ConfirmsPasswords;
use Illuminate\Support\Facades\Auth;

class ConfirmPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Confirm Password Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password confirmations and
    | uses a simple trait to include the behavior. You're free to explore
    | this trait and override any functions that require customization.
    |
    */

    use ConfirmsPasswords;

    /**
     * Where to redirect users when the intended url fails.
     *
     * @var string
     */
    //protected $redirectTo = '/home';
    public function redirectTo()
    {
        $role = Auth::user()->role;
        
        switch($role) {
            case '1':
                return '/admin';
                break;
            case '2':
                return '/books';
                break;
            case '3':
                return '/home';
                break;
            default:
                return '/login';
                break;
        }
    }

    public function __construct()
    {
        $this->middleware('auth');
    }
}
