<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \File;
use App\Models\Product;
use App\Models\Image;

class ImageController extends Controller
{
  /*
   * create folder for current mont
   */
  public function getDirectoryCreated()
  {
    $year = date('Y');$month = date('m');
    $path = public_path('uploads/'.$year);
    if(!File::isDirectory($path)){
        File::makeDirectory($path, 0777, true, true);
        $subpath = public_path('uploads/'.$year.'/'.$month);
        if(!File::isDirectory($subpath)){
            File::makeDirectory($subpath, 0777, true, true);
        }
    }
    else {
      $subpath = public_path('uploads/'.$year.'/'.$month);
      if(!File::isDirectory($subpath)){
        //echo "here";
          File::makeDirectory($subpath, 0777, true, true);
      }
    }
    //echo env('Imagesize');
    //echo 'done';
  }

  /*
   * for multiple file upload with watermark
   */
  public  function multifileupload($files, $type, $pid=""){
      $uploaded = array();
      $failed = array();
      $thumbsizes = explode(",", env('Imagesize'));
      //echo $pid;exit;
      $allowed = array('jpeg','jpg','png');
      $this->getDirectoryCreated();
      //$imag = 0;
      foreach($files['name'] as $position => $file_name){
          $file_temp = $files['tmp_name'][$position];
          $file_size = $files['size'][$position];
          $file_error = $files['error'][$position];
          $date = date_create();
          $d =  date_timestamp_get($date);
          $file_ext_arr = explode('.',$file_name);
          $file_ext = strtolower(end($file_ext_arr));

          if(in_array($file_ext,$allowed)){
              if($file_error === 0){
                  if($file_size <= 8388608){ //8mb = 5*1024*1024

                      $file_name_new  = $d.'-'.$file_name;
                      $filePath = 'uploads/'.date('Y').'/'.date('m').'/'.$file_name_new;

                      if(move_uploaded_file($file_temp,$filePath)){
                          if($file_ext == 'jpeg' || $file_ext == 'jpg')
                              $im = imagecreatefromjpeg($filePath);
                          elseif($file_ext == 'png')
                              $im = imagecreatefrompng($filePath);

                          $uploaded[0] = $filePath;
                          $iCount = 1;
                          foreach($thumbsizes as $thumb)
                          {
                            $tarr = explode('x', $thumb);
                            $thumb_destination = 'uploads/'.date('Y').'/'.date('m').'/'.$d.'-'.$file_ext_arr[0].'-'.$thumb.'.'.$file_ext_arr[1];
                            $uploaded[$iCount] = $thumb_destination;
                            $this->createThumbnail($filePath, $thumb_destination, $tarr[0], $tarr[1]);
                            $iCount++;
                          }
                          if($pid!="")
                          {
                            if($type=='featured')
                            {
                              $product = Product::where('id', $pid)->first();
                              $product->images = $filePath;
                              $product->update();
                              $pimg = Image::where('pid', $pid)->where('type', 'featured')->first();
                              if(!empty($pimg))
                              {
                                $fimages = unserialize($pimg->images);
                                foreach($fimages as $fi)
                                {
                                  if(!empty($fi))
                                    @unlink(realpath($fi));
                                }
                                Image::destroy($pimg->id);
                              }
                              Image::insert(array('pid'=>$pid, 'type'=>$type, 'images'=>serialize($uploaded)));
                            }
                            else {
                              Image::insert(array('pid'=>$pid, 'type'=>$type, 'images'=>serialize($uploaded)));
                            }
                          }

                      }
                      else{
                          $failed[$position] = "[$file_name] failed to upload.";
                      }
                  }
                  else{
                      $failed[$position] = "[$file_name] is too large";
                  }
              }
              else{
                  $failed[$position] = "[$file_name] errored with code {$file_error}";
              }
          }
          else{
              $failed[$position] = "[$file_name] file extension '{$file_ext}' not allowed.";
          }
          //$imag++;
      }
      if(!empty($uploaded)){
          return $uploaded;
      }

  }

