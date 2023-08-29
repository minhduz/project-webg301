<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Images extends Model
{
    use HasFactory;

    public function getAll()
    {
        $result = DB::table('images')->get();
        return $result;
    }

    public function getByProduct($id){
        return DB::table('images')->where('product_id',$id)->get();
    }

    public function addImage($data)
    {
        return DB::table('images')->insert([
            'image_url' => $data['image_url'],
            'product_id' => $data['product_id']
        ]);
    }

    public function updateImage($data){
        return DB::table('images')
            ->where('image_id',$data['image_id'])
            ->update([
                'image_url' => $data['image_url'],
            ]);
    }

    public function deleteImage($id){
        return DB::table('images')->where('image_id',$id)->delete();
    }

    public function deleteImageByProductId($id){
        return DB::table('images')->where('product_id',$id)->delete();
    }
}
