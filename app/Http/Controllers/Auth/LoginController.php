<?php

namespace App\Http\Controllers\Auth;

use App\Entities\Core\Otp;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @inheritdoc
     */
    protected function credentials(Request $request)
    {
        return [
            $this->username() => $request->get('username'),
            'password'        => $request->password,
            'state'           => 1
        ];
    }

    /**
     *
     * @return string
     */
    public function username()
    {
        $login = request()->get('username');

        return filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    }

    /**
     * @inheritdoc
     * @throws \Exception
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            /** @noinspection PhpVoidFunctionResultUsedInspection */
            return $this->sendLockoutResponse($request);
        }

        $username = $request->get('username');
        if (env('LOGIN_OTP', false) && User::isUseOtp($username) && Auth::once($this->credentials($request))) {
            session(['password' => $request->password]);

            $otp   = new Otp($username);
            $phone = User::getPhone($username);
            //send OTP
            if ( ! $otp->generate()->send($phone)) {
                throw ValidationException::withMessages([
                    'otp_error' => __('auth.Something wrong, please try again later')
                ]);
            }

            return response()->redirectToRoute('otp', compact('phone', 'username'));
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function loginOtp(Request $request)
    {
        $otpText  = $request->get('otp');
        $username = $request->get('username');
        $password = session('password');

        $otp = new Otp($username);

        if ( ! $otp->validate($otpText)) {
            throw ValidationException::withMessages([
                'otp' => __('auth.OTP is not valid')
            ]);
        }

        $credentials             = $this->credentials($request);
        $credentials['password'] = $password;

        if ($this->guard()->attempt($credentials, false)) {
            User::resetOtp($username);

            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function resendOtp(Request $request)
    {
        $phone    = $request->route()->parameter('phone');
        $username = $request->route()->parameter('username');

        $otp = new Otp($username);

        if ( ! $otp->generate()->send($phone)) {
            throw ValidationException::withMessages([
                'otp_error' => __('auth.Something wrong, please try again later')
            ]);
        }

        return response()->json([
            'message' => "OTP đã gửi lại cho số điện thoại $phone"
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function formOtp(Request $request)
    {
        $phone    = $request->route()->parameter('phone');
        $username = $request->route()->parameter('username');

        //note: Validate phone exist

        return view('auth.otp', compact('phone', 'username'));
    }
}
