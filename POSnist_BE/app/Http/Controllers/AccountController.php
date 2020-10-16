<?php

namespace App\Http\Controllers;

use JWTAuth;
use Auth;
use App\Models\MUser;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\AccountRequest;
use Illuminate\Http\Response;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;
use Laravel\Passport\HasApiTokens;
use DB;
/**
 * AccountController
 * POSnistへログインを行う。
 * @author IVS
 * @since 09/2020
 */
class AccountController extends Controller
{

    public $loginAfterSignUp = true;

    /*
    * Register
    * アカウント登録する。
    * @param AccountRequest $request
    * @return response json
    */
    public function Register(AccountRequest $request)
    {      
        $users = new MUser;
        $users->company_id = $request->company_id;
        $users->shop_id = $request->shop_id;
        $users->name = $request->name;
        $users->email = $request->email;
        $users->login_id = $request->login_id;
        $users->password = bcrypt($request->password);
        $users->save();
        return response()->json($users);
    }
    /*
    * Update
    * アカウント登録する。
    * @param AccountRequest $request
    * @param $id
    * @return response json
    */
    public function Update(Request $request, $id)
    {
        $users = MUser::Find($id);
        $users->name = $request->name;
        $users->company_id = $request->company_id;
        $users->shop_id = $request->shop_id;
        $users->email = $request->email;
        $users->login_id = $request->login_id;
        $users->password = bcrypt($request->password);
        $users->update();
        return response()->json(['更新成功' => $users]);
    }

    /*
    * Login
    * POSnistへログインを行う。
    * @param AccountRequest $request
    * @param $id
    * @return response json
    */
    public function Login(Request $request)
    {
        $input = $request->only('email', 'password');
        $token = null;
        if (!$token = JWTAuth::attempt($input)) {
            return response()->json([
                'message' => 'メールアドレスまたはパスワードが間違っています',
                'errors' => [
                   [
                      'field' => 'email',
                      'code' => '40101'
                   ]
                ]
            ], 401);
        } 
        return response()->json([
            'status' => true,
            'message' => '正常にログイン',
            'token' => $token,
        ]);
    }

    /**
     * ログインユーザーを取得
     * @param Request $request
     * @return response
     */
    public function User(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            return response($user, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_BAD_REQUEST);
    }

     /**
     * ユーザーを削除
     * @param Request $id
     * @return response json
     */
    public function Delete($id)
    {
        $user = MUser::find($id);
        $user->delete();
        return response()->json('成功を削除');
    }

    /**
     * ログアウト
     * @param Request  $request
     * @return response json
     */
    public function Logout(Request $request)
    {
        $token = $request->header('Authorization');

        try {
            JWTAuth::parseToken()->invalidate($token);

            return response()->json([
                'message' => 'アクセス権なし',
                'errors' => [
                    [
                        'field' => 'password_logout',
                        'code' => '40301'
                    ]
                ]
            ], 400);
        } catch (TokenExpiredException $exception) {
            return response()->json([
                'error'   => true,
                'message' => trans('auth.token.expired')

            ], 401);
        } catch (TokenInvalidException $exception) {
            return response()->json([
                'error'   => true,
                'message' => trans('auth.token.invalid')
            ], 401);
        } catch (JWTException $exception) {
            return response()->json([
                'error'   => true,
                'message' => trans('auth.token.missing')
            ], 500);
        }
    }
    use ResetsPasswords {
        resetPassword as protected resetUserPassword;
    }

    public function ForgetPassword(request $request)
    {
        $user = Auth::user();
        if ($user) {

            $user->password = bcrypt($request->password);
            $user->update();
            return response()->json([
                'パスワードは正常に変更されました',
            ]);
        }
    }

    protected function sendResetResponse($response)
    {
        return response()->json(['success' => trans($response)]);
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        return response()->json(['error' => trans($response)], 401);
    }
}
