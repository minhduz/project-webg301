<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catalogs;
use App\Models\Products;
use App\Models\Images;

class ProductController extends Controller
{
    public function __construct(){
        $this->product = new Products();
        $this->catalog = new Catalogs();
        $this->image = new Images();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listCatalog = $this->catalog->getAll();
        $listProduct = $this->product->getAll();


        return view('admin.products',compact('listProduct','listCatalog'));
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
                'price' => 'required',
                'main_image' => 'required|mimes:jpg,png,jpeg',
                'weight' => 'required',
                'status' => 'required',
                'catalog_id' => 'integer|min:1'
            ],
            [
                'name.required' => 'Name field can not be empty',
                'name.max' => 'Name is too long',
                'price.required' => 'Price field can not be empty',
                'main_image.required' => 'Main Image field can not be empty',
                'main_image.mimes:jpg,png,jpeg' => 'Incorrect image format (.jpg, .png, .jpeg)',
                'weight.required' => 'Weight field can not be empty',
                'status.required' => 'Status can not be empty',
                'catalog_id.min' => 'You have to select a catalog'
            ]
        );

        $newImageName = time() . '-' . $request->name . '.' . $request->file('main_image')->extension();

        $request->main_image->move(public_path('images/products'), $newImageName);



        $product_id=$this->product->addProduct([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'main_image_url' => $newImageName,
            'weight' => $request->weight,
            'status' => $request->status,
            'catalog_id' => $request->catalog_id
        ]);

        if($request->has('sub_images')){
            foreach($request->file('sub_images') as $key=>$sub_image){
                $newSubImageName = time() . '-' . $request->name . '-' . $key . '.' . $sub_image->extension();

                $sub_image->move(public_path('images/products'),$newSubImageName);

                $status=$this->image->addImage([
                    'image_url' => $newSubImageName,
                    'product_id' => $product_id
                ]);
            }
        }

        if(is_null($product_id) == false){
            $msg = "Add Product Successfullly";
            $color = "success";
        }

        session()->flash('msg', ['text' => $msg, 'color' => $color]);

        return redirect()->route('listProduct');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product=$this->product->getById($id);
        $listImage=$this->image->getByProduct($id);

        return view('admin.product_detail',compact('product','listImage'));
    }

    public function getByCatalog($id)
    {
        $listProduct=$this->product->getByCatalog($id);
        $catalog=$this->catalog->getByID($id);
        return view('client.catalog',compact('listProduct','catalog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $listCatalog = $this->catalog->getAll();
        $product=$this->product->getById($id);
        $listImage=$this->image->getByProduct($id);
        return view('admin.update_product',compact('product','listCatalog','listImage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|max:255',
                'price' => 'required',
                'weight' => 'required',
                'status' => 'required'
            ],
            [
                'name.required' => 'Name field can not be empty',
                'name.max' => 'Name is too long',
                'price.required' => 'Price field can not be empty',
                'weight.required' => 'Weight field can not be empty',
                'status.required' => 'Status can not be empty'
            ]
        );

        $status=$this->product->updateProduct([
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'weight' => $request->weight,
            'status' => $request->status,
            'catalog_id' => $request->catalog_id
        ]);

        if ($status > 0) {
            $msg = "Update Product Successfully";
            $color = 'success';
        } elseif ($status == 0) {
            $msg = "No changes are made to the Product";
            $color = 'warning';
        }

        session()->flash('msg', ['text' => $msg, 'color' => $color]);

        return redirect()->route('editProduct', ['id' => $request->id]);
    }

    public function updateMainImage(Request $request){

        if(is_null($request->main_image) == false ){

            $newImageName = time() . '-' . $request->name . '.' . $request->file('main_image')->extension();

            $request->main_image->move(public_path('images/products'), $newImageName);

            $status=$this->product->updateMainImage([
                'id' => $request->id,
                'main_image_url' => $newImageName,
            ]);

            if ($status > 0) {
                $msg = "Update Main Image Successfully";
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
        $statusImage=$this->image->deleteImageByProductId($request->id);

        $statusProduct=$this->product->deleteProduct($request->id);

        if($statusProduct && $statusImage){
            $msg = "Delete Product Successfullly";
            $color = "success";
        }



        return redirect()->route('listProduct');
    }
}
