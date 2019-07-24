<?php

namespace App\Http\Middleware;

use App\Models\UserSetting;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Support\Facades\Config;

class Authenticate extends Middleware
{
    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        parent::__construct($auth);

        # Load the user prefered language and create a variable with it in the main layout.
        if ($user = \Illuminate\Support\Facades\Auth::user()) {
            $userSetting = UserSetting::where([
                'user_id' => $user->id,
            ])->first();

            Config::set('settings.language', $userSetting->language);
        }
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
