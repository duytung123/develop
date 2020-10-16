<?php

namespace App\Http\Controllers;
use App\Http\Requests\ReservReceptTimeRequest;
use App\Models\MReservReceptTime;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Config;
use DB;
/**
 * ReservReceptTimeController
 * @author IVS
 * @since 07/10/2020
 */
class ReservReceptTimeController extends Controller
{
    /**
     * create reserv_recept_time
     * 予約受付時間設定情報を登録する。
     * @param ReservReceptTimeRequest $request
     * @return response json
     */
    public function createReservReceptTime(ReservReceptTimeRequest $request)
    {
        try {
        return DB::transaction(function () use ($request) {
            $user = Auth::user();
            $reservReceptTime = new MReservReceptTime();
            $reservReceptTime->shop_id = $user->shop_id;
            $reservReceptTime->recept_type = $request->recept_type;
            $reservReceptTime->recept_start = $request->recept_start;
            $reservReceptTime->recept_end = $request->recept_end;
            $reservReceptTime->recept_start_mo = $request->recept_start_mo;
            $reservReceptTime->recept_end_mo = $request->recept_end_mo;
            $reservReceptTime->recept_start_tu = $request->recept_start_tu;
            $reservReceptTime->recept_end_tu = $request->recept_end_tu;
            $reservReceptTime->recept_start_we = $request->recept_start_we;
            $reservReceptTime->recept_end_we = $request->recept_end_we;
            $reservReceptTime->recept_start_th = $request->recept_start_th;
            $reservReceptTime->recept_end_th = $request->recept_end_th;
            $reservReceptTime->recept_start_fr = $request->recept_start_fr;
            $reservReceptTime->recept_end_fr = $request->recept_end_fr;
            $reservReceptTime->recept_start_sa = $request->recept_start_sa;
            $reservReceptTime->recept_end_sa = $request->recept_end_sa;
            $reservReceptTime->recept_start_su = $request->recept_start_su;
            $reservReceptTime->recept_end_su = $request->recept_end_su;
            $reservReceptTime->recept_start_ho = $request->recept_start_ho;
            $reservReceptTime->recept_end_ho = $request->recept_end_ho;
    
            if ($reservReceptTime->save()) {
                return response()->json($reservReceptTime, Config::get('ponist.status.OK'))->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
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
    * get reserv_recept_time
    * パラメータのreserv_recept_timeIdの予約受付時間設定情報を取得する。
    * @param $shop_id, $reserv_recept_timeId
    * @return response json
    */ 
    public function getReservReceptTime($shop_id, $reserv_recept_timeId)
    {
            $user = Auth::user();
            if (MReservReceptTime::where('id', $reserv_recept_timeId)->exists()) {
                $reservReceptTime= DB::table('m_reserv_recept_times')
                ->leftJoin("m_shops","m_shops.id", "=", "m_reserv_recept_times.shop_id")
                    ->where('m_reserv_recept_times.shop_id', $user->shop_id)    
                    ->where('m_reserv_recept_times.id',  $reserv_recept_timeId)
                ->select(
                    "m_reserv_recept_times.id",
                    "m_reserv_recept_times.shop_id",
                    "m_reserv_recept_times.recept_type",
                    "m_reserv_recept_times.recept_start",
                    "m_reserv_recept_times.recept_end",
                    "m_reserv_recept_times.recept_start_mo",
                    "m_reserv_recept_times.recept_end_mo",
                    "m_reserv_recept_times.recept_start_tu",
                    "m_reserv_recept_times.recept_end_tu",
                    "m_reserv_recept_times.recept_start_we",
                    "m_reserv_recept_times.recept_end_we",
                    "m_reserv_recept_times.recept_start_th",
                    "m_reserv_recept_times.recept_end_th",
                    "m_reserv_recept_times.recept_start_fr",
                    "m_reserv_recept_times.recept_end_fr",
                    "m_reserv_recept_times.recept_start_sa",
                    "m_reserv_recept_times.recept_end_sa",
                    "m_reserv_recept_times.recept_start_su",
                    "m_reserv_recept_times.recept_end_su",
                    "m_reserv_recept_times.recept_start_ho",
                    "m_reserv_recept_times.recept_end_ho",
                    "m_reserv_recept_times.updated_at",
                    
                )
            ->get();
                return response()->json($reservReceptTime, Config::get('ponist.status.OK'))->header('content-type', Config::get('ponist.header.CONTENT_APPLICATION'));
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
        }

    /**
    * update reserv_recept_time
    * パラメータのreserv_recept_timeIdの予約受付時間設定情報を更新する。
    * @param ReservReceptTimeRequest $request, $shop_id, $reserv_recept_timeId
    * @return response json
    */ 
    public function updateReservReceptTime(ReservReceptTimeRequest $request, $shop_id, $reserv_recept_timeId)
    {
        try {
            return DB::transaction(function () use ($request, $reserv_recept_timeId) {
            if (MReservReceptTime::where('id', $reserv_recept_timeId)->exists()) {
                $reservReceptTime = MReservReceptTime::find($reserv_recept_timeId);
                $reservReceptTime->recept_type = $request->recept_type;
                $reservReceptTime->recept_start = $request->recept_start;
                $reservReceptTime->recept_end = $request->recept_end;
                $reservReceptTime->recept_start_mo = $request->recept_start_mo;
                $reservReceptTime->recept_end_mo = $request->recept_end_mo;
                $reservReceptTime->recept_start_tu = $request->recept_start_tu;
                $reservReceptTime->recept_end_tu = $request->recept_end_tu;
                $reservReceptTime->recept_start_we = $request->recept_start_we;
                $reservReceptTime->recept_end_we = $request->recept_end_we;
                $reservReceptTime->recept_start_th = $request->recept_start_th;
                $reservReceptTime->recept_end_th = $request->recept_end_th;
                $reservReceptTime->recept_start_fr = $request->recept_start_fr;
                $reservReceptTime->recept_end_fr = $request->recept_end_fr;
                $reservReceptTime->recept_start_sa = $request->recept_start_sa;
                $reservReceptTime->recept_end_sa = $request->recept_end_sa;
                $reservReceptTime->recept_start_su = $request->recept_start_su;
                $reservReceptTime->recept_end_su = $request->recept_end_su;
                $reservReceptTime->recept_start_ho = $request->recept_start_ho;
                $reservReceptTime->recept_end_ho = $request->recept_end_ho;
                if ($reservReceptTime->updated_at == $request->updated_at) {
                    if ($reservReceptTime->save()) {
                        return response()->json($reservReceptTime, Config::get('ponist.status.OK'))->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
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
    * delete reserv_recept_time
    * パラメータのreserv_recept_timeIdの予約受付時間設定情報を削除する。
    * @param $shop_id, $reserv_recept_timeId
    * @return response json
    */ 
    public function deleteReservReceptTime($shop_id, $reserv_recept_timeId)
    {
        try {
            return DB::transaction(function () use ($reserv_recept_timeId) {
                if (MReservReceptTime::where('id',$reserv_recept_timeId)->exists()) {
                    $reservReceptTime = MReservReceptTime::find($reserv_recept_timeId);
                    $reservReceptTime->delete();
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
    
}
