<?php

namespace App\Helper;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImageHandler
{
    public static function uploads($file, $path,$name)
    {
        if($file) {

            $fileName   = $name.'_'.time().'.'.$file->getClientOriginalExtension();;
            Storage::disk('public')->put($path . $fileName, File::get($file));
            $filePath   = 'storage/'.$path . $fileName;

            return $file = [
                'fileName' => $fileName,
                'filePath' => $filePath,
            ];
        }
    }
    public static function delete($file,$type){
        if($type=="blog"){
            Storage::disk('public')->delete('/blog/'.$file);
        }
        return ['status' => 'success'];
    }

   
}
