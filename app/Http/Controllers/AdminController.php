<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Slide;
use App\Models\Contact;
use App\Models\Coupons;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use SweetAlert2\Laravel\Swal;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {



        // All Orders
        $totalOrders = Order::count();

        // Delivered Orders
        $deliveredOrders = Order::where('status', 'delivered')->count();

        // Pending Orders
        $pendingOrders = Order::where('status', 'ordered')->count();

        // Canceled Orders
        $canceledOrders = Order::where('status', 'canceled')->count();

        // Total Amount
        $totalAmount = Order::sum('total');

        // Delivered Amount
        $deliveredAmount = Order::where('status', 'delivered')->sum('total');

        // Pending Amount
        $pendingAmount = Order::where('status', 'ordered')->sum('total');

        // Canceled Amount
        $canceledAmount = Order::where('status', 'canceled')->sum('total');

        // Recent 10 Orders
        $orders = Order::orderBy('created_at', 'DESC')->limit(10)->get();

        $monthlyDatas = DB::select("
            SELECT
                M.id AS MonthNo,
                M.name AS MonthName,
                IFNULL(D.TotalAmount, 0) AS TotalAmount,
                IFNULL(D.TotalOrderedAmount, 0) AS TotalOrderedAmount,
                IFNULL(D.TotalDeliveredAmount, 0) AS TotalDeliveredAmount,
                IFNULL(D.TotalCanceledAmount, 0) AS TotalCanceledAmount
            FROM month_names M
            LEFT JOIN (
                SELECT
                    MONTH(created_at) AS MonthNo,
                    SUM(total) AS TotalAmount,
                    SUM(IF(status = 'ordered', total, 0)) AS TotalOrderedAmount,
                    SUM(IF(status = 'delivered', total, 0)) AS TotalDeliveredAmount,
                    SUM(IF(status = 'canceled', total, 0)) AS TotalCanceledAmount
                FROM orders
                WHERE YEAR(created_at) = YEAR(NOW())
                GROUP BY MONTH(created_at)
            ) D ON D.MonthNo = M.id
            ORDER BY M.id
        ");
        $amountM = collect($monthlyDatas)
            ->pluck('TotalAmount')
            ->map(fn($v) => floatval($v))
            ->toArray();

        $orderedAmountM = collect($monthlyDatas)
            ->pluck('TotalOrderedAmount')
            ->map(fn($v) => floatval($v))
            ->toArray();

        $deliveredAmountM = collect($monthlyDatas)
            ->pluck('TotalDeliveredAmount')
            ->map(fn($v) => floatval($v))
            ->toArray();

        $canceledAmountM = collect($monthlyDatas)
            ->pluck('TotalCanceledAmount')
            ->map(fn($v) => floatval($v))
            ->toArray();



        $totalAmount = collect($monthlyDatas)->sum('TotalAmount');
        $totalOrderedAmount = collect($monthlyDatas)->sum('TotalOrderedAmount');
        $totalDeliveredAmount = collect($monthlyDatas)->sum('TotalDeliveredAmount');
        $totalCanceledAmount = collect($monthlyDatas)->sum('TotalCanceledAmount');


        return view('admin.index', compact(
            'totalOrders',
            'deliveredOrders',
            'pendingOrders',
            'canceledOrders',
            'totalAmount',
            'deliveredAmount',
            'pendingAmount',
            'canceledAmount',
            'orders',
            'amountM',
            'orderedAmountM',
            'deliveredAmountM',
            'canceledAmountM',
            'totalAmount',
            'totalOrderedAmount',
            'totalDeliveredAmount',
            'totalCanceledAmount'

        ));
    }


    // BRANDS METHOD
    public function brands()
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(5);
        return view('admin.brands', compact('brands'));
    }

    // ADD BRAND

    public function addBrand()
    {
        return view('admin.add-brand');
    }
    // STORE BRAND
    public function store_brand(Request $request)
    {
        // 🔹 Step 1: Validate the input
        $request->validate([
            'brand_name' => 'required|string|max:255',
            'brand_slug' => 'nullable|string|unique:brands,slug',
            'brand_image' => 'nullable|image|mimes:jpg,jpeg,webp,png|max:2048',
        ]);

        // 🔹 Step 2: Create new Brand
        $brand = new Brand;
        $brand->name = $request->brand_name;
        $brand->slug = $request->brand_slug
            ? Str::slug($request->brand_slug)
            : Str::slug($request->brand_name);

        // 🔹 Step 3: Handle Image Upload
        if ($request->hasFile('brand_image')) {
            $file = $request->file('brand_image');
            $filename = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();

            // Move original image
            $file->move(public_path('uploads/brands'), $filename);
            $brand->image = $filename;
        }

        // 🔹 Step 4: Save Brand
        $brand->save();

        // 🔹 Step 5: Success Alert
        Swal::toastSuccess([
            'title' => 'Brand Added Successfully!',
        ]);

        // 🔹 Step 6: Redirect
        // return back();
        return redirect()->route('admin.brands');
    }

    // edit
    public function edit_brand($id)
    {
        $brand = Brand::findOrFail($id);

        return view('admin.edit_brand', compact('brand'));
    }

    // UPADATE BRAND
    public function update_brand(Request $request)
    {

        // 🔹 Step 1: Validate the input
        $request->validate([
            'brand_name' => 'required|string|max:255',
            'brand_slug' => 'nullable|string|unique:brands,slug,' . $request->id,
            'brand_image' => 'nullable|image|mimes:jpg,jpeg,webp,png|max:2048',
        ]);

        $brand = Brand::findOrFail($request->id);

        $brand->name = $request->brand_name;
        $brand->slug = $request->brand_slug
            ? Str::slug($request->brand_slug)
            : Str::slug($request->brand_name);

        // Delete Old Image
        if ($request->hasFile('brand_image')) {
            // পুরনো image delete করো (যদি থাকে)
            if ($brand->image && file_exists(public_path('uploads/brands/' . $brand->image))) {
                unlink(public_path('uploads/brands/' . $brand->image));
            }

            $file = $request->file('brand_image');
            $filename = time() . '.' . $file->getClientOriginalName();
            $file->move(public_path('uploads/brands'), $filename);
            $brand->image = $filename;
        }

        // 🔹 Step 4: Save Brand
        $brand->save();

        // 🔹 Step 5: Success Alert
        Swal::toastSuccess([
            'title' => 'Brand Updated Successfully!',
        ]);

        // 🔹 Step 6: Redirect
        // return back();
        return redirect()->route('admin.brands');
    }

    // Delete brand
    public function destroy_brand($id)
    {

        $brand = Brand::findOrFail($id);

        // যদি image থাকে, তাহলে public/uploads/brands থেকে ফাইল ডিলেট করো
        if ($brand->image && file_exists(public_path('uploads/brands/' . $brand->image))) {

            unlink(public_path('uploads/brands/' . $brand->image));
        }

        // Delete the DB record
        $brand->delete();

        // Optional: success alert (you used SweetAlert2)
        // ✅ AJAX response হলে JSON রিটার্ন করো
        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Brand deleted successfully.']);
        }

        return redirect()->route('admin.brands')->with('success', 'Brand deleted successfully.');
    }

    // COUPONS METHOD
    public function coupons()
    {
        $coupons = Coupons::orderBy('expiry_date', 'DESC')->paginate(6);
        return view('admin.coupons', compact('coupons'));
    }

    // ADD_COUPON METHOD
    public function add_coupon()
    {
        return view('admin.addCoupon');
    }

    // STORE COUPONS METHOD
    public function store_coupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:1',
            'cart_value' => 'required|numeric|min:0',
            'expiry_date' => 'required|date|after_or_equal:today',
        ]);


        $coupon = new Coupons();
        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->value = $request->value;
        $coupon->cart_value = $request->cart_value;
        $coupon->expiry_date = $request->expiry_date;
        $coupon->save();
        Swal::fire([
            'title' => 'CodeNest Agency',
            'text' => 'Coupons Added Successfully!',
            'icon' => 'success',
            'confirmButtonText' => 'ok'
        ]);
        return redirect()->route('admin.coupon');
    }

    // EDIT COUPON METHOD
    public function edit_coupon($id)
    {
        $coupon = Coupons::findOrFail($id);
        return view('admin.editCoupon', compact('coupon'));
    }

    // UPDATE COUPONS METHOD
    public function update_coupon(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:1',
            'cart_value' => 'required|numeric|min:0',
            'expiry_date' => 'required|date|after_or_equal:today',
        ]);


        $coupon = Coupons::findOrFail($id);
        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->value = $request->value;
        $coupon->cart_value = $request->cart_value;
        $coupon->expiry_date = $request->expiry_date;
        $coupon->save();
        Swal::fire([
            'title' => 'CodeNest Agency',
            'text' => 'Coupons Updated Successfully!',
            'icon' => 'success',
            'confirmButtonText' => 'ok'
        ]);
        return redirect()->route('admin.coupon');
    }

    // DESTROY COUPON METHOD
    public function delete_coupon($id)
    {
        $coupon = Coupons::find($id);

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon not found!'
            ]);
        }

        $coupon->delete();

        return response()->json([
            'success' => true,
            'message' => 'Coupon deleted successfully!'
        ]);
    }

    // SHOW ORDERS IN ADMIN PANEL
    public function orders()
    {
        $orders = Order::orderBy('created_at', 'DESC')->paginate(5);
        return view('admin.orders', compact('orders'));
    }

    // SHOW ORDER DETAILS IN ADMIN PANEL
    public function orderDetails($order_id)
    {
        $order = Order::find($order_id);
        $orderItems = OrderItem::where('order_id', $order_id)->orderBy('id')->paginate(6);
        $transactions = Transaction::where('order_id', $order_id)->first();
        return view('admin.order-details', compact('order', 'orderItems', 'transactions'));
    }


    // UPDATE ORDER STATUS
    public function update_order_status(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->status = $request->order_status;
        if ($request->order_status == 'delivered') {
            $order->delivered_date = Carbon::now();
        } else if ($request->order_status == 'canceled') {
            $order->canceled_date = Carbon::now();
        }
        $order->save();

        if ($order->order_status == 'delivered') {
            $transaction = Transaction::where('order_id', $request->order_id)->first();
            $transaction->status = 'approved';
            $transaction->save();
        }
        Swal::fire([
            'title' => 'CodeNest Agency',
            'text' => 'Order status updated successfully!',
            'icon' => 'success',
            'confirmButtonText' => 'ok'
        ]);
        return back()->with('success', 'Order status updated successfully!');
    }

    // SLIDES SHOW METHOD
    public function slides()
    {
        $slides = Slide::orderBy('id', 'DESC')->paginate(5);
        return view('admin.slides.slides', compact('slides'));
    }

    // SLIDE ADD METHOD
    public function slide_add()
    {
        return view('admin.slides.add-slide');
    }

    // SLIDE STORE METHOD
    public function slide_store(Request $request)
    {
        $request->validate([
            'tagline'   => 'required',
            'title'     => 'required',
            'subtitle'  => 'nullable',
            'link'      => 'required|url',
            'status'    => 'required|in:0,1',
            'image'     => 'required|image|mimes:png,jpeg,jpg,webp|max:5120',
        ]);

        $slide = new Slide();
        $slide->tagline  = $request->tagline;
        $slide->title    = $request->title;
        $slide->subtitle = $request->subtitle;
        $slide->link     = $request->link;
        $slide->status   = $request->status;

        // Folder path
        $folderPath = public_path('uploads/slides');

        // Create folder if not exists
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0755, true);
        }

        // Image upload
        $imageName = time() . '-' . uniqid() . '.' . $request->image->extension();
        $request->image->move($folderPath, $imageName);

        // Insert data
        $slide->image    = $imageName;
        $slide->save();

        // Only session message (Swal must be in Blade)
        //    Swal::fire([
        //             'title' => 'Surfside Media',
        //             'text' => 'Slide added successfully!',
        //             'icon' => 'success',
        //             'confirmButtonText' => 'ok'
        //         ]);
        return redirect()->route('admin.slide.index')
            ->with('success', 'Slide added successfully!');
    }


    // SLIDE EDIT METHOD
    public function slide_edit($id)
    {
        $slide = Slide::findOrFail($id);
        return view('admin.slides.edit-slide', compact('slide'));
    }

    // SLIDE UPDATE METHOD
    public function slide_update(Request $request, $id)
    {
        $request->validate([
            'tagline'   => 'required',
            'title'     => 'required',
            'subtitle'  => 'nullable',
            'link'      => 'required|url',
            'status'    => 'required|in:0,1',
            'image' => 'nullable|image|mimes:png,jpeg,jpg,webp|max:5120',
        ]);


        // Insert data
        $slide = Slide::findOrFail($id);
        $slide->tagline  = $request->tagline;
        $slide->title    = $request->title;
        $slide->subtitle = $request->subtitle;
        $slide->link     = $request->link;
        $slide->status   = $request->status;

        // Folder path
        $folderPath = public_path('uploads/slides');

        // Create folder if not exists
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0755, true);
        }

        // Image upload
        if ($request->hasFile('image')) {
            // delete old image
            if (file_exists(public_path('uploads/slides/' . $slide->image))) {
                unlink(public_path('uploads/slides/' . $slide->image));
            }
            // upload new image
            $imageName = time() . '-' . uniqid() . '.' . $request->image->extension();
            $request->image->move($folderPath, $imageName);
            $slide->image = $imageName;
            $slide->image    = $imageName;
        }


        $slide->save();

        // Only session message (Swal must be in Blade)
        //    Swal::fire([
        //             'title' => 'Surfside Media',
        //             'text' => 'Slide updated successfully!',
        //             'icon' => 'success',
        //             'confirmButtonText' => 'ok'
        //         ]);
        return redirect()->route('admin.slide.index')
            ->with('success', 'Slide updated successfully!');
    }

    // DELETE SLIDE METHOD
    public function slide_destroy($id)
    {
        $slide = Slide::findOrFail($id);
        if (file_exists(public_path('uploads/slides/' . $slide->image))) {
            unlink(public_path('uploads/slides/' . $slide->image));
        }
        $slide->delete();

        return response()->json([
            'success' => true,
            'message' => 'Slide deleted successfully!'
        ]);
    }

    // Contact Method
    public function contacts()
    {
        $contacts = Contact::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.contact', compact('contacts'));
    }

    // Admin Contact Delete method
    public function delete_contact($id)
    {
        $contact = Contact::find($id);
        $contact->delete();
        return response()->json([
            'success' => true,
            'message' => 'Message deleted successfully!'
        ]);
    }


    // SEARCH METHOD
    public function search(Request $request)
    {
        $search = $request->search;

        return Product::where('name', 'like', "%{$search}%")
            ->select('name', 'id')
            ->limit(10)
            ->get();
    }

    // ADMIN PROFILE  METHOD
    public function profile()
    {
        return view('admin.profile');
    }


    // Route for Order tracking
    public function track_order()
    {
        return view('admin.order-tracking');
    }


    // Transaction status update
    public function updateTransactionStatus(Request $request)
{
    $request->validate([
        'order_id' => 'required|exists:orders,id',
        'transaction_status' => 'required|string|in:pending,approved,refunded'
    ]);

    $transaction = Transaction::where('order_id', $request->order_id)->first();

    if (!$transaction) {
        return redirect()->back()->with('error', 'Transaction not found for this order.');
    }

    // Admin selected value থেকে update করা
    $transaction->status = $request->transaction_status;
    $transaction->save();

    return redirect()->route('admin.orders.details', $request->order_id)
        ->with('success', 'Transaction status updated successfully!');
}

}

