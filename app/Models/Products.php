<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Products extends Model
{
    use HasFactory;

    public function getAll()
    {
        $result = DB::select("SELECT pro.product_id,pro.name,pro.price,pro.description,pro.main_image_url,pro.weight,pro.status,cat.name
        as catalog_name,cat.catalog_id
        FROM products pro join catalogs cat on pro.catalog_id = cat.catalog_id");
        return $result;
    }

    public function getById($id){
        $result = DB::select("SELECT pro.product_id,pro.name,pro.price,pro.description,pro.main_image_url,pro.weight,pro.status,
        cat.name as catalog_name,cat.catalog_id as catalog_id
        FROM products pro join catalogs cat on pro.catalog_id = cat.catalog_id where pro.product_id = $id");
        return $result;
    }

    public function getByCatalog($id){
        return DB::table('products')->where('catalog_id',$id)->get();
    }

    public function addProduct($data)
    {
        return DB::table('products')->insertGetId([
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => $data['description'],
            'main_image_url' => $data['main_image_url'],
            'weight' => $data['weight'],
            'status' => $data['status'],
            'catalog_id' => $data['catalog_id'],
        ]);
    }

    public function updateProduct($data){
        return DB::table('products')
            ->where('product_id',$data['id'])
            ->update([
                'name' => $data['name'],
                'price' => $data['price'],
                'description' => $data['description'],
                'weight' => $data['weight'],
                'catalog_id' => $data['catalog_id'],
                'status' => $data['status']
            ]);
    }

    public function updateMainImage($data){
        return DB::table('products')
            ->where('product_id',$data['id'])
            ->update([
                'main_image_url' => $data['main_image_url'],
            ]);
    }

    public function deleteProduct($id){
        return DB::table('products')->where('product_id',$id)->delete();
    }
}
