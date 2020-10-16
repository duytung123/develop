<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MPayment;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\PaymentRequest;
use Illuminate\Support\Facades\Config;
use App\Models\MUser;
use DB;
use Auth;

/**
 * Payment
 * @author IVS
 * @since 09/2020
 */
class PaymentController extends Controller
{
    /**
    * Create Payments
    * お支払い方法情報一覧を登録
    * @param PaymentsRequest $request
    * @return response
    */
    public function createPayment(PaymentRequest $request)
    {
        try {
            return DB::connection()->transaction(function () use ($request) {
                $m_payment = new MPayment();
                $m_payment->payment = $request->payment;
                if ($m_payment->save()) {
                    return response()->json($m_payment, Config::get('ponist.status.OK'))->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
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
    * Create PaymentsAll
    * @return response
    */
    public function getAllPayment()
    {
        $m_payment = MPayment::all();
        if (isset($m_payment)) {
           return response()->json($m_payment, Config::get('ponist.status.OK'))->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
        } else {
            return response()->json([], Config::get('ponist.status.OK'))->header('content-type', Config::get('ponist.header.CONTENT_APPLICATION'));
        }
    }
    /**
    * Get PaymentID
    * お支払い方法情報一覧を登録
    * @param $id
    * @return response
    */
    public function getPayment($paymentId)
    {
        if ($m_payment = MPayment::find($paymentId)) {
            return response()->json($m_payment, Config::get('ponist.status.OK'));
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
    * Delete Payment
    * お支払い方法情報を削除
    * @param  $paymentId
    * @return response
    */
    public function deletePayment($paymentId)
    {
        try {
            return DB::transaction(function () use ($paymentId) {
                if($payment=MPayment::find($paymentId)){
                    if ($payment->deleted_at == null) {
                        $payment->delete();
                        return response()->json([
                            'message' => "OK"
                          ], Config::get('ponist.status.NO-CONTENT'));
                    }
                }
                else{
                    return response()->json([
                        'message' => Config::get('ponist.notification.EN'),
                        'errors' => [
                            [
                                'field' => Config::get('ponist.notification.JSON'),
                                'code' => Config::get('ponist.notification.CODEINT')
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
    * Update Payment
    * お支払い方法情報の更新
    * @param PaymentsRequest $request, $id
    * @return response
    */
    public function updatePayment(PaymentRequest $request, $paymentId)
    {
        try {
            return DB::connection()->transaction(function () use ($request,$paymentId) {
                $m_payment = MPayment::find($paymentId);
                if (is_null($paymentId)) {
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

                if ($m_payment->updated_at == $request->updated_at) {
                    $m_payment->payment = $request->payment;
                    $m_payment->save();
                    return response()->json($m_payment);
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
