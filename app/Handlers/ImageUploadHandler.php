<?php
namespace App\Handlers;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ImageUploadHandler{
    protected $allowed_ext=['png','jpg','gif','jpeg'];
    public function save(UploadedFile $file,string $folder,$file_prefix,$max_width=false)
    {
        $folder_name="uploads/images/$folder/".date('Ym/d',time());
        $extension=strtolower($file->getClientOriginalExtension())?:'png';
        $filename=$file_prefix.'_'.time().'_'.Str::random(10).'.'.$extension;
        if(!in_array($extension,$this->allowed_ext)){
            return false;
        }
        $filepath=$file->storeAs($folder_name,$filename,'public');
        $path=storage_path('app/public/').$folder_name.$filename;
        if($max_width&&$extension!='gif'){
            $this->reduceSize($path,$max_width);
        }
        return ['path'=>$filepath];
    }
    public function reduceSize(string $filepath,$max_width)
    {
        $image=Image::make($filepath);
        $image->resize($max_width,null,function($constraint){
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $image->save();
    }
}