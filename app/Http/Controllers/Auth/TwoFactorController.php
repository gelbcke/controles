<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\TwoFactorCode;
use Carbon\Carbon;

class TwoFactorController extends Controller
{
    public function index()
    {
        return view('auth.twoFactor');
    }

    public function store(Request $request)
    {
        if(config('app.2fa') == true){
          $request->validate([
              'two_factor_code' => 'integer|required',
          ]);

        $user = auth()->user();

        $now = Carbon::now();

        if(($request->input('two_factor_code') == $user->two_factor_code) && ($now <= $user->two_factor_expires_at))
        {
            $user->resetTwoFactorCode();
            return redirect('/dashboard');
        }
        else if ($now >= $user->two_factor_expires_at){
            return redirect()->back()
            ->withErrors(['two_factor_code' =>
                'Você não possui nenhum código válido para verificação!']);
        }else{

        return redirect()->back()
            ->withErrors(['two_factor_code' =>
                'O código informado é inválido!']);
        }
      }
    }

    public function resend()
    {
        $user = auth()->user();
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode());

        return redirect()->back()->withMessage('O código foi reenviado para o seu email!');
    }
}
