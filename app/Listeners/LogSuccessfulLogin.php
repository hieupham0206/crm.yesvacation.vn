<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login $event
     *
     * @return void
     */
    public function handle(Login $event)
    {
        $user             = $event->user;
        $user->last_login = now()->toDateTimeString();
        $user->update();

        /** @noinspection MissedFieldInspection */
        /** @noinspection PhpParamsInspection */
        activity()
            ->performedOn($user)
            ->inLog('Auth')
            ->withProperties(['ip' => request()->ip(), 'user-agent' => request()->userAgent(), 'username' => $user->username])
            ->log("Tài khoản {$user->username} đã đăng nhập.");
    }
}
