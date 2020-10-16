<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MShopterm;
use Illuminate\Support\Facades\Validator;
use App\Models\MUser;
use App\Http\Requests\ShoptermRequest;
use Illuminate\Support\Facades\Config;
use DB;
use Auth;

/**
 * ShoptermsController
 * @author IVS
 * @since 7/10/2020
 */
class ShoptermsController extends Controller
{
    /**
    * createShopterm
    * 規約・プライバシーポリシー設定を登録する。
    * @param ItemsRequest $request
    * @return response json
    */
    public function createShopterm(ShoptermRequest $request)
    {
        try {
            return DB::connection()->transaction(function () use ($request) {
                $user = Auth::user();
                $shopterms = new MShopterm();
                $shopterms->shop_id = $user->shop_id;
                $shopterms->terms = $request->terms ;
                $shopterms->privacy_policy = $request->privacy_policy;
                if ($shopterms->save()) {
                    return response()->json($shopterms, Config::get('ponist.status.OK'))->header('content-type', Config::get('ponist.header.CONTENT_APPLICATION'));
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
    * getShopterm
    * パラメータのshopIdの規約・プライバシーポリシー設定を取得する。
    * @param $shop_id, $shopterms_id
    * @return response json
    */
    public function getShopterm($shop_id, $shopterms_id)
    {
        try {
            return DB::transaction(function () use ($shopterms_id) {
                $user = Auth::user();
                $shopterms= DB::table('m_shopterms')
                ->leftJoin("m_shops", "m_shops.id", "=", "m_shopterms.shop_id")
                ->where('m_shops.id', $user->shop_id)
                ->where('m_shopterms.id', $shopterms_id)->whereNull('m_shopterms.deleted_at')
                ->select(
                    'm_shopterms.id',
                    'm_shopterms.shop_id',
                    'm_shopterms.terms',
                    'm_shopterms.privacy_policy',
                    'm_shopterms.updated_at'
                )
                ->get();
                if ($shopterms->count()>0) {
                    return response()->json($shopterms, Config::get('ponist.status.OK'))->header('content-type', Config::get('ponist.header.CONTENT_APPLICATION'));
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
     * deleteShopterm
     * パラメータのshopIdの規約・プライバシーポリシー設定を削除する。
     * @param $shop_id, $MShopterm
     * @return response
     */
    public function deleteShopterm($shop_id, $MShopterm)
    {
        try {
            return DB::transaction(function () use ($MShopterm) {
                if ($shopterms=MShopterm::find($MShopterm)) {
                    $shopterms->delete();
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
    /**
     * updateShopterm
     * パラメータのshopIdの規約・プライバシーポリシー設定を更新する。
     * @param ItemsRequest $Shopid $MShopterm
     * @return response json
     */
    public function updateShopterm(ShoptermRequest $request, $shop_id, $MShopterm)
    {
        try {
            return DB::transaction(function () use ($request, $MShopterm) {
                $shopterms = MShopterm::find($MShopterm);
                if (is_null($shopterms)) {
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
                if ($shopterms->updated_at == $request->updated_at) {
                    $shopterms->shop_id = $request->shop_id;
                    $shopterms->terms= $request->terms ;
                    $shopterms->privacy_policy = $request->privacy_policy;
                    $shopterms->save();
                    return response()->json($shopterms);
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
}
