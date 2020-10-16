<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MItem;
use App\Models\Mshop;
use App\Models\MClasse;
use DB;
use Auth;
use App\Models\MUser;
use Illuminate\Support\Facades\Config;
use App\Http\Requests\ItemsRequest;
use Illuminate\Support\Facades\Validator;
use illuminate\database\eloquent\modelnotfoundexception as modelnotfoundexception;

/**


 * ItemsController
 * @author IVS
 * @since 23/09/2020
 */
class ItemsController extends Controller
{
    /**
     * get Items List
     * 商品一覧を取得する。
     * @param Request $request
     * @return response
     */
    public function getItemList(Request $request)
    {
        $user = Auth::user();
        $items= DB::table('m_items')
                ->leftjoin('m_classes', 'm_items.class_id', '=', 'm_classes.id')
                ->leftjoin('m_shops', 'm_classes.shop_id', '=', 'm_shops.id')
                ->where('m_shops.id', $user->shop_id)->whereNull('m_items.deleted_at')
                ->where('m_items.category_cd', Config::get('ponist.categorycd.PRODUCT'))
                ->select(
                    'm_items.id',
                    'm_items.class_id',
                    'm_items.category_cd',
                    'm_items.name',
                    'm_items.used_date',
                    'm_items.price',
                    'm_items.tax_id',
                    'm_items.sort',
                    'm_items.updated_at'
                )
                ->orderBy('sort', 'ASC')
                ->get();
        if ($items->count() > 0) {
             return response()->json($items, Config::get('ponist.status.OK'))->header('content-type', Config::get('ponist.header.CONTENT_APPLICATION'));
        } else {
             return response()->json([], Config::get('ponist.status.OK'))->header('content-type', Config::get('ponist.header.CONTENT_APPLICATION'));
        }
    }

    /**
    * create items
    * 商品情報を登録する。
    * @param ItemsRequest $request
    * @return response json
    */
    public function createItems(ItemsRequest $request)
    {
        try {
            return DB::connection()->transaction(function () use ($request) {
                $items = new MItem();
                $items->class_id = $request->class_id;
                $items->category_cd= Config::get('ponist.categorycd.PRODUCT');
                $items->name = $request->name;
                $items->used_date = $request->used_date;
                $items->price = $request->price;
                $items->tax_id = $request->tax_id;
                $items->sort = $request->sort;
                if ($items->save()) {
                     return response()->json($items, Config::get('ponist.status.OK'))->header('content-type', Config::get('ponist.header.CONTENT_APPLICATION'));
                } else {
                 return response()->json([
                    'message' => Config::get('ponist.notification.MESSAGE40001'),
                    'errors' => [
                        [
                            'field' => Config::get('ponist.notification.FIELD_ID'),
                            'code' => Config::get('ponist.notification.CODE40001')
                        ]
                    ]
                ], 400);
                }
            });
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * delete items
     * パラメータのitemIdの商品情報を削除する。
     * @param $shop_id, $items_id
     * @return response
     */
    public function deleteItems($shop_id, $items_id)
    {
        try {
            return DB::transaction(function () use ($items_id) {
                if ($items=MItem::find($items_id)) {
                    $items->delete();
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
     * update items
     * パラメータのitemIdの商品情報を更新する。
     * @param ItemsRequest $Shopid $Itemid
     * @return response json
     */
    public function updateItems(ItemsRequest $request, $shop_id, $items_id)
    {
        try {
            return DB::transaction(function () use ($request, $items_id) {
                $items = MItem::find($items_id);
                if (is_null($items)) {
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
                if ($items->updated_at == $request->updated_at) {
                    $items->class_id = $request->class_id;
                    $items->category_cd = Config::get('ponist.categorycd.PRODUCT');
                    $items->name = $request->name;
                    $items->used_date = $request->used_date;
                    $items->price = $request->price;
                    $items->tax_id = $request->tax_id;
                    $items->sort =$request->sort;
                    $items->save();
                    return response()->json($items);
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
     * get items
     *パラメータのitemIdの商品情報を取得する。
     * @param $shop_id, $item_id
     * @return response json
     */
    public function getItems($shop_id, $items_id)
    {
        try {
            return DB::transaction(function () use ($items_id) {
                $user = Auth::user();
                $items= DB::table('m_items')
                ->leftjoin('m_classes', 'm_items.class_id', '=', 'm_classes.id')
                ->leftjoin('m_shops', 'm_classes.shop_id', '=', 'm_shops.id')
                ->where('m_shops.id', $user->shop_id)
                ->where('m_items.id', $items_id)->whereNull('m_items.deleted_at')
                ->select(
                    'm_items.id',
                    'm_items.class_id',
                    'm_items.category_cd',
                    'm_items.name',
                    'm_items.used_date',
                    'm_items.price',
                    'm_items.tax_id',
                    'm_items.sort',
                    'm_items.updated_at'
                )
                ->get();
                if ($items->count()>0) {
                     return response()->json($items, Config::get('ponist.status.OK'))->header('content-type', Config::get('ponist.header.CONTENT_APPLICATION'));
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
    public function updateItemListSort(Request $request, $list)
    {
        try {
            return DB::transaction(function () use ($request,$list) {
                $json = $request->list;
                $ar = json_decode($json, true);
                for ($i=0; $i < count($ar); $i++) {
                    $items = MItem::find($ar[$i]["id"]);
                    if ($items) {
                        $items->sort = $ar[$i]["sort"];
                    } else {
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
                    $items->save();
                }
                return response()->json(['OK'], Config::get('ponist.status.OK'));
            });
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}