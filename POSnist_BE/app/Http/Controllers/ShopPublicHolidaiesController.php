<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MShopPublicHolidaies;
use App\Http\Requests\ShopPublicHolidaiesRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\MUser;
use Illuminate\Support\Facades\Config;
use Auth;
use DB;
/**
 * ShopPublicHolidaiesController
 * @author IVS
 * @since 10/2020
 */
class ShopPublicHolidaiesController extends Controller
{
   /**
    * create shop_holidaies
    * 店舗祝日設定を登録する。
    * @param ShopPublicHolidaiesRequest $request
    * @return response json
    */
    public function createShopPublicHoliday(ShopPublicHolidaiesRequest $request)
    {
        try {
            return DB::connection()->transaction(function () use ($request) {
                $user = Auth::user();
                $shop_public_holidaies = new MShopPublicHolidaies();
                $shop_public_holidaies->shop_id = $user->shop_id;
                $shop_public_holidaies->date = $request->date;
                if ($shop_public_holidaies->save()) {
                    return response()->json($shop_public_holidaies, Config::get('ponist.status.OK'))->header('content-type', Config::get('ponist.header.CONTENT_APPLICATION'));
                } else {
                    return response()->json([
                    'message' => Config::get('ponist.notification.MESSAGE40001'),
                    'errors' => [
                        [
                            'field' => Config::get('ponist.notification.FIELD_ID'),
                            'code' => Config::get('ponist.notification.CODE40001')
                        ]
                    ]
                ], Config::get('ponist.status.BAD_REQUEST'));
                }
            });
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    /**
     * Get shop_holidaies
     * パラメータのshopIdの店舗祝日設定を取得する。
     * @param  $shop_public_holidaies_id
     * @return response
     */
    public function getShopPublicHoliday($shop_public_holidaies_id)
    {
        try {
            return DB::transaction(function () use ($shop_public_holidaies_id) {
                $user = Auth::user();
                $shop_public_holidaies = DB::table('m_shop_public_holidaies')
                ->leftjoin('m_shops', 'm_shop_public_holidaies.shop_id', '=', 'm_shops.id')
                ->where('m_shops.id', $user->shop_id)
                ->where('m_shop_public_holidaies.id', $shop_public_holidaies_id)->whereNull('m_shop_public_holidaies.deleted_at')
                ->select(
                    'm_shop_public_holidaies.id',
                    'm_shop_public_holidaies.shop_id',
                    'm_shop_public_holidaies.date',
                    'm_shop_public_holidaies.updated_at',
                )
                ->get();
                if ($shop_public_holidaies->count() > 0) {
                    return response()->json($shop_public_holidaies, Config::get('ponist.status.OK'))->header('content-type', Config::get('ponist.header.CONTENT_APPLICATION'));
                } else {
                    return response()->json([
                        'message' => Config::get('ponist.notification.MESSAGE40006'),
                        'errors' => [
                            [
                                'field' => Config::get('ponist.notification.FIELD_ID'),
                                'code' => Config::get('ponist.notification.CODE40006')
                            ]
                        ]
                    ], Config::get('ponist.status.BAD_REQUEST'));
                }
            });
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    /**
     * update_shop_holiday
     * パラメータのshopIdの店舗祝日設定を更新する。
     * @param ShopPublicHolidaiesRequest $request, $shop_public_holidaies_id
     * @return response json
     */
    public function updateShopPublicHoliday(ShopPublicHolidaiesRequest $request, $shop_public_holidaies_id)
    {
        try {
            return DB::connection()->transaction(function () use ($request,$shop_public_holidaies_id) {
                $shop_public_holidaies = MShopPublicHolidaies::find($shop_public_holidaies_id);
                if (is_null($shop_public_holidaies)) {
                    return response()->json([
                'message' => Config::get('ponist.notification.MESSAGE40006'),
                'errors' => [
                    [
                        'field' => Config::get('ponist.notification.FIELD_ID'),
                        'code' => Config::get('ponist.notification.CODE40006')
                    ]
                ]
            ], Config::get('ponist.status.BAD_REQUEST'));
                }

                if ($shop_public_holidaies->updated_at == $request->updated_at) {
                    $shop_public_holidaies->shop_id = $request->shop_id;
                    $shop_public_holidaies->date = $request->date;
                    $shop_public_holidaies->save();
                    return response()->json($shop_public_holidaies);
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
     * delete_shop_holiday
     * パラメータのshopIdの店舗祝日設定を削除する。
     * @param  Request $request,$shop_public_holidaies_id
     * @return response
     */
    public function deleteShopPublicHoliday(Request $request, $shop_public_holidaies_id)
    {
        try {
            return DB::connection()->transaction(function () use ($request,$shop_public_holidaies_id) {
                if ($shop_public_holidaies = MShopPublicHolidaies::find($shop_public_holidaies_id)) {
                    $shop_public_holidaies->delete();
                    return response()->json([
                "message" => "OK"
            ], Config::get('ponist.status.NO-CONTENT'));
                } else {
                    return response()->json([
                'message' => Config::get('ponist.notification.MESSAGE40006'),
                'errors' => [
                    [
                        'field' => Config::get('ponist.notification.FIELD_ID'),
                        'code' => Config::get('ponist.notification.CODE40006')
                    ]
                ]
            ], Config::get('ponist.status.BAD_REQUEST'));
                }
            });
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }  
}
