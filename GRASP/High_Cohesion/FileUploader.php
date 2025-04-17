<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

trait FileUploader
{
    /**
     * For Upload Images.
     * @param mixed $request
     * @param mixed $data
     * @param mixed $name
     * @param mixed|null $inputName
     * @return bool|string
     */
    public function uploadImage($request, $model ='users/' ,$inputName = 'image')
    {
        $requestFile = $request->file($inputName);
        try {
            $name = time();
            $dir = 'public/images/'.$model;
            $fixName = $name.'.'.$requestFile->extension();
            if ($requestFile) {
                Storage::putFileAs($dir, $requestFile, $fixName);
            }

            return 'images/'.$model.$fixName;
        } catch (Exception $e) {
            Log::critical("upload  image trait uploadfile  error ".$e->getMessage());
            abort(500);
        }
    }
    /**
     * @param mixed $file
     * @param mixed $model="/assessment_works"
     * 
     * @return [type]
     */
    public function uploadFile($file , $model="/assessment_works")
    {
        try {
            $dir = 'public'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.$model;
            $fixName = $file;
            Storage::putFileAs($dir, $file, $fixName);
            return 'files'.$model.DIRECTORY_SEPARATOR.$fixName;
        } catch (Exception $e) {
            Log::critical("upload  image trait uploadfile  error ".$e->getMessage());
            abort(500);
        }
    }
    /**
     * @param mixed $file
     * 
     * @return [type]
     */
    public function deleteFilePublic($file)
    {
        try{
            if(file_exists($file)){
                unlink(public_path($file));
            }
        }catch(Exception $e){
            Log::critical("delete  file trait form public  error ".$e->getMessage());

        }
        
    }
    /**
     * @param string $fileName
     * 
     * @return [type]
     */
    public function deleteImage($fileName = 'images')
    {
        try {
          
            if($fileName) {
                Storage::delete($fileName);
            }

            return true;
        } catch (Exception $e) {
            Log::critical("delete image trait uploadfile  error ".$e->getMessage());
            abort(500);
        }
    }
}