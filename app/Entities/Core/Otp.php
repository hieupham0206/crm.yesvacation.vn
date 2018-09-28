<?php

namespace App\Entities\Core;

use App\Models\User;

class Otp
{
    public $otpText;
    public $username;

    /**
     * Otp constructor.
     *
     * @param $username
     *
     * @throws \Exception
     */
    public function __construct($username)
    {
        $this->username = $username;
        $this->otpText  = random_int(100000, 999999);
    }

    /**
     * @return Otp
     */
    public function generate()
    {
        $user = User::whereUsername($this->username)->whereState(1)->first();

        if ($user) {
            $user->update([
                'otp'            => $this->otpText,
                'otp_expired_at' => now()->addMinutes(5)
            ]);
        }

        return $this;
    }

    /**
     * @param $otp
     *
     * @return bool
     */
    public function validate($otp)
    {
        return User::query()->where('username', $this->username)
                   ->where('otp', $otp)
                   ->where('otp_expired_at', '>=', now()->toDateTimeString())
                   ->exists();
    }

    /**
     * @return int
     */
    public function reset()
    {
        return User::query()->where('username', $this->username)->update([
            'otp'            => null,
            'otp_expired_at' => null
        ]);
    }

    /**
     * @param $phone
     *
     * @return bool
     */
    public function send($phone)
    {
        if ($phone) {
            //note: Gọi hàm send OTP qua SMS hoặc Mail

            return true;
        }


        return false;
    }
}