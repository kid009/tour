<?php

namespace app\components;

use Yii;
use yii\base\Component;
use \yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;

class UploadComponent extends Component {

    public $upload_foler = 'uploads';

    public function Importimage($model, $perfixName, $path, $attribute) 
    {
        $image = UploadedFile::getInstance($model, $attribute);
        $date = date("YmdHisu");
        if ($image !== null) {

            $filename = $perfixName . '_' . md5($image->baseName) . '_' . $date . '.' . $image->extension;

            //create directory
            if (!is_dir($path)) {
                mkdir($path, "0777", true);
            }        
            
            if ($image->saveAs($path . $filename)) {
                //resize image
                //Image::getImagine()->open($path . $filename)->resize(new Box(1280, 1024))->save($path.$filename);
                return $filename;
            }
        }

        return $model->isNewRecord ? false : $model->getOldAttribute($attribute);
    }//ImportImage

    public function Updateimage($image_old, $model, $perfixName, $path, $attribute) 
    {
        $image = UploadedFile::getInstance($model, $attribute);

        if ($image !== null) {
            @unlink(Yii::getAlias('@webroot/' . $path) . $image_old);

            $date = date("YmdHisu");
            $filename = $perfixName . '_' . md5($image->baseName) . '_' . $date . '.' . $image->extension;
            
            //create directory
            if (!is_dir($path)) {
                mkdir($path, "0777", true);
            }

            if ($image->saveAs($path . $filename)) {
                //Image::thumbnail($path . $filename, 1280, 1024)->save($path.$filename);
                //Image::getImagine()->open($path . $filename)->resize(new Box(1280, 1024))->save($path.$filename);
                return $filename;
            }
        }
        return $model->isNewRecord ? false : $model->getOldAttribute($attribute);
    }//Updateimage
    
    public function ImportSlideImage($model, $perfixName, $path, $attribute) 
    {
        $image = UploadedFile::getInstance($model, $attribute);
        $date = date("YmdHisu");
        if ($image !== null) {

            $filename = $perfixName . '_' . md5($image->baseName) . '_' . $date . '.' . $image->extension;

            //create directory
            if (!is_dir($path)) {
                mkdir($path, "0777", true);
            }        
            
            if ($image->saveAs($path . $filename)) {
                //Image::thumbnail($path . $filename, 1900, 600)->save($path.$filename);
                //Image::getImagine()->open($path . $filename)->resize(new Box(1900, 600))->save($path.$filename);
                return $filename;
            }
        }

        return $model->isNewRecord ? false : $model->getOldAttribute($attribute);
    }//ImportImage
    
    public function UpdateSlideImage($image_old, $model, $perfixName, $path, $attribute) 
    {
        $image = UploadedFile::getInstance($model, $attribute);

        if ($image !== null) {
            @unlink(Yii::getAlias('@webroot/' . $path) . $image_old);

            $date = date("YmdHisu");
            $filename = $perfixName . '_' . md5($image->baseName) . '_' . $date . '.' . $image->extension;
            
            //create directory
            if (!is_dir($path)) {
                mkdir($path, "0777", true);
            }

            if ($image->saveAs($path . $filename)) {
                //Image::getImagine()->open($path . $filename)->resize(new Box(1900, 600))->save($path.$filename);
                return $filename;
            }
        }
        return $model->isNewRecord ? false : $model->getOldAttribute($attribute);
    }//Updateimage
}

//class