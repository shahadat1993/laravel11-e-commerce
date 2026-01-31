<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Slide;
use App\Models\Product;
use App\Models\Category;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use Symfony\Component\HttpFoundation\Request;

class EcommerceController extends Controller
{
    public function index()
    {

        $slides = Slide::where('status', 1)->limit(3)->get();
        $categories = Category::orderBy('name')->get();
        $sproducts = Product::whereNotNull('sale_price')->where('sale_price', '<>', '')->inRandomOrder()->get()->take(8);
        $items = Cart::instance('wishlist')->content();
        $fProducts = Product::where('featured', 1)->get()->take(8);
        return view('index', compact('slides', 'categories', 'sproducts', 'items', 'fProducts'));
    }
    // CONTACT METHOD
    public function contact()
    {
        return view('Contact');
    }
    // CONTACT STORE METHOD
    public function contact_store(Request $request)
    {

        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone' => 'required|numeric|digits_between:10,15',
            'comment' => 'required|string|min:5',
        ]);

        Contact::create($validated);

        return back()->with('success', 'Your message has been sent successfully.');
    }
}
