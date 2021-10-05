<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // обработчик авторизации пользователя
    public function SignIn(Request $request){
        // получаем данные из формы
        $data = $request->all();
        // лишнее удаляем
        unset($data['_token']);
        unset($data['public_pass']);
        unset($data['pass']);

        // среди всех пользователей ищем совпадающий e-mail и пароль
        foreach (\App\Models\users::all() as $user){
            if ($request->input('email') == $user->email &&
                password_verify($request->input('pass'), $user->password)){
                // если пользователь найден, начинаем сессию
                if (!isset($_SESSION)) session_start();
                $_SESSION['AuthedUser'] = array(
                    'email' => $user->email,
                    'role' => $user->role()->first()->name,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'third_name' => $user->third_name,
                    'phone' => $user->phone,
                );
                $_SESSION['message'] = ['type'=>'success','text'=>'Вы успешно вошли в систему'];
                return redirect()->route('main-page');
            }
        }
        // если пользователь не найден, возвращаемся с ошибкой
        $_SESSION['message'] = ['type'=>'error','text'=>'Неверный логин или пароль'];
        return redirect()->route('signin', $data);
    }
    // обработчик запроса на регистрацию
    public function SignUp(Request $request){
        if (!isset($_SESSION)) session_start();

        // получаем все поля формы
        $data = $request->all();
        // удаляем лишние
        unset($data['_token']);
        unset($data['public_pass']);
        unset($data['pass']);

        // валидация
        // если в данных ошибка - переадресовываем обратно с сообщением
        if ($request->input('email') == null){
            $_SESSION['message'] = ['type'=>'error','text'=>'Отсутствует E-Mail'];
            return redirect()->route('signup', $data);
        }
        if ($request->input('pass') == null){
            $_SESSION['message'] = ['type'=>'error','text'=>'Отсутствует пароль'];
            return redirect()->route('signup', $data);
        }
        foreach (\App\Models\users::all() as $user){
            if ($request->input('email') == $user->email){
                $_SESSION['message'] = ['type'=>'error', 'text'=>'Пользователь существует'];
                return redirect()->route('signup', $data);
            }
        }

        // если валидация пройдена,
        // добавляем пользователя в БД
        \App\Models\users::create(array(
            'email' => $request->input('email'),
            'password' => password_hash($request->input('pass'), PASSWORD_BCRYPT),
            'role_id' => 2,
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'third_name' => $request->input('third_name'),
            'phone' => $request->input('phone'),
        ));
        $_SESSION['message'] = ['type'=>'success', 'text'=>'Вы успешно зарегистрированы'];
        // устанавливаем сессию, чтобы данные пользователя были доступны во всех точках сайта
        $_SESSION['AuthedUser'] = array(
            'email' => $request->input('email'),
            'role' => (new \App\Models\roles)->find(2)->name,
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'third_name' => $request->input('third_name'),
            'phone' => $request->input('phone'),
        );
        // возвращаемся на главную
        return redirect()->route('main-page');
    }
    public function SignDown(Request $request){
        if (!isset($_SESSION)) session_start();
        unset($_SESSION['AuthedUser']);
        $_SESSION['message'] = ['type'=>'success', 'text'=>'До свидания!'];
        return redirect()->route('main-page');
    }

    public function ResetPassword($user_id){
        $user = \App\Models\users::find($user_id);
        if ($user == null) return ['status'=>'error', 'message'=>'Пользователя не существует'];
        if (!isset($_SESSION)) session_start();
        if ($user->email != $_SESSION['AuthedUser']['email'])
            if (!isset($_SESSION['AuthedUser']) || $_SESSION['AuthedUser']['role'] != 'Администратор')
                return ['status'=>'error', 'message'=>'Недостаточно прав для сброса пароля'];
        $user->password = password_hash('', PASSWORD_BCRYPT);
        $user->save();
        return ['status'=>'success'];
    }

    public static function UserHaveRole($roles){
        if (!isset($_SESSION)) session_start();
        if (!isset($_SESSION['AuthedUser'])) return false;
        $role = \App\Models\users::where('email', '=', $_SESSION['AuthedUser']['email'])->first()->role()->first()->name;
        if (is_array($roles)){
            return in_array($role, $roles);
        } else {
            return $role == $roles;
        }
    }

    public static function UserExist(Request $request){
        $user = \App\Models\users::where('email', '=', $request->input('email'))->first();
        if ($user == null)
            return ['status'=>'did not exist'];
        else
            return ['status'=>'exist'];
    }
}
