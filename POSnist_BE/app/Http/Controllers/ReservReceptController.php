<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MReservRecept;
use Illuminate\Support\Facades\Validator;
use App\Models\MUser;
use Illuminate\Support\Facades\Config;
use App\Http\Requests\ReservReceptRequest;
use DB;
use Auth;

/**
 * ReservationController
 * @author IVS
 * @since 7/10/2020
 */
class ReservReceptController extends Controller
{
    /**
     * createReservrecept
     * 予約受付設定を登録する。
     * @param Request $request
     * @return response
     */
    public function createReservRecept(ReservReceptRequest $request)
    {
        try {
            return DB::connection()->transaction(function () use ($request) {
                $user = Auth::user();
                $reserv_recepts = new MReservRecept();
                $reserv_recepts->shop_id = $user->shop_id;
                $reserv_recepts->reserv_interval= $request->reserv_interval ;
                $reserv_recepts->recept_rest = $request->recept_rest;
                $reserv_recepts->recept_amount = $request->recept_amount;
                $reserv_recepts->cancel_setting_flg = $request->cancel_setting_flg;
                $reserv_recepts->cancel_limit = $request->cancel_limit;
                $reserv_recepts->future_reserv_num = $request->future_reserv_num;
                $reserv_recepts->cancel_wait_flg = $request->cancel_wait_flg;
                if ($reserv_recepts->save()) {
                    return response()->json($reserv_recepts, Config::get('ponist.status.OK'))->header('content-type', Config::get('ponist.header.CONTENT_APPLICATION'));
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
     * getReservrecept
     * パラメータのreserv_receptIdの予約受付設定を取得する。
     * @param Request $shop_id, $reservrecepts_id
     * @return response
     */
    public function getReservRecept($shop_id, $reservrecepts_id)
    {
        $user = Auth::user();
        $reserv_recepts= DB::table('m_reserv_recepts')
                ->leftJoin("m_shops", "m_shops.id", "=", "m_reserv_recepts.shop_id")
                ->where('m_shops.id', $user->shop_id)
                ->where('m_reserv_recepts.id', $reservrecepts_id)->whereNull('m_reserv_recepts.deleted_at')
                ->select(
                    'm_reserv_recepts.id',
                    'm_reserv_recepts.shop_id',
                    'm_reserv_recepts.reserv_interval',
                    'm_reserv_recepts.recept_rest',
                    'm_reserv_recepts.recept_amount',
                    'm_reserv_recepts.cancel_setting_flg',
                    'm_reserv_recepts.cancel_limit',
                    'm_reserv_recepts.future_reserv_num',
                    'm_reserv_recepts.cancel_wait_flg',
                    'm_reserv_recepts.updated_at'
                )
                ->get();
        if ($reserv_recepts->count()>0) {
            return response()->json($reserv_recepts, Config::get('ponist.status.OK'))->header('content-type', Config::get('ponist.header.CONTENT_APPLICATION'));
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
    }
    
    /**
     * deleteReservrecept
     * パラメータのreserv_receptIdの予約受付設定を削除する。
     * @param $shop_id, $reservrecepts_id
     * @return response
     */
    public function deleteReservRecept($shop_id, $reservrecepts_id)
    {
        try {
            return DB::transaction(function () use ($reservrecepts_id) {
                if ($reserv_recepts=MReservRecept::find($reservrecepts_id)) {
                    $reserv_recepts->delete();
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
     * updateReservrecept
     * パラメータのreserv_receptIdの予約受付設定を更新する。
     * @param ItemsRequest $Shopid $reservrecepts_id
     * @return response json
     */
    public function updateReservRecept(ReservReceptRequest $request, $shop_id, $reservrecepts_id)
    {
        try {
            return DB::transaction(function () use ($request, $reservrecepts_id) {
                $reserv_recepts = MReservRecept::find($reservrecepts_id);
                if (is_null($reserv_recepts)) {
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
                if ($reserv_recepts->updated_at == $request->updated_at) {
                    $reserv_recepts->shop_id = $request->shop_id;
                    $reserv_recepts->reserv_interval= $request->reserv_interval ;
                    $reserv_recepts->recept_rest = $request->recept_rest;
                    $reserv_recepts->recept_amount = $request->recept_amount;
                    $reserv_recepts->cancel_setting_flg = $request->cancel_setting_flg;
                    $reserv_recepts->cancel_limit = $request->cancel_limit;
                    $reserv_recepts->future_reserv_num = $request->future_reserv_num;
                    $reserv_recepts->cancel_wait_flg = $request->cancel_wait_flg;
                    $reserv_recepts->save();
                    return response()->json($reserv_recepts);
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