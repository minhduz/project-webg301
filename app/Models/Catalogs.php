<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Catalogs extends Model
{
    use HasFactory;

    public function getAll()
    {
        $result = DB::table('catalogs')->get();
        return $result;
    }

    public function getByID($id){
        return DB::table('catalogs')->where('catalog_id',$id)->first();
    }

    public function addCatalog($data)
    {
        return DB::table('catalogs')->insert([
            'name' => $data['name'],
            'status' => $data['status']
        ]);
    }

    public function updateCatalog($data){
        return DB::table('catalogs')
            ->where('catalog_id',$data['id'])
            ->update([
                'name' => $data['name'],
                'status' => $data['status']
            ]);
    }

    public function deleteCatalog($id){
        return DB::table('catalogs')->where('catalog_id',$id)->delete();
    }

}
