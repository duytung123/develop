<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MShop;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ShopsRequest;
use App\Models\MUser;
use Illuminate\Support\Facades\Config;
use DB;
use Auth;

/**
 * ShopsController
 * @author IVS
 * @since 09/2020
 */
class ShopsController extends Controller
{

    /**
     * Create Shop
     * 店舗情報を登録する。
     * @param ShopRequest $request
     * @return response
     */
    public function createShop(ShopsRequest $request)
    {
        try {
            return DB::connection()->transaction(function () use($request) {
                $user = Auth::user();
                $m_shops = new MShop();
                $m_shops->name = $request->name;
                $m_shops->company_id= $user->company_id;
                $m_shops->postal_cd = $request->postal_cd;
                $m_shops->prefecture = $request->prefecture ;
                $m_shops->city = $request->city;
                $m_shops->area = $request->area;
                $m_shops->address = $request->address;
                $m_shops->tel = $request->tel;
                $m_shops->email = $request->email;
                $m_shops->opening_time = $request->opening_time;
                $m_shops->closing_time = $request->closing_time;
                $m_shops->time_break = $request->time_break;
                $m_shops->facility = $request->facility;
                $m_shops->language = '001';
                if ($m_shops->save()) {
                    return response()->json($m_shops, Config::get('ponist.status.OK'))->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
                } else {
                    return response()->json([
                            'message' => Config::get('ponist.notification.MESSAGE40001'),
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
     * Get Shop
     * パラメータのshopIdの店舗情報を取得する。
     * @param $id
     * @return response
     */
    public function getShop($shop_id)
    {
        $user = Auth::user();
        if (MShop::where('id', $shop_id)->exists()) {
            $m_shops = DB::table('m_shops') ->where('m_shops.id', $shop_id)
            ->select(
                'm_shops.company_id',
                'm_shops.name',
                'm_shops.postal_cd',
                'm_shops.prefecture',
                'm_shops.city',
                'm_shops.area',
                'm_shops.address',
                'm_shops.tel',
                'm_shops.email',
                'm_shops.opening_time',
                'm_shops.closing_time',
                'm_shops.time_break',
                'm_shops.facility',
                'm_shops.language',
                'm_shops.updated_at'
            )->get();
            return response()->json($m_shops, Config::get('ponist.status.OK'));
        } else {
            return response()->json([
              'message' => Config::get('ponist.notification.MESSAGE40006'),
              'errors' => [
                [
                   'field' => Config::get('ponist.notification.FIELD_ID'),
                   'code' => Config::get('ponist.notification.CODE40006')
                ]
            ]
            ], Config::get('ponist.status.BAD_REQUEST'))->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
        }
    }
    /**
     * Delete Shop
     * パラメータのshopIdの店舗情報を削除する。
     * @param $Shop_id
     * @return response
     */
    public function deleteShop($Shop_id)
    {
        try {
            return DB::connection()->transaction(function () use($Shop_id) {
                if (MShop::where('id', $Shop_id)->exists()) {
                    $m_shops = MShop::find($Shop_id);
                    if ($m_shops->delete_at == null) {
                        $m_shops->delete();
                        return response()->json([
                            'message' => "OK"
                          ], Config::get('ponist.status.NO-CONTENT'));
                    }
                } else {
                    return response()->json([
                'message' => Config::get('ponist.notification.MESSAGE40006'),
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
     * Update Shop
     * パラメータのshopIdの店舗情報を更新する。
     * @param $Shop_id, ShopsRequest $request
     * @return response
     */
    public function updateShop(ShopsRequest $request, $Shop_id)
    {
        try {
            return DB::connection()->transaction(function () use($request,$Shop_id) {
                $m_shops = MShop::find($Shop_id);
                if (is_null($Shop_id)) {
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

                if ($m_shops->updated_at == $request->updated_at) {
                    $m_shops->name = $request->name;
                    $m_shops->postal_cd = $request->postal_cd;
                    $m_shops->prefecture = $request->prefecture ;
                    $m_shops->city = $request->city;
                    $m_shops->area = $request->area;
                    $m_shops->address = $request->address;
                    $m_shops->tel = $request->tel;
                    $m_shops->email = $request->email;
                    $m_shops->opening_time = $request->opening_time;
                    $m_shops->closing_time = $request->closing_time;
                    $m_shops->time_break = $request->time_break;
                    $m_shops->facility = $request->facility;
                    $m_shops->save();
                    return response()->json($m_shops);
                } else {
                    return response()->json([
                "message" => Config::get('ponist.notification.MESSAGE50102'),
                'errors' => [
                  [
                     'field' => Config::get('ponist.notification.FIELD50102'),
                     'code' => Config::get('ponist.notification.CODE50102')
                  ]
              ]
              ],Config::get('ponist.status.BAD_REQUEST'))->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
                }
            });
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
