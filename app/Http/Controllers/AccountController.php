<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function Account(Request $request){
        if (!isset($_SESSION)) session_start();
        if (!isset($_SESSION['AuthedUser'])) return redirect('/');
        $user = \App\Models\users::where('email', '=', $_SESSION['AuthedUser']['email'])->first();
        if ($user == null) return redirect('/');
        return view('account', ['user'=>$user]);
    }

    public function PasswordChange(Request $request){
        if (!isset($_SESSION)) session_start();
        if (!isset($_SESSION['AuthedUser'])) return redirect('/');
        $user = \App\Models\users::where('email', '=', $_SESSION['AuthedUser']['email'])->first();
        if ($user == null) return redirect('/');
        if (password_verify($request->input('old_pass'), $user->password)){
            $user->password = password_hash($request->input('new_pass'), PASSWORD_BCRYPT);
            $user->save();
            $_SESSION['message'] = ['type'=>'error', 'text'=>'Пароль успешно изменен'];
        } else {
            $_SESSION['message'] = ['type'=>'error', 'text'=>'Неверный пароль'];
        }
        return redirect('/account');
    }

    public function DataChange(Request $request){
        if (!isset($_SESSION)) session_start();
        if (!isset($_SESSION['AuthedUser'])) return redirect('/');
        $user = \App\Models\users::where('email', '=', $_SESSION['AuthedUser']['email'])->get();
        if (count($user) == 0) return redirect('/');
        if ($_SESSION['AuthedUser']['email'] != $request->input('email') && count(\App\Models\users::where('email', '=', $request->input('email'))->get()) > 0) {
            $_SESSION['message'] = ['type'=>'error', 'text'=>'Пользователь с данным адресом электронной почты уже существует'];
            return redirect('/account');
        } else
            $user = $user[0];
        if (password_verify($request->input('pass'), $user->password)){
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            $user->last_name = $request->input('last_name');
            $user->first_name = $request->input('first_name');
            $user->third_name = $request->input('third_name');
            $user->save();
            $_SESSION['AuthedUser']['email'] = $user->email;
            $_SESSION['message'] = ['type'=>'error', 'text'=>'Данные успешно изменены'];
        } else {
            $_SESSION['message'] = ['type'=>'error', 'text'=>'Неверный пароль'];
        }
        return redirect('/account');
    }
}
