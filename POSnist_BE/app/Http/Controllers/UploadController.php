<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Config;
use App\Http\Requests\UploadRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Image;

class UploadController extends Controller
{
    //
    public function uploadFile(Request $request)
    {
        if($request->hasFile('file')) {
            $nameWithExtension = $request->file('file')->getClientOriginalName();
            $name = pathinfo($nameWithExtension, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $date = Carbon::now()->toDateString();
            $dateTime = Carbon::now()->format('Y-m-d_H_i_s');
            $filename = 'tmp_'.$date.'/'.hash('ripemd160', $name.'_'.$dateTime).'.'.$extension;
            $fileNameTmp= $request->file('file')->Move('tmp_'.$date, $filename);
            $data = getimagesize($fileNameTmp);
            $imgsizes = $fileNameTmp->getSize();
            $width = $data[0];
            $height = $data[1];
            return response()->json([
                'file_name'=>  $nameWithExtension,
                'path'=> $filename,
                'width' => $width,
                'height'=> $height,
                'size'=>$imgsizes.' bytes',
                'url'=>Config::get('ponist.baseurl')  .$fileNameTmp
            ], Config::get('ponist.status.OK'))->header('Content-Type', Config::get('ponist.header.CONTENT_APPLICATION'));
        } else
        return "";
    }
}
