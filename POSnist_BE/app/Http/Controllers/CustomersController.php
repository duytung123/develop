<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\MShop;
use App\Models\MCustomer;
use App\Http\Requests\CustomersRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use DB;
use Auth;
use Image;
use File;

/**
 * ItemsController
 * @author IVS
 * @since 28/09/2020
 */
class CustomersController extends Controller
{
    /**
     * get customer List
     * 顧客一覧を取得する。
     * @param Request $request
     * @return response
     */
    public function getCustomerList(Request $request)
    {
        $user = Auth::user();
        $customer = MCustomer::where('shop_id', $user->shop_id)
           ->where('firstname', 'like', "%$request->firstname%")
            ->where('lastname', 'like', "%$request->lastname%")
            ->where('firstname_kana', 'like', "%$request->firstname_kana%")
            ->where('lastname_kana', 'like', "%$request->lastname_kana%")
            ->where('customer_no', 'like', "%$request->customer_no%")
            ->where('staff_id', 'like', "%$request->staff_id%")
            ->where('tel', 'like', "%$request->tel%")
            ->where('member_flg', 'like', "%$request->member_flg%")
            ->select(
                'm_customers.id',
                'm_customers.shop_id',
                'm_customers.customer_no',
                'm_customers.firstname',
                'm_customers.lastname',
                'm_customers.firstname_kana',
                'm_customers.lastname_kana',
                'm_customers.sex',
                'm_customers.email',
                'm_customers.tel',
                'm_customers.login_id',
                'm_customers.password',
                'm_customers.staff_id',
                'm_customers.member_flg',
                'm_customers.customer_img',
                'm_customers.postal_cd',
                'm_customers.prefecture',
                'm_customers.city',
                'm_customers.area',
                'm_customers.address',
                'm_customers.language',
                'm_customers.visit_cnt',
                'm_customers.first_visit',
                'm_customers.last_visit',
                'm_customers.updated_at'
            )
             ->get();
        if ($customer->count() > 0) {
            foreach ($customer as $key => $item) {
                $item->customer_img = Config::get('ponist.baseurl') . $item->customer_img;
            }
             return response()->json($customer, Config::get('ponist.status.OK'))->header('content-type', Config::get('ponist.header.CONTENT_APPLICATION'));
        }  else
        {
            return response()->json([], Config::get('ponist.status.OK'))->header('content-type',Config::get('ponist.header.CONTENT_APPLICATION'));
        }
    }

