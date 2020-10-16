<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ShopMailDestinationsRequest;
use App\Models\MShopMailDestinations;
use Illuminate\Support\Facades\Config;
use Auth;
use DB;

/**
 * ShopMailDestinationsController
 * @author isv
 * @since 10/2020
 */
class ShopMailDestinationsController extends Controller
{
    /**
     * createShopMailDestination
     * 予約受付メール送信先設定を登録する。
     * @param ShopMailDestinationsRequest $request
     * @return response
     */
    public function createShopMailDestination(ShopMailDestinationsRequest $request)
    {
        try
        {
            return DB::connection()->transaction(function () use ($request)
            {
                $shopMailDestinations = new MShopMailDestinations();
                $user = Auth::user();
                $shopMailDestinations->shop_id = $user->shop_id;
                $shopMailDestinations->name = $request->name;
                $shopMailDestinations->email = $request->email;
                if ($shopMailDestinations->save())
                {
                    return response()
                        ->json($shopMailDestinations, Config::get('ponist.status.OK'))->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
                }
                else
                {
                    return response()
                        ->json(["message" => Config::get('ponist.notification.MESSAGE40001') , 'errors' => [['field' => Config::get('ponist.notification.FIELD_ID') , 'code' => Config::get('ponist.notification.CODE40001') ]]], Config::get('ponist.status.BAD_REQUEST'))
                        ->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
                }
                return $shopMailDestinations;
            });
        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * getShopMailDestination
     * パラメータのshopIdの予約受付メール送信先設定を取得する。
     * @param $shop_id, $shop_mail_destination_id
     * @return response
     */
    public function getShopMailDestination($shop_id, $shop_mail_destination_id)
    {
        $user = Auth::user();
        $shopMailDestinations = MShopMailDestinations::where('id', $shop_mail_destination_id)->where('shop_id', $user->shop_id)
            ->get();
        if ((isset($shopMailDestinations)) && (count($shopMailDestinations) > 0))
        {
            return response()->json($shopMailDestinations, Config::get('ponist.status.OK'));
        }
        else
        {
            return response()->json(["message" => Config::get('ponist.notification.MESSAGE40006') , 'errors' => [['field' => Config::get('ponist.notification.FIELD_ID') , 'code' => Config::get('ponist.notification.CODE40006') ]]], Config::get('ponist.status.BAD_REQUEST'))
                ->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
        }
    }

    /**
     * updateShopMailDestination
     * パラメータのshopIdの予約受付メール送信先設定を更新する。
     * @param ShopMailDestinationsRequest $request, $shop_id, $shop_mail_destination_id
     * @return response
     */
    public function updateShopMailDestination(ShopMailDestinationsRequest $request, $shop_id, $shop_mail_destination_id)
    {
        try
        {
            return DB::connection()->transaction(function () use ($request, $shop_id, $shop_mail_destination_id)
            {
                $shopMailDestinations = MShopMailDestinations::find($shop_mail_destination_id);
                if ($shopMailDestinations->exists())
                {
                    if ($shopMailDestinations->updated_at == $request->updated_at)
                    {
                        $shopMailDestinations->update($request->all());
                        $shopMailDestinations->save();
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
                    ->json($shopMailDestinations, Config::get('ponist.status.OK'));
            });
        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * deleteShopMailDestination
     * パラメータのshopIdの予約受付メール送信先設定を削除する。
     * @param $shop_id,  $shop_mail_destination_id
     * @return response
     */
    public function deleteShopMailDestination($shop_id, $shop_mail_destination_id)
    {
        try
        {
            return DB::connection()->transaction(function () use ($shop_id, $shop_mail_destination_id)
            {
                $shopMailDestinations = MShopMailDestinations::find($shop_mail_destination_id);
                if ($shopMailDestinations)
                {
                    $shopMailDestinations->delete();
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

