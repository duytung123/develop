<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MTaxe;
use App\Models\MShop;
use App\Models\MSkill;
use App\Models\MItem;
use App\Models\MCourse;
use App\Models\MClasse;
use App\Http\Requests\TaxesRequest;
use Illuminate\Support\Facades\Config;
use DB;
use Auth;

/**
 * TaxesController
 * @author isv
 * @since 10/2020
 */
class TaxesController extends Controller
{
    /**
     * get list Taxes
     * 税率情報一覧を登録する。
     * @param $shop_id
     * @return response
     */
    public function getTaxList($shop_id)
    {
        $tax = DB::table('m_taxes')->get();
        if (is_null($tax))
        {
            return response()->json(["message" => Config::get('ponist.notification.MESSAGE40006'), 'errors' => [['field' => Config::get('ponist.notification.FIELD_ID'), 'code' => Config::get('ponist.notification.CODE40006')]]], Config::get('ponist.status.BAD_REQUEST'))
                ->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
        }
        return response()
            ->json($tax, Config::get('ponist.status.OK'))->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
    }

    /**
     * create tax
     * 税率情報を登録する。
     * @param $request, $shop_id
     * @return response
     */
    public function createTax(TaxesRequest $request, $shop_id)
    {
        try
        {
            return DB::connection()->transaction(function () use ($request, $shop_id)
            {
                $user = Auth::user();
                if (MShop::where('id', $user->shop_id)
                    ->exists())
                {
                    $taxes = new MTaxe();
                    $taxes->name = $request->name;
                    $taxes->tax = $request->tax;
                    $taxes->reduced_flg = $request->reduced_flg;
                    $taxes->start_date = $request->start_date;
                    $taxes->end_date = $request->end_date;
                    $taxes->save();
                    return response()
                        ->json($taxes, Config::get('ponist.status.OK'))->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
                }
                else
                {
                    return response()
                        ->json(["message" => Config::get('ponist.notification.MESSAGE40006'), 'errors' => [['field' => Config::get('ponist.notification.FIELD_ID'), 'code' => Config::get('ponist.notification.CODE40006')]]], Config::get('ponist.status.BAD_REQUEST'))
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
     * get tax
     * パラメータのtaxIdの税率情報を取得する。
     * @param $shop_id, $tax_id
     * @return response
     */
    public function getTax($shop_id, $tax_id)
    {
        $taxes = MTaxe::find($tax_id);
        if ($taxes)
        {
            return response()->json($taxes, Config::get('ponist.status.OK'));
        }
        else
        {
            return response()->json(['message' =>Config::get('ponist.notification.MESSAGE40006'), 'errors' => [['field' => Config::get('ponist.notification.FIELD_ID'), 'code' => Config::get('ponist.notification.CODE40006')]]], Config::get('ponist.status.BAD_REQUEST'));
        }
    }

    /**
     * update tax
     * パラメータのtaxIdの税率情報を更新する。
     * @param $request, $shop_id, $tax_id
     * @return response
     */
    public function updateTax(TaxesRequest $request, $shop_id, $tax_id)
    {
        try
        {
            return DB::connection()->transaction(function () use ($request, $shop_id, $tax_id)
            {
                $taxes = MTaxe::find($tax_id);
                if ($taxes)
                {
                    if ($taxes->updated_at == $request->updated_at)
                    {
                        $taxes->update($request->all());
                        $taxes->save();
                        return response()
                            ->json($taxes, Config::get('ponist.status.OK'));
                    }
                    else
                    {
                        return response()->json(["message" => Config::get('ponist.notification.MESSAGE50102'), 'errors' => [['field' => Config::get('ponist.notification.FIELD50102'), 'code' => Config::get('ponist.notification.CODE50102')]]], Config::get('ponist.status.BAD_REQUEST'))
                            ->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
                    }
                }
                else
                {
                    return response()
                        ->json(["message" => Config::get('ponist.notification.MESSAGE40006')], Config::get('ponist.status.BAD_REQUEST'))
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
     * delete tax
     * パラメータのtaxIdの税率情報を削除する。
     * @param $shop_id, $tax_id
     * @return response
     */
    public function deleteTax($shop_id, $tax_id)
    {
        try
        {
            return DB::connection()->transaction(function () use ($shop_id, $tax_id)
            {
                if ($taxes = MTaxe::find($tax_id))
                {
                    $taxes->delete();
                    return response()
                        ->json(["message" => "no-content"], Config::get('ponist.status.NO-CONTENT'))
                        ->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
                }
                else
                {
                    return response()
                        ->json(["message" => Config::get('ponist.notification.EN')], Config::get('ponist.status.BAD_REQUEST'))
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
