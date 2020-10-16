<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MShopHolidaies;
use Illuminate\Support\Facades\Validator;
use App\Models\MUser;
use Illuminate\Support\Facades\Config;
use Auth;
use DB;

/**
 * ShopHolidaiesController
 * @author IVS
 * @since 10/2020
 */
class ShopHolidaiesController extends Controller
{
    /**
    * create shop_holidaies
    * 店舗定休日を登録する。
    * @param Request $request
    * @return response json
    */
    public function createShopHoliday(Request $request)
    {
        try {
            return DB::connection()->transaction(function () use ($request) {
                $user = Auth::user();
                $shop_holidaies = new MShopHolidaies();
                $shop_holidaies->shop_id = $user->shop_id;
                $shop_holidaies->holiday_type =$request->holiday_type;
                $shop_holidaies->day = $request->day;
                $shop_holidaies->monday = $request->monday;
                $shop_holidaies->tuesday = $request->tuesday;
                $shop_holidaies->wednesday = $request->wednesday;
                $shop_holidaies->thursday = $request->thursday;
                $shop_holidaies->friday = $request->friday;
                $shop_holidaies->saturday = $request->saturday;
                $shop_holidaies->sunday = $request->sunday;
                if ($shop_holidaies->save()) {
                    return response()->json($shop_holidaies, Config::get('ponist.status.OK'))->header('content-type', Config::get('ponist.header.CONTENT_APPLICATION'));
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
     *  Get shop_holidaies
     *パラメータのshopIdの店舗定休日を取得する。
     * @param  $shop_holidaies_id
     * @return response
     */
    public function getShopHoliday($shop_holidaies_id)
    {
        try {
            return DB::transaction(function () use ($shop_holidaies_id) {
                $user = Auth::user();
                $shop_holidaies = DB::table('m_shop_holidaies')
                ->leftjoin('m_shops', 'm_shop_holidaies.shop_id', '=', 'm_shops.id')
                ->where('m_shops.id', $user->shop_id)
                ->where('m_shop_holidaies.id', $shop_holidaies_id)->whereNull('m_shop_holidaies.deleted_at')
                ->select(
                    'm_shop_holidaies.id',
                    'm_shop_holidaies.shop_id',
                    'm_shop_holidaies.holiday_type',
                    'm_shop_holidaies.day',
                    'm_shop_holidaies.monday',
                    'm_shop_holidaies.tuesday',
                    'm_shop_holidaies.wednesday',
                    'm_shop_holidaies.thursday',
                    'm_shop_holidaies.friday',
                    'm_shop_holidaies.saturday',
                    'm_shop_holidaies.sunday',
                    'm_shop_holidaies.updated_at'
                )
                ->get();
                if ($shop_holidaies->count() > 0) {
                    return response()->json($shop_holidaies, Config::get('ponist.status.OK'))->header('content-type', Config::get('ponist.header.CONTENT_APPLICATION'));
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
     * パラメータのshopIdの店舗定休日を更新する。
     * @param Request $request, shop_holidaies_id
     * @return response json
     */
    public function updateShopHoliday(Request $request, $shop_holidaies_id)
    {
        
        try {
            return DB::connection()->transaction(function () use ($request,$shop_holidaies_id) {
                $shop_holidaies = MShopHolidaies::find($shop_holidaies_id);
                if (is_null($shop_holidaies)) {
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
                if ($shop_holidaies->updated_at == $request->updated_at) {
                    $shop_holidaies->shop_id = $request->shop_id;
                    $shop_holidaies->holiday_type =$request->holiday_type;
                    $shop_holidaies->day = $request->day;
                    $shop_holidaies->monday = $request->monday;
                    $shop_holidaies->tuesday = $request->tuesday;
                    $shop_holidaies->wednesday = $request->wednesday;
                    $shop_holidaies->thursday = $request->thursday;
                    $shop_holidaies->friday = $request->friday;
                    $shop_holidaies->saturday = $request->saturday;
                    $shop_holidaies->sunday = $request->sunday;
                    $shop_holidaies->save();
                    return response()->json($shop_holidaies);
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
     * パラメータのshopIdの店舗定休日を削除する。
     * @param  Request $request,$shop_holidaies_id
     * @return response
     */
    public function deleteShopHoliday(Request $request, $shop_holidaies_id)
    {
        try {
            return DB::connection()->transaction(function () use ($request,$shop_holidaies_id) {
                if ($shop_holidaies = MShopHolidaies::find($shop_holidaies_id)) {
                    $shop_holidaies->delete();
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