  public function createThumbnail($src, $dest, $desired_width, $desired_height, $relative='false') {
    /* read the source image */
    list($original_width, $original_height, $original_type) = getimagesize($src);
    if($original_type==2)
      $source_image = imagecreatefromjpeg($src);
    elseif($original_type==3)
      $source_image = imagecreatefrompng($src);
    else
      return false;
    $width = imagesx($source_image);
    $height = imagesy($source_image);

    if ($original_type === 1) {
        $imgt = "ImageGIF";
        $imgcreatefrom = "ImageCreateFromGIF";
    } else if ($original_type === 2) {
        $imgt = "ImageJPEG";
        $imgcreatefrom = "ImageCreateFromJPEG";
    } else if ($original_type === 3) {
        $imgt = "ImagePNG";
        $imgcreatefrom = "ImageCreateFromPNG";
    } else {
        return false;
    }

    if($relative == 'true')
    {
      /* find the "desired height" of this thumbnail, relative to the desired width  */
      $relative_height = floor($height * ($desired_width / $width));
      $desired_height = $relative_height;
    }


    /* create a new, "virtual" image */
    $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

    /* copy source image at a resized size */
    imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

    /* create the physical thumbnail image to its destination */
    $imgt($virtual_image, $dest);
    //imagejpeg($virtual_image, $dest);
  }

  public function createThumbnail1($filepath, $thumbpath, $thumbnail_width, $thumbnail_height, $background=false) {
      list($original_width, $original_height, $original_type) = getimagesize($filepath);
      if ($original_width > $original_height) {
          $new_width = $thumbnail_width;
          $new_height = intval($original_height * $new_width / $original_width);
      } else {
          $new_height = $thumbnail_height;
          $new_width = intval($original_width * $new_height / $original_height);
      }
      $dest_x = intval(($thumbnail_width - $new_width) / 2);
      $dest_y = intval(($thumbnail_height - $new_height) / 2);

      if ($original_type === 1) {
          $imgt = "ImageGIF";
          $imgcreatefrom = "ImageCreateFromGIF";
      } else if ($original_type === 2) {
          $imgt = "ImageJPEG";
          $imgcreatefrom = "ImageCreateFromJPEG";
      } else if ($original_type === 3) {
          $imgt = "ImagePNG";
          $imgcreatefrom = "ImageCreateFromPNG";
      } else {
          return false;
      }

      $old_image = $imgcreatefrom($filepath);
      $new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height); // creates new image, but with a black background

      // figuring out the color for the background
      if(is_array($background) && count($background) === 3) {
        list($red, $green, $blue) = $background;
        $color = imagecolorallocate($new_image, $red, $green, $blue);
        imagefill($new_image, 0, 0, $color);
      // apply transparent background only if is a png image
      } else if($background === 'transparent' && $original_type === 3) {
        imagesavealpha($new_image, TRUE);
        $color = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
        imagefill($new_image, 0, 0, $color);
      }

      imagecopyresampled($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
      $imgt($new_image, $thumbpath);
      return file_exists($thumbpath);
  }

  /*
   * for multiple file upload without watermark
   */
  public  function multifileuploadwithoutwatermark($files, $dest=""){
      $uploaded = array();
      $failed = array();

      $allowed = array('jpeg','jpg','png');
      //print_r($files);exit;
      foreach($files['name'] as $position => $file_name){
          $file_temp = $files['tmp_name'][$position];
          $file_size = $files['size'][$position];
          $file_error = $files['error'][$position];
          $date = date_create();
          $d =  date_timestamp_get($date);
          $file_ext = explode('.',$file_name);
          $file_ext = strtolower(end($file_ext));

          if(in_array($file_ext,$allowed)){
              if($file_error === 0){
                  if($file_size <=  5242880 ){ //5mb = 5*1024*1024

                      $file_name_new  = $d.'-'.$file_name;
                      // if($folder!="")
                      //   $file_destination = 'photos/'.$folder.'/'.$file_name_new;
                      // else
                      if($dest!="")
                        $file_destination = 'photos/'.$dest.'/'.$file_name_new;
                      else
                        $file_destination = 'photos/'.$file_name_new;



                      if(move_uploaded_file($file_temp,$file_destination)){
                          $stamp = imagecreatefrompng('img/backend/watermark-1.png');

                          if($file_ext == 'jpeg' || $file_ext == 'jpg')
                              $im = imagecreatefromjpeg($file_destination);
                          elseif($file_ext == 'png')
                              $im = imagecreatefrompng($file_destination);
                          $marge_right= 20;
                          $marge_bottom = 50;
                          $sx = imagesx($stamp);
                          $sy = imagesy($stamp);
                          //imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
                          imagejpeg($im, $file_destination); //This overwrite your original image

                          $uploaded[$position] = "/".$file_destination;
                      }
                      else{
                          $failed[$position] = "[$file_name] failed to upload.";
                      }
                  }
                  else{
                      $failed[$position] = "[$file_name] is too large";
                  }
              }
              else{
                  $failed[$position] = "[$file_name] errored with code {$file_error}";
              }
          }
          else{
              $failed[$position] = "[$file_name] file extension '{$file_ext}' not allowed.";
          }

      }
      if(!empty($uploaded)){
          return $uploaded;
      }
      if(!empty($failed)){

      }

  }
}
