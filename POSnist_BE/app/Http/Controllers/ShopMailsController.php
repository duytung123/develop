<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ShopMailsRequest;
use App\Models\MShopMails;
use Illuminate\Support\Facades\Config;
use Auth;
use DB;

class ShopMailsController extends Controller
{
    /**
     * createShopMail
     * 予約完了メール設定を登録する。
     * @param Request $request
     * @return response
     */
    public function createShopMail(ShopMailsRequest $request)
    {
        try
        {
            return DB::connection()->transaction(function () use ($request)
            {
                $shopMails = new MShopMails();
                $user = Auth::user();
                $shopMails->shop_id = $user->shop_id;
                $shopMails->subject = $request->subject;
                $shopMails->body = $request->body;
                if ($shopMails->save())
                {
                    return response()
                        ->json($shopMails, Config::get('ponist.status.OK'))->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
                }
                else
                {
                    return response()
                        ->json(["message" => Config::get('ponist.notification.MESSAGE40001') , 'errors' => [['field' => Config::get('ponist.notification.FIELD_ID') , 'code' => Config::get('ponist.notification.CODE40001') ]]], Config::get('ponist.status.BAD_REQUEST'))
                        ->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
                }
            });
        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * getShopMail
     * パラメータのshopIdの予約完了メール設定を取得する。
     * @param $shop_id, $shopmail_id
     * @return response
     */
    public function getShopMail($shop_id, $shopmail_id)
    {
        $user = Auth::user();
        $shopMails = MShopMails::where('id', $shopmail_id)->where('shop_id', $user->shop_id)
            ->get();
        if ((isset($shopMails)) && (count($shopMails) > 0))
        {
            return response()->json($shopMails, Config::get('ponist.status.OK'));
        }
        else
        {
            return response()->json(["message" => Config::get('ponist.notification.MESSAGE40006') , 'errors' => [['field' => Config::get('ponist.notification.FIELD_ID') , 'code' => Config::get('ponist.notification.CODE40006') ]]], Config::get('ponist.status.BAD_REQUEST'))
                ->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
        }
    }

    /**
     * updateShopMail
     * パラメータのshopIdの予約完了メール設定を更新する。
     * @param Request $request, $shop_id, $shopmail_id
     * @return response
     */
    public function updateShopMail(ShopMailsRequest $request, $shop_id, $shopmail_id)
    {
        try
        {
            return DB::connection()->transaction(function () use ($request, $shop_id, $shopmail_id)
            {
                $shopMails = MShopMails::find($shopmail_id);
                if ($shopMails->exists())
                {
                    if ($shopMails->updated_at == $request->updated_at)
                    {
                        $shopMails->update($request->all());
                        $shopMails->save();
                    }
                    else
                    {
                        return response()
                            ->json(["message" => Config::get('ponist.notification.MESSAGE50102') , 'errors' => [['field' => Config::get('ponist.notification.FIELD50102') , 'code' => Config::get('ponist.notification.CODE50102') ]]], Config::get('ponist.status.BAD_REQUEST'))
                            ->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
                    }
                }
                else
                {
                    return response()
                        ->json(["message" => Config::get('ponist.notification.MESSAGE40006') , 'errors' => [['field' => Config::get('ponist.notification.FIELD_ID') , 'code' => Config::get('ponist.notification.CODE40006') ]]], Config::get('ponist.status.BAD_REQUEST'))
                        ->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
                }
                return response()
                    ->json($shopMails, Config::get('ponist.status.OK'));
            });
        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * deleteShopMailDestination
     * パラメータのshopIdの予約完了メール設定を削除する。
     * @param $shop_id, $shopmail_id
     * @return response
     */
    public function deleteShopMail($shop_id, $shopmail_id)
    {
        try
        {
            return DB::connection()->transaction(function () use ($shop_id, $shopmail_id)
            {
                $shopMails = MShopMails::find($shopmail_id);
                if ($shopMails)
                {
                    $shopMails->delete();
                    return response()
                        ->json(["message" => "no-content"], Config::get('ponist.status.NO-CONTENT'))
                        ->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
                }
                else
                {
                    return response()
                        ->json(['message' => Config::get('ponist.notification.MESSAGE40006') , 'errors' => [['field' => Config::get('ponist.notification.FIELD_ID') , 'code' => Config::get('ponist.notification.CODE40006') ]]], Config::get('ponist.status.BAD_REQUEST'));
                }
            });
        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }
}

