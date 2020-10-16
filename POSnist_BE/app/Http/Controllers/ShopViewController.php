<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ShopViewRequest;
use App\Models\MShop;
use App\Models\MShopView;
use DB;
use Auth;
use Image;
use File;

/**
 * ShopViewController
 * POSnistへログインを行う。
 * @author IVS
 * @since 10/2020
 */
class ShopViewController extends Controller
{
    /**
     * createShopView
     * 店舗情報表示用を登録する
     * @param ShopViewRequest $request $shop_id
     * @return response
     */
    public function createShopView(ShopViewRequest $request, $shop_id)
    {
        try
        {
            return DB::connection()->transaction(function () use ($request, $shop_id)
            {

                $user = Auth::user();
                if (MShop::where('id', $user->shop_id)
                    ->exists())
                {
                    $shopviews = MShopView::create($request->all());
                    // upload image-------
                    $oldPath = $request->log_img;
                    $namefile = strstr($oldPath, "/");
                    $newPath = 'upload/customer' . $namefile;
                    $pathThumbnail = 'upload/thumbnail/customer' . $namefile;
                    File::move($oldPath, $newPath);
                    File::copy($newPath, $pathThumbnail);
                    $img = Image::make($pathThumbnail)->resize(Config::get('ponist.thumbnail.width') , Config::get('ponist.thumbnail.hight') , function ($constraint)
                    {
                        $constraint->aspectRatio();
                    });
                    $img->save($pathThumbnail);
                    //--------------------
                    if ($shopviews->save())
                    {
                        return response()
                            ->json($shopviews, Config::get('ponist.status.OK'))->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
                    }
                    else
                    {
                        return response()
                            ->json(["message" => Config::get('ponist.notification.MESSAGE40001') , 'errors' => [['field' => Config::get('ponist.notification.FIELD_NAME') , 'code' => Config::get('ponist.notification.CODEINT') ]]], Config::get('ponist.status.BAD_REQUEST'))
                            ->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
                    }
                }
                    else
                    {
                        return response()
                            ->json(["message" => Config::get('ponist.notification.MESSAGE40001') , 'errors' => [['field' => Config::get('ponist.notification.FIELD_NAME') , 'code' => Config::get('ponist.notification.CODEINT') ]]], Config::get('ponist.status.BAD_REQUEST'))
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
     * getShopView
     * パラメータのshopIdの店舗情報表示用を取得する。
     * @param Request $request $shop_id $staff_id
     * @return response
     */
    public function getShopView(Request $request, $shop_id, $shopview_id)
    {
        $user = Auth::user();

        if (MShop::where('id', $shop_id)->exists())
        {
            $shopviews = MShopView::where('id', $shopview_id)->where('shop_id', $user->shop_id)
                ->get();
            if ((isset($shopviews)) && (count($shopviews) > 0))
            {
                return response()->json($shopviews, Config::get('ponist.status.OK'));
            }
            else
            {
                return response()->json(["message" => Config::get('ponist.notification.MESSAGE40006') , 'errors' => [['field' => Config::get('ponist.notification.FIELD_ID') , 'code' => Config::get('ponist.notification.CODEINT') ]]], Config::get('ponist.status.BAD_REQUEST'))
                    ->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
            }

        }

    }
    /**
     * updateShopView
     * パラメータのshopIdの店舗情報表示用を更新する。
     * @param  shopviewsRequest $shop_id $shopview_id
     * @return response
     */
    public function updateShopView(ShopViewRequest $request, $shop_id, $shopview_id)
    {
        try
        {
            return DB::connection()->transaction(function () use ($request, $shop_id, $shopview_id)
            {
                $shopviews = MShopView::find($shopview_id);
                if (isset($shopviews))
                {
                    return response()->json(['message' => Config::get('ponist.notification.MESSAGE40006') , 'errors' => [['field' => Config::get('ponist.notification.FIELD_ID') , 'code' => Config::get('ponist.notification.CODEINT') ]]], Config::get('ponist.status.BAD_REQUEST'));
                }
                if ($shopviews->updated_at == $request->updated_at)
                {
                    $updateShopviews =  $request->all();
                    if ($shopviews->log_img != $request->log_img)
                    {
                        // upload image-------
                        $oldPath = $request->log_img;
                        $namefile = strstr($oldPath, "/");
                        $newPath = 'upload/customer' . $namefile;
                        $pathThumbnail = 'upload/thumbnail/customer' . $namefile;
                        File::move($oldPath, $newPath);
                        File::copy($newPath, $pathThumbnail);
                        $img = Image::make($pathThumbnail)->resize(Config::get('ponist.thumbnail.width') , Config::get('ponist.thumbnail.hight') , function ($constraint)
                        {
                            $constraint->aspectRatio();
                        });
                        $img->save($pathThumbnail);
                        //--------------------
                        
                        $updateShopviews['log_img']=$newPath;
                    }
                    $shopviews->update($updateShopviews);
                    return response()
                        ->json($shopviews, Config::get('ponist.status.OK'));
                }
                else
                {
                    return response()->json(["message" => Config::get('ponist.notification.MESSAGE50102') , 'errors' => [['field' => Config::get('ponist.notification.FIELD50102') , 'code' => Config::get('ponist.notification.CODEINT') ]]], Config::get('ponist.status.BAD_REQUEST'))
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
     * deleteShopView
     * パラメータのshopIdの店舗情報表示用を削除する。
     * @param Request $shop_id $shopview_id
     * @return response
     */
    public function deleteShopView(Request $request, $shop_id, $shopview_id)
    {
        try
        {
            return DB::connection()->transaction(function () use ($request, $shop_id, $shopview_id)
            {
                if ($shopviews = MShopView::find($shopview_id))
                {
                    $shopviews->delete();
                    return response()
                        ->json(["message" => "OK"], Config::get('ponist.status.NO-CONTENT'))
                        ->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));

                }
                else
                {
                    return response()
                        ->json(['message' => Config::get('ponist.notification.MESSAGE40006') , 'errors' => [['field' => Config::get('ponist.notification.FIELD_ID') , 'code' => Config::get('ponist.notification.CODEINT') ]]], Config::get('ponist.status.BAD_REQUEST'))
                        ->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
                }

            });

        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage());
        }

    }
}

