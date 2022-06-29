<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $per_page = 10;
        $order_col = 'product_id';
        $order_asc = 'desc';
        $keyword = $request->get('keyword');

        $query = Product::with('categories');
        if ($keyword) {
            $query->where(function($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%");
                $q->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        $query->orderBy($order_col, $order_asc);

        $products = $query->paginate($per_page);

        return view('admin.pages.products.index', [
            'products' => $products,
        ]);
    }

    public function create(Request $request)
    {
        return view('admin.pages.products.form', [
            'product' => new product,
            'title' => 'Tambah Produk',
        ]);
    }

    public function store(Request $request)
    {
        $product = new Product;
        $this->save($product, $request);

        return redirect()
            ->route('admin::products.index')
            ->with('info', "Produk '{$product->title}' berhasil ditambahkan.");
    }

    public function show(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        return view('admin.pages.products.show', [
            'product' => $product
        ]);
    }

    public function edit(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        return view('admin.pages.products.form', [
            'product' => $product,
            'title' => "Edit Produk",
        ]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $this->save($product, $request);

        return redirect()
            ->route('admin::products.index')
            ->with('info', "Produk '{$product->title}' berhasil di update.");
    }

    public function delete(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return back()
            ->with('info', "Produk '{$product->title}' telah dihapus.");
    }

    public function save(product $product, Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'cover' => $product->exists ? 'image|mimes:jpeg,png' : 'required|image|mimes:jpeg,png',
            'stock' => 'required|numeric',
            'price' => 'required|numeric',
            'category_ids.*' => 'numeric|exists:categories,category_id',
        ]);

        $cover = $request->file('cover');
        if ($cover) {
            // Hapus cover yg lama
            if ($product->cover) {
                Storage::disk('uploads')->delete("products/{$product->cover}");
            }

            // Simpan cover
            $cover_filename = str_slug($request->get('title')).'.'.$cover->extension();
            $cover->storeAs('products', $cover_filename, 'uploads');

            // Set nilai cover baru
            $product->cover = $cover_filename;
        }

        $product->title = $request->get('title');
        $product->slug = str_slug($product->title);
        $product->description = $request->get('description');
        $product->stock = $request->get('stock');
        $product->price = $request->get('price');
        $product->save();

        $category_ids = $request->get('category_ids');
        $product->categories()->sync($category_ids);
    }
}
