<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MDiscount;
use App\Models\MShop;
use Auth;
use DB;
use App\Http\Requests\DiscountRequest;
use Illuminate\Support\Facades\Config;

class DiscountsController extends Controller
{
    /**
     * getDiscountList
     * 割引一覧を登録する。
     * @param Request $shop_id
     * @return response
     */
    public function getDiscountList(Request $request, $shop_id)
    {
        $user = Auth::user();
        $shop = MShop::find($user->shop_id);
        if ($shop)
        {
            $discountId = MDiscount::where('shop_id', $shop->id)
                ->orderBy('sort', 'asc')
                ->get();
        }
        else
        {
             return response()
                ->json(["message" => Config::get('ponist.notification.MESSAGE40006'), 'errors' => [['field' =>Config::get('ponist.notification.FIELD_ID'), 'code' => Config::get('ponist.notification.CODEINT')]]], Config::get('ponist.status.BAD_REQUEST'))
                ->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
        }
          return response()
            ->json($discountId, Config::get('ponist.status.OK'))->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));

    }

    /**
     * createDiscount
     * 割引情報を登録する。
     * @param DiscountRequest $request, $shop_id
     * @return response
     */
    public function createDiscount(DiscountRequest $request, $shop_id)
    {
        try
        {
            return DB::connection()->transaction(function () use ($request, $shop_id)
            {
                $user = Auth::user();
                if (MShop::where('id', $user->shop_id)
                    ->exists())
                {
                    $discountId = new MDiscount();
                    $discountId->name = $request->name;
                    $discountId->shop_id = $user->shop_id;
                    $discountId->discount_cd = $request->discount_cd;
                    $discountId->sort = $request->sort;
                    $discountId->discount_type = $request->discount_type;
                    $discountId->discount = $request->discount;

                    if ($discountId->save())
                    {
                       return response()
                            ->json($discountId, Config::get('ponist.status.OK'))->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
                    }
                    else
                    {
                       return response()
                            ->json(["message" =>Config::get('ponist.notification.MESSAGE40006'), 'errors' => [['field' => Config::get('ponist.notification.FIELD_ID'), 'code' => Config::get('ponist.notification.CODEINT')]]], Config::get('ponist.status.BAD_REQUEST'))
                            ->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
                    }
                }
                else
                {
                    return response()
                        ->json(["message" =>Config::get('ponist.notification.MESSAGE40001'), 'errors' => [['field' =>Config::get('ponist.notification.FIELD_NAME'), 'code' => Config::get('ponist.notification.CODEINT')]]], Config::get('ponist.status.BAD_REQUEST'))
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
     * getDiscount
     * パラメータのdiscountIdの割引情報を取得する。
     * @param $shop_id, $discount_id
     * @return response
     */
    public function getDiscount($shop_id, $discount_id)
    {
        if (MShop::where('id', $shop_id)->exists())
        {
            $discountId = MDiscount::find($discount_id);
            if (isset($discountId))
            {
                return response()->json([$discountId], Config::get('ponist.status.OK'));
            }
            else
            {
                 return response()->json(["message" =>Config::get('ponist.notification.MESSAGE40006'), 'errors' => [['field' => Config::get('ponist.notification.FIELD_ID'), 'code' => Config::get('ponist.notification.CODEINT')]]], Config::get('ponist.status.BAD_REQUEST'))
                    ->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
            }
        }
        else
        {
            return response('errors', 404)
                ->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
        }
    }

    /**
     * updateDiscount
     * パラメータのdiscountIdの割引情報を更新する。
     * @param DiscountRequest request, $shop_id, $discount_id
     * @return response
     */
    public function updateDiscount(DiscountRequest $request, $shop_id, $discount_id)
    {
        try
        {
            return DB::connection()->transaction(function () use ($request, $shop_id, $discount_id)
            {
                $discountId = MDiscount::find($discount_id);
                if (is_null($discountId))
                {
                     return response()->json(['message' => Config::get('ponist.notification.MESSAGE40006'), 'errors' => [['field' => Config::get('ponist.notification.FIELD40006'), 'code' => Config::get('ponist.notification.CODEINT')]]], Config::get('ponist.status.BAD_REQUEST'));
                }
                if ($discountId->updated_at == $request->updated_at)
                {
                    $discountId->name = $request->name;
                    $discountId->discount_cd = $request->discount_cd;
                    $discountId->discount_type = $request->discount_type;
                    $discountId->discount = $request->discount;
                    $discountId->sort = $request->sort;
                    $discountId->save();
                    return response()
                        ->json($discountId);
                }
                else
                {
                   return response()->json(["message" => Config::get('ponist.notification.MESSAGE50102'), 'errors' => [['field' =>Config::get('ponist.notification.FIELD50102'), 'code' => Config::get('ponist.notification.CODEINT')]]], Config::get('ponist.status.BAD_REQUEST'))
                        ->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
                }

            }
            ,);
        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage());
        }

    }
    /**
     * deleteDiscount
     * パラメータのdiscountIdの割引情報を削除する。
     * @param  request, $shop_id, $discount_id
     * @return response
     */

    public function deleteDiscount($shop_id, $discount_id)
    {
        try
        {
            return DB::connection()->transaction(function () use ($shop_id, $discount_id)
            {
                if ($discountId = MDiscount::find($discount_id))
                {
                    $discountId->delete();
                    return response()
                        ->json(["message" => "OK"], Config::get('ponist.status.NO-CONTENT'))
                        ->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));

                }
                else
                {
                   return response()
                        ->json(['message' => Config::get('ponist.notification.MESSAGE40006'), 'errors' => [['field' => Config::get('ponist.notification.FIELD_ID'), 'code' => Config::get('ponist.notification.CODEINT')]]], Config::get('ponist.status.BAD_REQUEST'))
                        ->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
                }

            }
            ,);
        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage());
        }

    }

    /*
     * updateDiscountListSort
     * 技術一覧のソート順を更新する。
     * @param Request  $request $list
     * @return response json
    */
    public function updateDiscountListSort(Request $request, $list)
    {
        try
        {
            return DB::connection()->transaction(function () use($request, $list)
            {
                 $json = $request->list;
                $ar = json_decode($json, true);
                for ($i = 0;$i < count($ar);$i++)
                {
                    $discountId = MDiscount::find($ar[$i]["id"]);
                    if ($discountId)
                    {
                        $discountId->sort = $ar[$i]["sort"];
                    }
                    else
                    {
                         return response()->json(['message' => Config::get('ponist.notification.MESSAGE40006'), 'errors' => [['field' => Config::get('ponist.notification.FIELD_ID'), 'code' => Config::get('ponist.notification.CODEINT')]]], Config::get('ponist.status.BAD_REQUEST'))
                            ->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
                    }
                    $discountId->save();
                }
                return response()
                    ->json(['OK'], Config::get('ponist.status.OK'));


            });

        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage());
        }

    }

}

