<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catalogs;

class CatalogController extends Controller
{

    public function __construct(){
        $this->catalog = new Catalogs();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listCatalog = $this->catalog->getAll();
        return view('admin.catalogs',compact('listCatalog'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|max:255',
                'status' => 'required'
            ],
            [
                'name.required' => 'Name field can not be empty',
                'name.max' => 'Name is too long',
                'status.required' => 'Status can not be empty'
            ]
        );

        $status=$this->catalog->addCatalog([
            'name' => $request->name,
            'status' => $request->status
        ]);

        if($status){
            $msg = "Add Catalog Successfullly";
            $color = "success";
        }

        session()->flash('msg', ['text' => $msg, 'color' => $color]);

        return redirect()->route('listCatalog');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate(
            [
                'id' => 'required',
                'name' => 'required|max:255',
                'status' => 'required'
            ],
            [
                'name.required' => 'Name field can not be empty',
                'password.max' => 'Name is too long',
                'status.required' => 'Status can not be empty'
            ]
        );

        $status=$this->catalog->updateCatalog([
            'id' => $request->id,
            'name' => $request->name,
            'status' => $request->status
        ]);

        if ($status > 0) {
            $msg = "Update Catalog Successfully";
            $color = 'success';
        } elseif ($status == 0) {
            $msg = "No changes are made to the Catalog";
            $color = 'warning';
        }

        session()->flash('msg', ['text' => $msg, 'color' => $color]);

        return redirect()->route('listCatalog');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $status=$this->catalog->deleteCatalog($request->id);

        if($status){
            $msg = "Delete Catalog Successfullly";
            $color = "success";
        }

        session()->flash('msg', ['text' => $msg, 'color' => $color]);

        return redirect()->route('listCatalog');
    }
}
