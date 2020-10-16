<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MSkill;
use App\Models\MClasse;
use App\Models\MShop;
use App\Models\MUser;
use Auth;
use illuminate\support\facades\validator;
use App\http\requests\SkillRequest;
use Illuminate\Http\Response;
use DB;
use illuminate\database\eloquent\modelnotfoundexception as modelnotfoundexception;
use Illuminate\Support\Facades\Config;

/**
 * SkillController
 * POSnistへログインを行う。
 * @author IVS
 * @since 09/2020
 */
class SkillController extends controller
{

    /**
     * getSkillList
     * 技術一覧を取得する。
     * @param Request $request $id
     * @return response json
     */
    public function getSkillList(Request $request, $shop_id)
    {
        $user = Auth::user();
        $data = DB::table('m_skills')->leftjoin('m_classes', 'm_skills.class_id', '=', 'm_classes.id')
            ->leftjoin('m_shops', 'm_classes.shop_id', '=', 'm_shops.id')
            ->where('m_shops.id', $user->shop_id)
            ->whereNull('m_skills.deleted_at')
            ->where('m_skills.category_cd', Config::get('ponist.categorycd.TECH'))
            ->orderBy('sort', 'asc')
            ->select('m_skills.*')
            ->get();

        if ($data->count() > 0)
        {
           return response()
                ->json($data, Config::get('ponist.status.OK'))->header('content-type', Config::get('ponist.header.CONTENT_APPLICATION'));
        }
        else
        {
            return response()
                ->json([], Config::get('ponist.status.OK'))->header('content-type', Config::get('ponist.header.CONTENT_APPLICATION'));
        }
    }
    /**
     * createSkill
     * 技術情報を登録する。
     * @param SkillRequest $request
     * @return response json
     */
    public function createSkill(SkillRequest $request)
    {
        try
        {
            return DB::connection()->transaction(function () use ($request)
            {
                
                $skill = MSkill::create($request->all());
                $skill->category_cd = Config::get('ponist.categorycd.TECH');
                if ($skill->save())
                {
                    return response()->json($skill, Config::get('ponist.status.OK'))->header('content-type', Config::get('ponist.header.CONTENT_APPLICATION'));
                }
                else
                {
                    return response()->json(['message' => Config::get('ponist.notification.MESSAGE40001') , 'errors' => [['field' => Config::get('ponist.notification.FIELD_NAME') , 'code' => Config::get('ponist.notification.CODEINT') ]]], Config::get('ponist.status.BAD_REQUEST'));
                }

            });

        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage());

        }

    }
    /**
     * getSkill
     * パラメータのskillIdの技術情報を取得する
     * @param  $shop_id  $skill_id
     * @return response json
     */

    public function getSkill($shop_id, $skill_id)
    {
        $user = Auth::user();
        $data = DB::table('m_skills')->leftjoin('m_classes', 'm_skills.class_id', '=', 'm_classes.id')
            ->leftjoin('m_shops', 'm_classes.shop_id', '=', 'm_shops.id')
            ->where('m_shops.id', $user->shop_id)
            ->where('m_skills.id', $skill_id)->whereNull('m_skills.deleted_at')
            ->select('m_skills.*')
            ->get();
        if ($data->count() > 0)
        {
             return response()
                ->json($data, Config::get('ponist.status.OK'))->header('content-type', Config::get('ponist.header.CONTENT_APPLICATION'));
        }
        else
        {
            return response()
                ->json(['message' => Config::get('ponist.notification.MESSAGE40006') , 'errors' => [['field' => Config::get('ponist.notification.FIELD_ID') , 'code' => Config::get('ponist.notification.CODEINT') ]]], Config::get('ponist.status.BAD_REQUEST'));
        }
    }
    /**
     * updateSkill
     * パラメータのskillIdのメニュー情報を更新する。
     * @param SkillRequest $request $shop_id $skill_id
     * @return response json
     */
    public function updateSkill(SkillRequest $request, $shop_id, $skill_id)
    {
        try
        {
            return DB::connection()->transaction(function () use ($request, $shop_id, $skill_id)
            {
                $skill = MSkill::find($skill_id);
                if (is_null($skill))
                {
                    return response()->json(['message' => Config::get('ponist.notification.MESSAGE40006') , 'errors' => [['field' => Config::get('ponist.notification.FIELD_ID') , 'code' => Config::get('ponist.notification.CODEINT') ]]], Config::get('ponist.status.BAD_REQUEST'));
                }
                if ($skill->updated_at == $request->updated_at)
                {
                    $skill->update($request->all());
                    $skill->category_cd = Config::get('ponist.categorycd.TECH');
                    return response()
                        ->json($skill);
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
     * deleteSkill
     * パラメータのskillIdのメニュー情報を削除する。
     * @param Request  $request $shop_id $skill_id
     * @return response json
     */
    public function deleteSkill(Request $request, $shop_id, $skill_id)
    {
        try
        {
            return DB::connection()->transaction(function () use ($request, $shop_id, $skill_id)
            {
                if ($skill = MSkill::find($skill_id))
                {
                    $skill->delete();
                   return response()
                        ->json(["message" => 'OK'], Config::get('ponist.status.NO-CONTENT'));
                }
                else
                {
                     return response()
                        ->json(['message' => Config::get('ponist.notification.MESSAGE40006') , 'errors' => [['field' => Config::get('ponist.notification.FIELD_ID') , 'code' => Config::get('ponist.notification.CODEINT') ]]], Config::get('ponist.status.BAD_REQUEST'));
                }

            });

        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage());

        }

    }
    /**
     * updateSkillListSort
     * 技術一覧のソート順を更新する。
     * @param Request  $request $list
     * @return response json
     */
    public function updateSkillListSort(Request $request, $list)
    {
        try
        {
            return DB::connection()->transaction(function () use ($request, $list)
            {
                $json = $request->list;
                $ar = json_decode($json, true);
                for ($i = 0;$i < count($ar);$i++)
                {
                    $skills = MSkill::find($ar[$i]["id"]);
                    if ($skills)
                    {
                        $skills->sort = $ar[$i]["sort"];
                    }
                    else
                    {
                      return response()->json(['message' => Config::get('ponist.notification.MESSAGE40006') , 'errors' => [['field' => Config::get('ponist.notification.FIELD_ID') , 'code' => Config::get('ponist.notification.CODEINT') ]]], Config::get('ponist.status.BAD_REQUEST'));
                    }
                    $skills->save();
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

