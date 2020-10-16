<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MClasse;
use App\Models\MShop;
use App\Models\MSKill;
use App\Models\MCourse;
use App\Models\MItem;
use App\Http\Requests\ClassesRequest;
use Illuminate\Support\Facades\Config;
use Auth;
use DB;

/**
 * ClassesController
 * @author isv
 * @since 09/2020
 */
class ClassesController extends Controller
{
    /**
     * getClassesList
     * 分類情報一覧を登録する。
     * @param Request $request, $shop_id
     * @return response
     */
    public function getClassesList(Request $request, $shop_id)
    {
        return $this->getList($request->category_cd, $shop_id);
    }

    public function getList($category_cd, $shop_id)
    {
        $user = Auth::user();
        $shop = MShop::find($user->shop_id);
        if ($shop)
        {
            $classes = MClasse::where('shop_id', $shop->id)
                ->where('category_cd', $category_cd)->orderBy('sort', 'ASC')
                ->get();
            if (isset($classes))
            {
                return response()->json($classes, Config::get('ponist.status.OK'))->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
            }
            else
            {
                return response()
                    ->json([], Config::get('ponist.status.OK'))
                    ->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
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
     * createClasses
     * 分類情報を登録する。
     * @param ClassesRequest $request
     * @return response
     */
    public function createClasses(ClassesRequest $request)
    {
        try
        {
            return DB::connection()->transaction(function () use ($request)
            {
                $user = Auth::user();
                $classes = new MClasse();
                $classes->name = $request->name;
                $classes->shop_id = $user->shop_id;
                $classes->category_cd = $request->category_cd;
                $classes->sort = 0;
                if ($classes->save())
                {
                    return response()
                        ->json($classes, Config::get('ponist.status.OK'))->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
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
     * deleteClasses
     * パラメータのclassIdの分類情報を削除する。
     * @param Request $request, $shop_id, $classes_id
     * @return response
     */
    public function deleteClasses(Request $request, $shop_id, $classes_id)
    {
        try
        {
            return DB::connection()->transaction(function () use ($request, $shop_id, $classes_id)
            {
                $classes = MClasse::find($classes_id);
                if ($classes)
                {
                    $m_courses = MCourse::where('class_id', $classes_id)->select('class_id')
                        ->get();
                    $m_skills = MSKill::where('class_id', $classes_id)->select('class_id')
                        ->get();
                    $m_items = MItem::where('class_id', $classes_id)->select('class_id')
                        ->get();
                    $arr = [$m_courses, $m_skills, $m_items];
                    $fl = false;
                    for ($i = 0;$i < count($arr);$i++)
                    {
                        if (count($arr[$i]) > 0)
                        {
                            if (($arr[$i][0]['class_id']) == $classes_id)
                            {
                                $fl = true;
                            }
                        }
                    }
                    if ($fl == false)
                    {
                        $classes->delete();
                        return response()
                            ->json(["message" => "no-content"], Config::get('ponist.status.NO-CONTENT'))
                            ->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
                    }
                    else
                    {
                        return response()
                            ->json(['message' => Config::get('ponist.notification.MESSAGE40001') , 'errors' => [['field' => Config::get('ponist.notification.FIELD_ID') , 'code' => Config::get('ponist.notification.CODE40001') ]]], Config::get('ponist.status.BAD_REQUEST'));
                    }
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
     * updateClasses
     * パラメータのclassIdの分類情報を更新する。
     * @param ClassesRequest $request, $shop_id, $classes_id
     * @return response
     */
    public function updateClasses(ClassesRequest $request, $shop_id, $classes_id)
    {
        try
        {
            return DB::connection()->transaction(function () use ($request, $classes_id)
            {
                if (MClasse::where('id', $classes_id)->exists())
                {
                    $classes = MClasse::find($classes_id);
                    $classes->name = $request->name;
                    if ($classes->updated_at == $request->updated_at)
                    {
                        $classes->save();
                        return response()
                            ->json($classes, Config::get('ponist.status.OK'));
                    }
                    else
                    {
                        return response()->json(["message" => Config::get('ponist.notification.MESSAGE40006') , 'errors' => [['field' => Config::get('ponist.notification.FIELD_ID') , 'code' => Config::get('ponist.notification.CODE40006') ]]], Config::get('ponist.status.BAD_REQUEST'))
                            ->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
                    }
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
     * getClasses
     * パラメータのclassIdの分類情報を取得する。
     * @param $shop_id, $classes_id
     * @return response
     */
    public function getClasses($shop_id, $classes_id)
    {
        $user = Auth::user();
        if (MShop::where('id', $user->shop_id)
            ->exists())
        {
            $classes = MClasse::where('id', $classes_id)->where('shop_id', $user->shop_id)
                ->get();
            if ((isset($classes)) && (count($classes) > 0))
            {
                return response()->json($classes, Config::get('ponist.status.OK'));
            }
            else
            {
                return response()->json(['message' => Config::get('ponist.notification.MESSAGE40006') , 'errors' => [['field' => Config::get('ponist.notification.FIELD_ID') , 'code' => Config::get('ponist.notification.CODE40006') ]]],);
            }
        }
    }

    /**
     * listSort
     * 対象カテゴリの分類情報のソート順を更新する。
     * @param Request $request, $shop_id
     * @return response
     */
    public function listSort(Request $request, $shop_id)
    {
        try
        {
            return DB::connection()->transaction(function () use ($request, $shop_id)
            {
                $json = $request->list;
                $ar = json_decode($json, true);
                for ($i = 0;$i < count($ar);$i++)
                {
                    $classes = MClasse::find($ar[$i]["id"]);
                    if ($classes)
                    {
                        $classes->sort = $ar[$i]["sort"];
                    }
                    else
                    {
                        return response('errors', Config::get('ponist.status.BAD_REQUEST'))->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
                    }
                    $classes->save();
                }
                return $this->getList($request->categoryCd, $shop_id);
            });
        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }
}

