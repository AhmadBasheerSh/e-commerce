<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
{
    public function index()
    {
        $products_slider = Product::orderByDesc('id')->where('quantity','>',0)->take(3)->get();
        $categories = Category::orderByDesc('id')->take(3)->get();
        $products_latest = Product::orderByDesc('id')->where('quantity','>',0)->take(9)->offset(3)->get();
        return view('site.index', compact('products_slider', 'categories', 'products_latest'));
    }

    public function about()
    {
        return view('site.about');
    }

    public function shop()
    {
        $products = Product::orderByDesc('id')->paginate(6);
        return view('site.shop', compact('products'));
    }

    public function category($id)
    {
        $category = Category::findOrFail($id);
        // $chlidrin = $category->children;
        // $products = $category->products()->orderByDesc('id')->paginate(6);
        // foreach($chlidrin as $chlid){
        //     $products += $chlid->products()->orderByDesc('id')->paginate(6);
        // }
        $products = Product::where(function($query) use ($category) {
            $query->where('category_id', $category->id)
                  ->orWhereHas('category', function($query) use ($category) {
                      $query->where('parent_id', $category->id);
                  });
        })
        ->orderByDesc('id')
        ->paginate(6);

        return view('site.shop', compact('products', 'category'));
    }

    public function contact()
    {
        return view('site.contact');
    }

    public function search(Request $request)
    {
        $products = Product::orderByDesc('id')->where('name', 'like', '%'.$request->q.'%')->paginate(6);

        return view('site.search', compact('products'));
    }

    public function product($slug)
    {
        $product = Product::where('slug', $slug)->first();
        if(!$product) {
            abort(404);
        }

        $next = Product::where('id', '>', $product->id)->first();
        $prev = Product::where('id', '<', $product->id)->orderByDesc('id')->first();

        $related = Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->get();

        return view('site.product', compact('product', 'next', 'prev', 'related'));
    }

    public function product_review(Request $request)
    {
        Review::create([
            'comment' => $request->comment,
            'star' => $request->rating,
            'product_id' => $request->product_id,
            'user_id' => Auth::id()
        ]);

        return redirect()->back();
    }
}
