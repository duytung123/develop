<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mshop;
use App\Models\MShopPayment;
use DB;
use Auth;
use App\Models\MUser;
use App\Http\Requests\ShopPaymentsRequest;
use Illuminate\Support\Facades\Validator;
use illuminate\database\eloquent\modelnotfoundexception as modelnotfoundexception;

/**
 * ShopPaymentsController
 * @author IVS
 * @since 10/2020
 */
class ShopPaymentsController extends Controller
{
    /**
     * get shop_payment list
     * 店舗支払方法情報一覧を登録する。
     * @param Request $request
     * @return response
     */
    
    public function getShopPayments(Request $request)
    {
        $user = Auth::user();
        $shop_payment = DB::table('m_shops_payments')
            ->leftJoin("m_shops","m_shops.id", "=", "m_shops_payments.shop_id")       
            ->where('m_shops.id', $user->shop_id)->whereNull('m_shops_payments.deleted_at')
            ->select('m_shops_payments.*')            
            ->get();
        if ($shop_payment->count() > 0) {
            return response()->json($shop_payment, 200)->header('content-type', 'application/json');
        } else {
            return response()->json([], 200)->header('content-type', 'application/json');
        }
    }
    /**
    * create shop_payment
    * 店舗支払方法情報を登録する。
    * @param ShopPaymentsRequest $request
    * @return response json
    */
    public function createShopPayment(ShopPaymentsRequest $request)
    {
        try {
            return DB::connection()->transaction(function () use ($request) {
                $shop_payment = new MShopPayment();
                $shop_payment->shop_id = $request->shop_id;
                $shop_payment->name = $request->name;
                $shop_payment->sort = $request->sort;
                if ($shop_payment->save()) {
                    return response()->json($shop_payment, 200)->header('content-type', 'application/json');
                } else {
                    return response()->json([
                    'message' => 'JSON形式不正',
                    'errors' => [
                        [
                            'field' => 'stringまたはint',
                            'code' => '40002'
                        ]
                    ]
                ], 400);
                }
            });
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
     /**
     * get shop_payment By Id
     * パラメータのpaymetIdの店舗支払方法情報を取得する。
     * @param $shop_id, $shop_payment_id
     * @return response json
     */
    public function getShopPayment($shop_id, $shop_payment_id)
    {
        try {
            return DB::transaction(function () use ($shop_payment_id) {
                $user = Auth::user();
                $shop_payment= DB::table('m_shops_payments')
                ->leftJoin("m_shops","m_shops.id", "=", "m_shops_payments.shop_id") 
                ->where('m_shops.id', $user->shop_id)
                ->where('m_shops_payments.id', $shop_payment_id)->whereNull('m_shops_payments.deleted_at')
                ->select('m_shops_payments.*')
                ->get();
                if ($shop_payment->count()>0) {
                    return response()->json($shop_payment, 200)->header('content-type', 'application/json');
                } else {
                    return response()->json([
                'message' => '有効な値でない',
                'errors' => [
                    [
                        'field' => 'id',
                        'code' => '40006'
                    ]
                ]
            ], 400);
                }
            });
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }    
    /**
     * update shop_payment
     * パラメータのpaymentIdの店舗支払方法情報を更新する。
     * @param ShopPaymentsRequest $request, $shop_id, $shop_payment_id
     * @return response json
     */
    public function updateShopPayment(ShopPaymentsRequest $request, $shop_id, $shop_payment_id)
    {
        try {
            return DB::transaction(function () use ($request, $shop_payment_id) {
                $shop_payment = MShopPayment::find($shop_payment_id);
                if (is_null($shop_payment)) {
                    return response()->json([
                'message' => '有効な値でない',
                'errors' => [
                    [
                        'field' => 'id',
                        'code' => '40006'
                    ]
                ]
            ], 400);
                }
                if ($shop_payment->updated_at == $request->updated_at) {
                    $shop_payment->shop_id = $request->shop_id;
                    $shop_payment->name = $request->name;
                    $shop_payment->sort = $request->sort;
                    $shop_payment->save();
                    return response()->json($shop_payment);
                } else {
                    return response()->json([
                "message" => "同時更新エラー",
                'errors' => [
                  [
                     'field' => 'update_at',
                     'code' => '50102'
                  ]
              ]
              ], 400)->header('Content-Type', 'application/json');
                }
            });
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }    
    /**
     * delete shop_payment
     * パラメータのpaymentIdの店舗支払方法情報を削除する。
     * @param $shop_id, $items_id
     * @return response
     */
    public function deleteShopPayment($shop_id, $shop_payment_id)
    {
        try {
            return DB::transaction(function () use ($shop_payment_id) {
                if ($shop_payment = MShopPayment::find($shop_payment_id)) {
                    $shop_payment->delete();
                    return response()->json([
                "message" => "OK"
            ], 200);
                } else {
                    return response()->json([
                'message' => '有効な値でない',
                'errors' => [
                    [
                        'field' => 'id',
                        'code' => '40006'
                    ]
                ]
            ], 400);
                }
            });
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
   
}
