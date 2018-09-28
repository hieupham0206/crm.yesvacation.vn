<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;

class LogSuccessfulLogout
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
     * @param Logout $event
     *
     * @return void
     */
    public function handle(Logout $event)
    {
        $user = $event->user;

        /** @noinspection MissedFieldInspection */
        /** @noinspection PhpParamsInspection */
        activity()
            ->withProperties(['ip' => request()->ip(), 'user-agent' => request()->userAgent(), 'username' => $user->username])
            ->performedOn($user)
            ->inLog('Auth')
            ->log("Tài khoản {$user->username} đã đăng xuất.");
    }
}
