<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\View;
use Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public  function storeImage($folderName,$file){
        try{
            return Storage::disk('website')->put($folderName, $file);
        }catch(\Exception $e){
            return '';
        }//end trycatch.
    }//end storeImage function.
    public  function storeImageToStorageFolder($folderName,$file){
        try{
            return Storage::disk('storage')->put($folderName, $file);
        }catch(\Exception $e){
            return '';
        }//end trycatch.
    }//end storeImageToStorageFolder function.
    public function deleteImage($file){
        try{
            return Storage::disk('website')->delete($file);
        }catch(\Exception $e){
            return '';
        }//end trycatch.
    }//end storeImage function.

}
