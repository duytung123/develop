<?php
namespace App\Http\Controllers\Customer;

use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\MCustomer;
use File;
use Image;
use Config;
use JWTAuth;
use Auth;
use DB;

class CustomerController extends Controller
{
    public function __construct()
    {
        Config::set('jwt.user', MCustomer::class);
        Config::set('auth.providers', ['users' => ['driver' => 'eloquent', 'model' => MCustomer::class , ]]);
    }
    public function Register(Request $request)
    {
        $customer = new MCustomer();
        $customer->shop_id = $request->shop_id;
        $customer->customer_no = "01";
        $customer->firstname = $request->firstname;
        $customer->lastname = $request->lastname;
        $customer->firstname_kana = $request->firstname_kana;
        $customer->lastname_kana = $request->lastname_kana;
        $customer->sex = $request->sex;
        $customer->email = $request->email;
        $customer->tel = $request->tel;
        $customer->login_id = $request->login_id;
        $customer->password = bcrypt($request->password);
        $customer->staff_id = $request->staff_id;
        $customer->member_flg = $request->member_flg;
        $customer->customer_img = $request->customer_img;
        // upload image-------
        $oldPath = $request->customer_img;
        $namefile = strstr($oldPath, "/");
        $newPath = 'upload/customer' . $namefile;
        $pathThumbnail = 'upload/thumbnail/customer' . $namefile;
        File::move($oldPath, $newPath);
        File::copy($newPath, $pathThumbnail);
        $img = Image::make($pathThumbnail)->resize(Config::get('ponist.thumbnail.width') , Config::get('ponist.thumbnail.hight') , function ($constraint)
        {
            $constraint->aspectRatio();
        });
        $img->save($pathThumbnail);
        //--------------------
        $customer->customer_img = $newPath;
        $customer->postal_cd = $request->postal_cd;
        $customer->prefecture = $request->prefecture;
        $customer->city = $request->city;
        $customer->area = $request->area;
        $customer->address = $request->address;
        $customer->language = $request->language;
        $customer->visit_cnt = $request->visit_cnt;
        $customer->first_visit = $request->first_visit;
        $customer->last_visit = $request->last_visit;
        $customer->save();
        return response()
            ->json([$customer], Config::get('ponist.status.OK'));
    }
    public function Login(Request $request)
    {
        $input = $request->only('email', 'password');
        $token = null;
        if (!$token = JWTAuth::attempt($input))
        {
            return response()->json(['message' => 'メールアドレスまたはパスワードが間違っています', 'errors' => [['field' => 'email', 'code' => '40101']]], Config::get('ponist.status.BAD_REQUEST'));
        }
        return response()
            ->json(['status' => true, 'message' => '正常にログイン', 'token' => $token, ]);
    }
    public function User(Request $request)
    {
        $user = JWTAuth::toUser($request->token);
        return response()
            ->json([$user], Config::get('ponist.status.OK'));
    }
    public function Logout(Request $request)
    {

        $token = $request->header('Authorization');

        try
        {
            JWTAuth::parseToken()
                ->invalidate($token);

            return response()->json(['message' => '正常なログアウト'], Config::get('ponist.status.OK'));
        }
        catch(TokenExpiredException $exception)
        {
            return response()->json(['error' => true, 'message' => trans('auth.token.expired')

            ], Config::get('ponist.status.BAD_REQUEST'));
        }
        catch(TokenInvalidException $exception)
        {
            return response()->json(['error' => true, 'message' => trans('auth.token.invalid') ], Config::get('ponist.status.BAD_REQUEST'));
        }
        catch(JWTException $exception)
        {
            return response()->json(['error' => true, 'message' => trans('auth.token.missing') ], Config::get('ponist.status.BAD_REQUEST'));
        }

    }
    public function Delete($id)
    {
        $customer = MCustomer::find($id);
        $customer->delete();
        return response()
            ->json('成功を削除', Config::get('ponist.status.NO-CONTENT'));
    }

    public function Update(Request $request, $id)
    {
        $customer = MCustomer::Find($id);
        if ($customer->updated_at == $request->updated_at)
        {
            if ($customer->customer_img != $request->customer_img)
            {
                // upload image-------
                $oldPath = $request->customer_img;
                $namefile = strstr($oldPath, "/");
                $newPath = 'upload/customer' . $namefile;
                $pathThumbnail = 'upload/thumbnail/customer' . $namefile;
                File::move($oldPath, $newPath);
                File::copy($newPath, $pathThumbnail);
                $img = Image::make($pathThumbnail)->resize(Config::get('ponist.thumbnail.width') , Config::get('ponist.thumbnail.hight') , function ($constraint)
                {
                    $constraint->aspectRatio();
                });
                $img->save($pathThumbnail);
                //--------------------
                $customer->customer_img = $newPath;
            }
            $customer->shop_id = $request->shop_id;
            $customer->customer_no = "01";
            $customer->firstname = $request->firstname;
            $customer->lastname = $request->lastname;
            $customer->firstname_kana = $request->firstname_kana;
            $customer->lastname_kana = $request->lastname_kana;
            $customer->sex = $request->sex;
            $customer->email = $request->email;
            $customer->tel = $request->tel;
            $customer->login_id = $request->login_id;
            $customer->password = bcrypt($request->password);
            $customer->staff_id = $request->staff_id;
            $customer->member_flg = $request->member_flg;
            $customer->postal_cd = $request->postal_cd;
            $customer->prefecture = $request->prefecture;
            $customer->city = $request->city;
            $customer->area = $request->area;
            $customer->address = $request->address;
            $customer->language = $request->language;
            $customer->visit_cnt = $request->visit_cnt;
            $customer->first_visit = $request->first_visit;
            $customer->last_visit = $request->last_visit;
            $customer->update();
            return response()
                ->json($customer);
        }
        else
        {
            return response()->json(["message" => Config::get('ponist.notification.EN') , 'errors' => [['field' => Config::get('ponist.notification.JSON') , 'code' => Config::get('ponist.notification.CODEINT') ]]], Config::get('ponist.status.BAD_REQUEST'))
                ->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
        }

    }

    use ResetsPasswords
    {
        resetPassword as protected resetUserPassword;
    }

    public function Password(request $request)
    {
        $customer = Auth::user();
        if ($customer)
        {

            $customer->password = bcrypt($request->password);
            $customer->update();
            return response()
                ->json('パスワードは正常に変更されました', Config::get('ponist.status.OK'));
        }
    }

    protected function sendResetResponse($response)
    {
        return response()->json(['success' => trans($response) ]);
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        return response()->json(['error' => trans($response) ], Config::get('ponist.status.BAD_REQUEST'));
    }

}

