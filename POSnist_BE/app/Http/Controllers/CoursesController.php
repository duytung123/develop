<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MCourse;
use App\Models\MShop;
use App\Models\MClasse;
use App\Models\MUser;
use DB;
use Auth;
use App\Http\Requests\CoursesRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use illuminate\database\eloquent\modelnotfoundexception as modelnotfoundexception;

/**
 * CoursesController
 * @author ivs
 * @since 09/2020
 */
class CoursesController extends Controller
{
    /**
     * get Courses List
     * コース一覧を取得する。
     * @return response
     */
    public function getCourseslist()
    {
        $user = Auth::user();
        $course = DB::table('m_courses')
                ->leftjoin('m_classes', 'm_courses.class_id', '=', 'm_classes.id')
                ->leftjoin('m_shops', 'm_classes.shop_id', '=', 'm_shops.id')
                ->where('m_shops.id', $user->shop_id)->whereNull('m_courses.deleted_at')
                ->where('m_courses.category_cd', Config::get('ponist.categorycd.COURSE'))
                ->select(
                    'm_courses.id',
                    'm_courses.class_id',
                    'm_courses.category_cd',
                    'm_courses.name',
                    'm_courses.treatment_time',
                    'm_courses.buffer_time',
                    'm_courses.count',
                    'm_courses.price',
                    'm_courses.tax_id',
                    'm_courses.limit_date',
                    'm_courses.color_code',
                    'm_courses.sort',
                    'm_courses.month_menu_flg',
                    'm_courses.updated_at'
                )
                ->orderBy('sort', 'ASC')
                ->get();
        if ($course->count() > 0) {
             return response()->json($course, Config::get('ponist.status.OK'))->header('content-type', Config::get('ponist.header.CONTENT_APPLICATION'));
        } else {
          return response()->json([], Config::get('ponist.status.OK'))->header('content-type', Config::get('ponist.header.CONTENT_APPLICATION'));
        }
    }

    /**
    * create Course
    * コース情報を登録する。
    * @param CoursesRequest $request, $shopId
    * @return response json
    */
    public function createCourse(CoursesRequest $request, $shopId)
    {
        try {
            return DB::connection()->transaction(function () use ($request,$shopId) {
                $course = new MCourse();
                $course->class_id = $request->class_id;
                $course->category_cd = Config::get('ponist.categorycd.COURSE');
                $course->name = $request->name;
                $course->treatment_time = $request->treatment_time;
                $course->buffer_time = $request->buffer_time;
                $course->count = $request->count;
                $course->price = $request->price;
                $course->tax_id = $request->tax_id;
                $course->color_code = $request->color_code;
                $course->limit_date = $request->limit_date;
                $course->sort = $request->sort;
                $course->month_menu_flg = $request->month_menu_flg;

                if ($course->save()) {
                    return response()->json($course, Config::get('ponist.status.OK'))->header('content-type', Config::get('ponist.header.CONTENT_APPLICATION'));
                } else {
                    return response()->json([
                    'message' => Config::get('ponist.notification.MESSAGE40001'),
                    'errors' => [
                        [
                            'field' => Config::get('ponist.notification.FIELD_ID'),
                            'code' => Config::get('ponist.notification.CODE40001')
                        ]
                    ]
                ],Config::get('ponist.status.BAD_REQUEST'));
                }
            });
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    /**
     * Delete Course
     * パラメータのcourseIdのコース情報を削除する。
     * @param  Request $request, $shop_id, $courseId
     * @return response
     */
    public function deleteCourse(Request $request, $shopId, $courseId)
    {
        try {
            return DB::connection()->transaction(function () use ($request,$shopId,$courseId) {
                if ($course=MCourse::find($courseId)) {
                    $course->delete();
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
            ],Config::get('ponist.status.BAD_REQUEST'));
                }
            });
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    /**
     * update Course
     * パラメータのcourseIdのコース情報を更新する。
     * @param CoursesRequest $request, $shopId, $CoursesId
     * @return response json
     */
    public function updateCourse(CoursesRequest $request, $shopId, $coursesId)
    {
        try {
            return DB::connection()->transaction(function () use ($request,$shopId,$coursesId) {
                $course = MCourse::find($coursesId);
                if (is_null($coursesId)) {
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

                if ($course->updated_at == $request->updated_at) {
                    $course->class_id = $request->class_id;
                    $course->category_cd = Config::get('ponist.categorycd.COURSE');
                    $course->name = $request->name;
                    $course->treatment_time = $request->treatment_time;
                    $course->buffer_time = $request->buffer_time;
                    $course->count = $request->count;
                    $course->price = $request->price;
                    $course->tax_id = $request->tax_id;
                    $course->limit_date = $request->limit_date;
                    $course->color_code = $request->color_code;
                    $course->sort = $request->sort;
                    $course->month_menu_flg = $request->month_menu_flg;
                    $course->save();
                    return response()->json($course);
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
    /**
     * get Course By Id
     * パラメータのcourseIdのコース情報を取得する。
     * @param $ShopId, $id
     * @return response json
     */
    public function getCourse($shopId, $coursesId)
    {
        $user = Auth::user();
        $course = DB::table('m_courses')
            ->leftjoin('m_classes', 'm_courses.class_id', '=', 'm_classes.id')
            ->leftjoin('m_shops', 'm_classes.shop_id', '=', 'm_shops.id')
            ->where('m_shops.id', $user->shop_id)
            ->where('m_courses.id', $coursesId)->whereNull('m_courses.deleted_at')
            ->select(
                'm_courses.id',
                'm_courses.class_id',
                'm_courses.category_cd',
                'm_courses.name',
                'm_courses.treatment_time',
                'm_courses.buffer_time',
                'm_courses.count',
                'm_courses.price',
                'm_courses.tax_id',
                'm_courses.limit_date',
                'm_courses.sort',
                'm_courses.color_code',
                'm_courses.month_menu_flg',
                'm_courses.updated_at'
            )
            ->get();
        if ($course->count() > 0) {
            return response()->json($course, Config::get('ponist.status.OK'))->header('content-type', Config::get('ponist.header.CONTENT_APPLICATION'));
        } else {
            return response()->json([
                'message' => Config::get('ponist.notification.MESSAGE40006'),
                'errors' => [
                    [
                        'field' => Config::get('ponist.notification.FIELD_ID'),
                        'code' => Config::get('ponist.notification.CODE40006')
                    ]
                ]
            ],Config::get('ponist.status.BAD_REQUEST'));
        }
    }

    /**
     * updateCourseListSort
     * パラメータのcourseIdのコース情報を取得する。
     * @param Request $request, $list
     * @return response json
     */
    public function updateCourseListSort(Request $request, $list)
    {
        try {
            return DB::connection()->transaction(function () use ($request,$list) {
                $json = $request->list;
                $ar = json_decode($json, true);
                for ($i=0; $i < count($ar); $i++) {
                    $course = MCourse::find($ar[$i]["id"]);
                    if ($course) {
                        $course->sort = $ar[$i]["sort"];
                    } else {
                        return response()->json([
                'message' => Config::get('ponist.notification.EN'),
                'errors' => [
                    [
                        'field' => Config::get('ponist.notification.JSON'),
                        'code' => Config::get('ponist.notification.CODEINT')
                    ]
                ]
            ], 400);
                    }
                    $course->save();
                }
                return response()->json(['OK'], Config::get('ponist.status.OK'));
            });
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
