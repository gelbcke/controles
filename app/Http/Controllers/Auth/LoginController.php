<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use Auth, Session, Hash, Toastr;
use App\Notifications\TwoFactorCode;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Auth\TwoFactor;
use Illuminate\Http\Request;
Use Redirect;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(\Illuminate\Http\Request $request)
    {
        $this->request = $request;
        $this->middleware('guest')->except([
            'logout',
            'locked',
            'unlock'
        ]);
    }

    function authenticated(\Illuminate\Http\Request $request, $user)
    {
        // IF 2FA true, send code to email
        if(config('app.2fa') == true){
          $user->generateTwoFactorCode();
          $user->notify(new TwoFactorCode());
        }

        $user->update([
            'last_login_at' => Carbon::now()->toDateTimeString(),
            'last_login_ip' => $request->getClientIp()
        ]);

        return redirect('/dashboard');
    }

    public function login(\Illuminate\Http\Request $request) {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
                $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        // This section is the only change
        if ($this->guard()->validate($this->credentials($request))) {
            $user = $this->guard()->getLastAttempted();

            // Make sure the user is active
            if ($user->status == 1 && $this->attemptLogin($request)) {
                // Send the normal successful login response
                return $this->sendLoginResponse($request);
            } else {
                // Increment the failed login attempts and redirect back to the
                // login form with an error message.
                $this->incrementLoginAttempts($request);
                return redirect()
                    ->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors(['active' => 'Seu acesso ao sistema está bloqueado!']);
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function logout(){
        Auth::logout();
        return Redirect::to('login');
    }

    public function locked()
    {
        if(!session('lock-expires-at')){
            return redirect('/');
        }

        if(session('lock-expires-at') > now()){
            return redirect('/');
        }

        return view('auth.locked');
    }

    public function unlock(Request $request)
    {

        $check = Hash::check($request->input('password'), $request->user()->password);

        if(!$check){
            toastr()->error('Senha Incorreta!', 'ERRO', ['timeOut' => 5000, 'positionClass' => 'toast-top-center']);
            return redirect()->route('login.locked');
        }if($check){
            toastr()->info('Sistema Desbloqueado!', 'SUCESSO', ['timeOut' => 5000, 'positionClass' => 'toast-top-center']);
        }

        session(['lock-expires-at' => now()->addMinutes($request->user()->getLockoutTime())]);

        // Check if Session still available
        if(!empty(session('links')))
        {
            return redirect(session('links')[2]); // Will redirect 2 links back
        }
        else{
           return redirect('/');
        }

    }

}
