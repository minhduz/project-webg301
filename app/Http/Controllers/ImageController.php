<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Images;

class ImageController extends Controller
{

    public function __construct(){
        $this->image = new Images();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->has('sub_images')){
            foreach($request->file('sub_images') as $key=>$sub_image){
                $newSubImageName = time() . '-' . $request->name . '-' . $key . '.' . $sub_image->extension();

                $sub_image->move(public_path('images/products'),$newSubImageName);

                $status=$this->image->addImage([
                    'image_url' => $newSubImageName,
                    'product_id' => $request->id
                ]);
            }
        }

        return redirect()->route('editProduct', ['id' => $request->id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if(is_null($request->sub_images) == false ){

            $newImageName = time() . '-' . $request->name . '.' . $request->file('sub_images')->extension();

            $request->sub_images->move(public_path('images/products'), $newImageName);

            $status=$this->image->updateImage([
                'image_id' => $request->image_id,
                'image_url' => $newImageName,
            ]);

            if ($status > 0) {
                $msg = "Update Sub Image Successfully";
                $color = 'success';
            }

            session()->flash('msg', ['text' => $msg, 'color' => $color]);
        }

        return redirect()->route('editProduct', ['id' => $request->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $status=$this->image->deleteImage($request->image_id);

        if($status){
            $msg = "Delete Sub Image Successfullly";
            $color = "success";
        }

        session()->flash('msg', ['text' => $msg, 'color' => $color]);

        return redirect()->route('editProduct', ['id' => $request->id]);
    }

    public function destroyByProductId(Request $request){
        $status=$this->image->deleteImageByProductId($request->id);

        if($status){
            $msg = "Delete All Sub Image Successfullly";
            $color = "success";
        }

        session()->flash('msg', ['text' => $msg, 'color' => $color]);

        return redirect()->route('editProduct', ['id' => $request->id]);
    }
}