    // /**
    // * create customer
    // * 顧客情報を登録する。
    // * @param CustomerRequest $request
    // * @return response json
    // */
    public function createCustomer(CustomersRequest $request)
    {
        try {
        return DB::transaction(function () use ($request) {
            $user = Auth::user();
            $customer = new MCustomer();
            $customer->shop_id = $user->shop_id;
            $customer->customer_no = Config::get('ponist.CUSTOMER_NO');
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
            // upload image-------
            $oldPath = $request->customer_img;
            $namefile = strstr($oldPath,"/");
            $newPath = 'upload/customer'.$namefile;
            $pathThumbnail = 'upload/thumbnail/customer'.$namefile;
            File::move( $oldPath, $newPath);
            File::copy($newPath,$pathThumbnail);
            $img = Image::make($pathThumbnail)->resize(Config::get('ponist.thumbnail.width'),Config::get('ponist.thumbnail.hight'), function ($constraint) {
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
            if ($customer->save()) {
                return response()->json($customer, Config::get('ponist.status.OK'))->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
            } else {
                 return response()->json([
                        "message" => Config::get('ponist.notification.MESSAGE40001'),
                        'errors' => [
                        [
                            'field' => Config::get('ponist.notification.FIELD_ID'),
                            'code' => Config::get('ponist.notification.CODE40001')
                        ]
                    ]
                    ], Config::get('ponist.status.BAD_REQUEST'))->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
            }
            });
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * delete customer
     * パラメータのcustomer_idの顧客情報を削除する。
     * @param  $shop_id, $customer_id
     * @return response
     */
    public function deleteCustomer($shop_id, $customer_id)
    {
        try {
            return DB::transaction(function () use ($customer_id) {
                if (MCustomer::where('id', $customer_id)->exists()) {
                    $customer = MCustomer::find($customer_id);
                    $customer->delete();
                    return response()->json([
                      "message" => "OK"
                    ], Config::get('ponist.status.NO-CONTENT'));
                } else {
                   return response()->json([
                            "message" => Config::get('ponist.notification.MESSAGE40006'),
                            'errors' => [
                              [
                                 'field' => Config::get('ponist.notification.FIELD_ID'),
                                 'code' => Config::get('ponist.notification.CODE40006')
                              ]
                          ]
                          ], Config::get('ponist.status.BAD_REQUEST'))->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
                }
            });
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    /**
     * update customer
     * パラメータのcustomer_idの顧客情報を更新する。
     * @param CustomerRequest $request, $shop_id, $customer_id
     * @return response json
     */
    public function updateCustomer(CustomersRequest $request, $shop_id, $customer_id)
    {
        try {
            return DB::transaction(function () use ($request, $customer_id) {
            if (MCustomer::where('id', $customer_id)->exists()) {
                $customer = MCustomer::find($customer_id);
                if ($customer->updated_at == $request->updated_at) {
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
                    if ((Config::get('ponist.baseurl') . $customer->customer_img) != $request->customer_img)
                    {
                        // upload image-------
                        $oldPath = $request->customer_img;
                        $namefile = strstr($oldPath,"/");
                        $newPath = 'upload/customer'.$namefile;
                        $pathThumbnail = 'upload/thumbnail/customer'.$namefile;
                        File::move( $oldPath, $newPath);
                        File::copy($newPath,$pathThumbnail);
                        $img = Image::make($pathThumbnail)->resize(Config::get('ponist.thumbnail.width'),Config::get('ponist.thumbnail.hight'), function ($constraint) {
                        $constraint->aspectRatio();
                        });
                        $img->save($pathThumbnail);
                         //--------------------
                        $customer->customer_img = $newPath;
                    }
                    $customer->postal_cd = $request->postal_cd;
                    $customer->prefecture = $request->prefecture;
                    $customer->city = $request->city;
                    $customer->area = $request->area;
                    $customer->address = $request->address;
                    $customer->language = $request->language;
                    $customer->visit_cnt = $request->visit_cnt;
                    $customer->first_visit = $request->first_visit;
                    $customer->last_visit = $request->last_visit;
                    if ($customer->save()) {
                         return response()->json($customer, Config::get('ponist.status.OK'))->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
                    }
                } else {
                     return response()->json([
                            "message" => Config::get('ponist.notification.MESSAGE40006'),
                            'errors' => [
                            [
                                'field' => Config::get('ponist.notification.FIELD_ID'),
                                'code' => Config::get('ponist.notification.CODE40006')
                            ]
                        ]
                        ], Config::get('ponist.status.BAD_REQUEST'))->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
                }
            } else {
               return response()->json([
                        "message" => Config::get('ponist.notification.MESSAGE50102'),
                        'errors' => [
                        [
                            'field' => Config::get('ponist.notification.FIELD50102'),
                            'code' => Config::get('ponist.notification.CODE50102')
                        ]
                    ]
                    ], Config::get('ponist.status.BAD_REQUEST'))->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
            }
            });
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * get customer
     *パラメータのcustomer_idの顧客情報を取得する。
     * @param $shop_id, $customer_id
     * @return response json
     */
    public function getCustomer($shop_id, $customer_id)
    {
        try {
            return DB::transaction(function () use ($customer_id) {
         $user = Auth::user();
            if (MCustomer::where('id', $customer_id)->exists()) {
                $customer= DB::table('m_customers')
                    ->leftjoin('m_shops', 'm_customers.shop_id', '=', 'm_shops.id')
                    ->where('m_shops.id', $user->shop_id)
                    ->where('m_customers.id', $customer_id)
                    ->select(
                        'm_customers.id',
                        'm_customers.shop_id',
                        'm_customers.customer_no',
                        'm_customers.firstname',
                        'm_customers.lastname',
                        'm_customers.firstname_kana',
                        'm_customers.lastname_kana',
                        'm_customers.sex',
                        'm_customers.email',
                        'm_customers.tel',
                        'm_customers.login_id',
                        'm_customers.password',
                        'm_customers.staff_id',
                        'm_customers.member_flg',
                        'm_customers.customer_img',
                        'm_customers.postal_cd',
                        'm_customers.prefecture',
                        'm_customers.city',
                        'm_customers.area',
                        'm_customers.address',
                        'm_customers.language',
                        'm_customers.visit_cnt',
                        'm_customers.first_visit',
                        'm_customers.last_visit',
                        'm_customers.updated_at'
                    )
                ->get();
                if (count($customer) > 0) {
                    foreach ($customer as $key => $item) {
                        $item->customer_img = Config::get('ponist.baseurl') . $item->customer_img;
                    }
                }
                return response()->json($customer, Config::get('ponist.status.OK'))->header('content-type', Config::get('ponist.header.CONTENT_APPLICATION'));
            } else {
                return response()->json([
                            "message" => Config::get('ponist.notification.MESSAGE40006'),
                            'errors' => [
                            [
                                'field' => Config::get('ponist.notification.FIELD_ID'),
                                'code' => Config::get('ponist.notification.CODE40006')
                            ]
                        ]
                        ], Config::get('ponist.status.BAD_REQUEST'))->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
            }
        });
    } catch (Exception $e) {
        throw new Exception($e->getMessage());
    }
}
}
