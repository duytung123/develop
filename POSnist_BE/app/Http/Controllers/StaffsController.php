<?php
namespace App\Http\Controllers;

use App\Http\Requests\StaffsRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\MStaff;
use App\Models\MShop;
use Auth;
use DB;
use Image;
use File;

/**
 * StaffsController
 * @author isv
 * @since 10/2020
 */
class StaffsController extends Controller
{

    /**
     * getStaffsList
     * スタッフ情報一覧を登録する。
     * @param Request $request $shop_id
     * @return response
     */
    public function getStaffList(Request $request, $shop_id)
    {

        $user = Auth::user();
        $shop = MShop::find($user->shop_id);
        if ($shop)
        {
            $staffs = MStaff::where('shop_id', $shop->id)
                ->get();
            foreach ($staffs as $key => $item) {
                $item->staff_img = Config::get('ponist.baseurl') . $item->staff_img;
            }


        }
        else {
                return response()->json([], Config::get('ponist.status.OK'))->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
            }
        return response()
            ->json($staffs, Config::get('ponist.status.OK'))->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
    }

    /**
     * createStaff
     * スタッフ情報を登録する。
     * @param StaffsRequest $request $shop_id
     * @return response
     */
    public function createStaff(StaffsRequest $request, $shop_id)
    {
        try
        {
            return DB::connection()->transaction(function () use ($request, $shop_id)
            {

                $user = Auth::user();
                if (MShop::where('id', $user->shop_id)
                    ->exists())
                {
                   $staffs = MStaff::create($request->all());
                    // upload image-------
                    $oldPath = $request->staff_img;
                    $namefile = strstr($oldPath,"/");
                    $newPath = 'upload/customer'.$namefile;
                    $pathThumbnail = 'upload/thumbnail/customer'.$namefile;
                    File::move( $oldPath, $newPath);
                    File::copy($newPath,$pathThumbnail);
                    $img = Image::make($pathThumbnail)->resize(Config::get('ponist.thumbnail.width'),Config::get('ponist.thumbnail.hight'), function ($constraint) {
                       $constraint->aspectRatio();
                     });
                     $img->save($pathThumbnail);
                     //--------------------
                     $staffs->staff_img = $newPath;
                    if ($staffs->save())
                    {
                        return response()
                            ->json($staffs, Config::get('ponist.status.OK'))->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
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
     * getStaff
     * パラメータのstaffIdのスタッフ情報を取得する。
     * @param Request $request $shop_id $staff_id
     * @return response
     */

    public function getStaff(Request $request, $shop_id, $staff_id)
    {
        $user = Auth::user();

        if (MShop::where('id', $shop_id)->exists())
        {
            $staffs = MStaff::where('id', $staff_id)->where('shop_id', $user->shop_id)->get();
            if ($staffs->count()>0)
            {
                return response()->json($staffs, Config::get('ponist.status.OK'));
            }else
            {
               return response()->json(["message" => Config::get('ponist.notification.MESSAGE40006') , 'errors' => [['field' => Config::get('ponist.notification.FIELD_ID') , 'code' => Config::get('ponist.notification.CODEINT') ]]], Config::get('ponist.status.BAD_REQUEST'))
                    ->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
            }

        }

    }
    /**
     * updateStaff
     * パラメータのstaffIdのスタッフ情報を更新する
     * @param  StaffsRequest $shop_id $staff_id
     * @return response
     */

    public function updateStaff(StaffsRequest $request, $shop_id, $staff_id)
    {
        try
        {
            return DB::connection()->transaction(function () use ($request, $shop_id, $staff_id)
            {
                $staffs = MStaff::find($staff_id);
                if (is_null($staffs))
                {
                    return response()->json(['message' => Config::get('ponist.notification.MESSAGE40006') , 'errors' => [['field' => Config::get('ponist.notification.FIELD_ID') , 'code' => Config::get('ponist.notification.CODEINT') ]]], Config::get('ponist.status.BAD_REQUEST'));
                }
                if ($staffs->updated_at == $request->updated_at)
                {
                   $updateStaff =  $request->all();
                   if ($staffs->staff_img != $request->staff_img) {
                        // upload image-------
                        $oldPath = $request->staff_img;
                        $namefile = strstr($oldPath,"/");
                        $newPath = 'upload/customer'.$namefile;
                        $pathThumbnail = 'upload/thumbnail/customer'.$namefile;
                        File::move( $oldPath, $newPath);
                        File::copy($newPath,$pathThumbnail);
                        $img = Image::make($pathThumbnail)->resize(Config::get('ponist.thumbnail.width'),Config::get('ponist.thumbnail.hight'), function ($constraint) {
                        $constraint->aspectRatio();
                        });
                        $img->save($pathThumbnail);
                        //--------------------
                        $updateStaff['staff_img']=$newPath;
                   }
                    $staffs->update($updateStaff);
                    return response()
                        ->json($updateStaff);
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
     * deleteStaff
     * パラメータのstaffIdのスタッフ情報を削除する。
     * @param Request $shop_id $staff_id
     * @return response
     */

    public function deleteStaff(Request $request, $shop_id, $staff_id)
    {
        try
        {
            return DB::connection()->transaction(function () use ($request, $shop_id, $staff_id)
            {
                if ($staffs = MStaff::find($staff_id))
                {
                    $staffs->delete();
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

