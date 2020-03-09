<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductTypes;
use Illuminate\Support\Facades\File;


class ProductTypeController extends Controller
{
    public function index(){

        $all_producttype = ProductTypes::all();
        return view('admin/producttypes/index',compact('all_producttype'));

    }

    public function create(){
        return view('admin/producttypes/create');

    }

    public function store (Request $request){
        $products_data = $request->all();
        //可先dd
        // dd($news_data);

        // //上傳檔案
        // $file_name = $request->file('img')->store('','public');
        // $news_data['img'] = $file_name;

        //上傳主要圖片
        // if($request->hasFile('img')) {
        //     $file = $request->file('img');
        //     $path = $this->fileUpload($file,'producttype');
        //     $products_data['img'] = $path;

        // }

        ProductTypes::create($products_data);

        return redirect('/home/productType');



        //     //多張圖片上傳

        //     if($request->hasFile('news_imgs')){

        //     $files = $request->file('news_imgs');

        //     foreach ($files as $file) {
        //         //上傳圖片
        //         $path = $this->fileUpload($file,'_news_imgs');

        //         //新增資料進DB

        //         $news_imgs = new NewsImgs;
        //         $news_imgs->news_id = $new_news->id;
        //         $news_imgs->img_url = $path;
        //         $news_imgs->save();

        //         }
        //     }



            //ID位置要一致
            // News::create ($news_data);

    }
    public function edit ($id){

        // $news = News::where('id','=',$id)->first();
        $productTypes= ProductType ::all();
        $products = Products::with("products_imgs")->find($id);
        return view('admin/products/edit',compact('products'));
    }
    public function update (Request $request,$id){

        $request_data = $request->all();
        $item = Products::find($id);

        //假如上傳新圖片
        if($request->hasFile('img')){

            //舊圖片就要刪除
            $old_image = $item->img;
            File::delete(public_path().$old_image);

            //再上傳新圖片
            $file = $request->file('img');
            $path = $this->fileUpload($file,'products');
            $request_data['img'] = $path;

        }
        //update多張圖片

        // if($request->hasFile('news_imgs')){

        //     $files = $request->file('news_imgs');

        //     foreach($files as $file){

        //     $path = $this->fileUpload($file,'news');


        //     $news_imgs = new NewsImgs;

        //     $news_imgs->news_id = $item->id;
        //     $news_imgs->img_url = $path;
        //     $news_imgs->save();

        //     }



        // }

        $item->update($request_data);
        return redirect('/home/products');
    }
    public function delete (Request $request,$id){

        $item = Products::find($id);

        $old_image = $item->img;

        //下判斷式
        if(file_exists(public_path().$old_image)){
            File::delete(public_path().$old_image);


        }

        $item->delete();

        $news_imgs = ProductType::where('news_id',$id)->get();
        foreach($news_imgs as $news_img){
            $old_image = $news_img->img_url;
            if(file_exists(public_path().$old_image)){
                File::delete(public_path().$old_image);

            }
            $news_img->delete();

        }

        return redirect('/home/products');
    }
    private function fileUpload($file,$dir){
        //防呆：資料夾不存在時將會自動建立資料夾，避免錯誤
        if( ! is_dir('upload/')){
            mkdir('upload/');
        }
        //防呆：資料夾不存在時將會自動建立資料夾，避免錯誤
        if ( ! is_dir('upload/'.$dir)) {
            mkdir('upload/'.$dir);
        }
        //取得檔案的副檔名
        $extension = $file->getClientOriginalExtension();
        //檔案名稱會被重新命名
        $filename = strval(time().md5(rand(100, 200))).'.'.$extension;
        //移動到指定路徑
        move_uploaded_file($file, public_path().'/upload/'.$dir.'/'.$filename);
        //回傳 資料庫儲存用的路徑格式
        return '/upload/'.$dir.'/'.$filename;
    }
}