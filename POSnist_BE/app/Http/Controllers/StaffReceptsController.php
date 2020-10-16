<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\MStaff;
use App\Models\Mshop;
use App\Models\MStaffRecepts;
use Illuminate\Support\Facades\Config;
use DB;
use Auth;
use App\Models\MUser;
use App\Http\Requests\MStaffReceptsRequest;
use Illuminate\Support\Facades\Validator;
use illuminate\database\eloquent\modelnotfoundexception as modelnotfoundexception;

/**
 * M_Staff_Recepts Controller
 * @author ivs
 * @since 10/2020
 */

class StaffReceptsController extends Controller
{
    /**
     * get staff_recepts
     * パラメータのshopIdの予約可能スタッフ設定を取得する。
     * @param Request $request
     * @return response
     */
    public function getStaffRecepts(Request $request)
    {
        $user = Auth::user();
        $staff_recepts= DB::table('m_staff_recepts')
            ->leftJoin("m_staffs","m_staffs.id", "=", "m_staff_recepts.staff_id")
            ->leftjoin('m_shops', 'm_staffs.shop_id', '=', 'm_shops.id')
            ->where('m_shops.id', $user->shop_id)->whereNull('m_staff_recepts.deleted_at')
             ->select(
                'm_staff_recepts.id',
                'm_staff_recepts.staff_id',
                'm_staff_recepts.recept_amount',
                'm_staff_recepts.web_flg',
                'm_staff_recepts.nomination',
                'm_staff_recepts.updated_at'
                )
            ->get();
        if ($staff_recepts->count() > 0) {
            return response()->json($staff_recepts, Config::get('ponist.status.OK'))->header('content-type', Config::get('ponist.header.CONTENT_APPLICATION'));
        } else {
            return response()->json([], Config::get('ponist.status.OK'))->header('content-type', Config::get('ponist.header.CONTENT_APPLICATION'));
        }
    }

    /**
    * create staff_recepts
    * 予約可能スタッフ設定を登録する。
    * @param MStaffReceptsRequest $request
    * @return response json
    */
    public function createStaffRecepts(MStaffReceptsRequest $request)
    {
        try {
            return DB::connection()->transaction(function () use ($request) {
                $staff_recepts = new MStaffRecepts();
                $staff_recepts->staff_id = $request->staff_id;
                $staff_recepts->recept_amount = $request->recept_amount;
                $staff_recepts->web_flg = $request->web_flg;
                $staff_recepts->nomination = $request->nomination;

                if ($staff_recepts->save()) {
                    return response()->json($staff_recepts, Config::get('ponist.status.OK'))->header('content-type', Config::get('ponist.header.CONTENT_APPLICATION'));
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
     * update staff_recepts
     * パラメータのshopIdの予約可能スタッフ設定を更新する。
     * @param MStaffReceptsRequest $request, $shop_id, $staff_recepts_id
     * @return response json
     */
    public function updateStaffRecepts(MStaffReceptsRequest $request, $shop_id, $staff_recepts_id)
    {
        try {
            return DB::transaction(function () use ($request, $staff_recepts_id) {
                $staff_recepts = MStaffRecepts::find($staff_recepts_id);
                if (is_null($staff_recepts)) {
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
                if ($staff_recepts->updated_at == $request->updated_at) {
                    $staff_recepts->staff_id = $request->staff_id;
                    $staff_recepts->recept_amount = $request->recept_amount;
                    $staff_recepts->web_flg = $request->web_flg;
                    $staff_recepts->nomination = $request->nomination;

                    $staff_recepts->save();
                    return response()->json($staff_recepts);
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
     * get staff_recepts By Id
     *パラメータのshopIdの予約可能スタッフ設定を取得する。
     * @param $shop_id, $item_id
     * @return response json
     */
    public function getStaffRecept($shop_id, $staff_recepts_id)
    {
        try {
            return DB::transaction(function () use ($staff_recepts_id) {
                $user = Auth::user();
                $staff_recepts= DB::table('m_staff_recepts')
                ->leftJoin("m_staffs","m_staffs.id", "=", "m_staff_recepts.staff_id")
                ->leftjoin('m_shops', 'm_staffs.shop_id', '=', 'm_shops.id')
                ->where('m_shops.id', $user->shop_id)
                ->where('m_staff_recepts.id', $staff_recepts_id)->whereNull('m_staff_recepts.deleted_at')
                ->select(
                    'm_staff_recepts.id',
                    'm_staff_recepts.staff_id',
                    'm_staff_recepts.recept_amount',
                    'm_staff_recepts.web_flg',
                    'm_staff_recepts.nomination',
                    'm_staff_recepts.updated_at'
                    )
                ->get();
                if ($staff_recepts->count()>0) {
                    return response()->json($staff_recepts, Config::get('ponist.status.OK'))->header('content-type', Config::get('ponist.header.CONTENT_APPLICATION'));
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
     * delete staff_recept
     * パラメータのshopIdの予約可能スタッフ設定を削除する。
     * @param $shop_id, $items_id
     * @return response
     */
    public function deleteStaffRecept($shop_id, $staff_recepts_id)
    {
        try {
            return DB::transaction(function () use ($staff_recepts_id) {
                if ($staff_recepts = MStaffRecepts::find($staff_recepts_id)) {
                    $staff_recepts->delete();
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
