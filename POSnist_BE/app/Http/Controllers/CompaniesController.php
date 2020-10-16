<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MCompanie;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CompaniesRequest;
use Illuminate\Support\Facades\Config;
use Auth;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;

/**
 * CompaniesController
 * @author IVS
 * @since 09/2020
 */
class CompaniesController extends Controller
{
    /**
     * getCampany
     * パラメータのcompanyIdの会社情報を取得する。
     * @param Request $id
     * @return response
     */
    public function getCampany($id)
    {
        $companies = MCompanie::find($id);
        if (isset($companies))
        {
            if (MCompanie::where('id', $id)->exists())
            {
                return response()
                    ->json($companies, Config::get('ponist.status.OK'))->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
            }
        }
        else
        {
            return response()
                ->json(["message" => Config::get('ponist.notification.MESSAGE40006') , 'errors' => [['field' => Config::get('ponist.notification.FIELD_ID') , 'code' => Config::get('ponist.notification.CODE40006') ]]], Config::get('ponist.status.BAD_REQUEST'))
                ->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
        }
    }

    /**
     * createCompany
     * 会社情報を登録する。
     * @param CompaniesRequest $request
     * @return response
     */
    public function createCompany(CompaniesRequest $request)
    {
        try
        {
            return DB::connection()->transaction(function () use ($request)
            {
                $companies = new MCompanie();
                $companies->name = $request->input('name');
                $companies->postal_cd = $request->input('postal_cd');
                $companies->prefecture = $request->input('prefecture');
                $companies->city = $request->input('city');
                $companies->area = $request->input('area');
                $companies->address = $request->input('address');
                $companies->accounting = $request->input('accounting');
                $companies->cutoff_date = $request->input('cutoff_date');
                if ($companies->save())
                {
                    return response()
                        ->json($companies, Config::get('ponist.status.OK'))->header('Content-Type', 'application/json');
                }
                else
                {
                    return response()
                        ->json(["message" => Config::get('ponist.notification.MESSAGE40006') , 'errors' => [['field' => Config::get('ponist.notification.FIELD_ID') , 'code' => Config::get('ponist.notification.CODE40006') ]]], Config::get('ponist.status.BAD_REQUEST'))
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
     * updateCompany
     * パラメータのcompanyIdの会社情報を更新する。
     * @param CompaniesRequest $request, $id
     * @return response
     */
    public function updateCompany(CompaniesRequest $request, $id)
    {
        try
        {
            return DB::connection()->transaction(function () use ($request, $id)
            {
                $companies = MCompanie::find($id);
                if (is_null($companies))
                {
                    return response()->json(["message" => Config::get('ponist.notification.MESSAGE40006') , 'errors' => [['field' => Config::get('ponist.notification.FIELD_ID') , 'code' => Config::get('ponist.notification.CODE40006') ]]], Config::get('ponist.status.BAD_REQUEST'))
                        ->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
                }
                $companies->name = $request->input('name');
                $companies->postal_cd = $request->input('postal_cd');
                $companies->prefecture = $request->input('prefecture');
                $companies->city = $request->input('city');
                $companies->area = $request->input('area');
                $companies->address = $request->input('address');
                $companies->accounting = $request->input('accounting');
                $companies->cutoff_date = $request->input('cutoff_date');
                if ($companies->updated_at == $request->updated_at)
                {
                    $companies->save();
                    return response()
                        ->json($companies);
                }
                else
                {
                    return response()->json(["message" => Config::get('ponist.notification.MESSAGE50102') , 'errors' => [['field' => Config::get('ponist.notification.FIELD50102') , 'code' => Config::get('ponist.notification.CODE50102') ]]], Config::get('ponist.status.BAD_REQUEST'))
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
     * deleteCompany
     * パラメータのcompanyIdの会社情報を削除する。
     * @param Request $request, $id
     * @return response
     */
    public function deleteCompany(Request $request, $id)
    {
        try
        {
            return DB::connection()->transaction(function () use ($request, $id)
            {
                $companies = MCompanie::find($id);
                if (isset($companies))
                {
                    $companies->delete();
                    return response()
                    ->json(["message" => "no-content"], Config::get('ponist.status.NO-CONTENT'))
                    ->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
                }
                else
                {
                    return response()
                        ->json(["message" => Config::get('ponist.notification.MESSAGE40006') , 'errors' => [['field' => Config::get('ponist.notification.FIELD_ID') , 'code' => Config::get('ponist.notification.CODE40006') ]]], Config::get('ponist.status.BAD_REQUEST'))
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

