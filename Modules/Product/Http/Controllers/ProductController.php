<?php

namespace Modules\Product\Http\Controllers;

use Modules\Product\DataTables\ProductDataTable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Modules\Product\Entities\Product;
use Modules\Product\Http\Requests\StoreProductRequest;
use Modules\Product\Http\Requests\UpdateProductRequest;
use Modules\Upload\Entities\Upload;
use Modules\Product\Entities\Category;

class ProductController extends Controller
{

    public function index(ProductDataTable $dataTable) {
        abort_if(Gate::denies('access_products'), 403);

        return $dataTable->render('product::products.index');
    }


    public function create() {
        abort_if(Gate::denies('create_products'), 403);

        // Ambil kode produk terakhir
        $lastProduct = Product::orderBy('id', 'desc')->first();

        if ($lastProduct && is_numeric($lastProduct->product_code)) {
            $number = (int) $lastProduct->product_code + 1;
        } else {
            $number = 1;
        }

        $productCode = str_pad($number, 7, '0', STR_PAD_LEFT);

        return view('product::products.create', compact('productCode'));
    }


    public function store(StoreProductRequest $request) {
        $product = Product::create($request->except('document'));

        if ($request->has('document')) {
            foreach ($request->input('document', []) as $file) {
                $product->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('images');
            }
        }

        toast('Product Created!', 'success');

        return redirect()->route('products.index');
    }


    public function show(Product $product) {
        abort_if(Gate::denies('show_products'), 403);

        return view('product::products.show', compact('product'));
    }


    public function edit(Product $product) {
        abort_if(Gate::denies('edit_products'), 403);

        return view('product::products.edit', compact('product'));
    }


    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->except('document'));

        $documents = $request->input('document', []);

        /*
        |--------------------------------------------------------------------------
        | Ambil media yang masih ada
        |--------------------------------------------------------------------------
        */
        $existingMedia = $product->getMedia('images')
            ->pluck('file_name')
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | Tambahkan file baru dari Dropzone
        |--------------------------------------------------------------------------
        */
        foreach ($documents as $file) {

            // File sudah ada di Media Library
            if (in_array($file, $existingMedia)) {
                continue;
            }

            $tempPath = storage_path('app/temp/dropzone/' . $file);

            // Pastikan file temporary masih ada
            if (!file_exists($tempPath)) {
                continue;
            }

            $product
                ->addMedia($tempPath)
                ->toMediaCollection('images');
        }

        toast('Product Updated!', 'info');

        return redirect()->route('products.index');
    }


    public function destroy(Product $product) {
        abort_if(Gate::denies('delete_products'), 403);

        $product->delete();

        toast('Product Deleted!', 'warning');

        return redirect()->route('products.index');
    }

    public function katalog() {
        $product = Product::all();
        $product_categories = Category::all();

        return view('product::products.katalog', compact('product','product_categories'));
    }

}
