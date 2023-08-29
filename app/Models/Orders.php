<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Orders extends Model
{
    use HasFactory;

    public function getAllCart($id){
        $result = DB::select("SELECT
            o.order_id,
            ord.order_detail_id,
            ord.quantity,
            ord.product_id,
            pr.product_id,
            pr.name,
            pr.main_image_url,
            pr.price
        FROM orders o LEFT JOIN users us ON o.id = us.id
        RIGHT JOIN order_details ord ON o.order_id = ord.order_id
        JOIN products pr ON ord.product_id = pr.product_id
        WHERE us.id = $id and o.status = 0");
        return $result;
    }

    public function createCart($id){
        return DB::table('orders')->insertGetId([
            'id' => $id,
            'status' => 0
        ]);
    }

    public function isHasCart($id){
        return DB::table('orders')
        ->where('id',$id)
        ->where('status', 0)
        ->first();
    }

    public function addToCart($data){
        return DB::table('order_details')->insert([
            'quantity' => $data['quantity'],
            'order_id' => $data['order_id'],
            'product_id' => $data['product_id']
        ]);
    }

    public function isHasProduct($data){
        return DB::table('order_details')
        ->where('product_id',$data['product_id'])
        ->where('order_id',$data['order_id'])
        ->first();
    }

    public function changeQuantity($data){
        return DB::table('order_details')
            ->where('product_id',$data['product_id'])
            ->where('order_id',$data['order_id'])
            ->update([
                'quantity' => $data['quantity'],
            ]);
    }

}
