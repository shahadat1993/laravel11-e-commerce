@extends('layouts.admin')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap');

        .main-content-inner {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f8fafc;
            padding: 30px 15px;
        }

        /* Title & Header */
        h3 {
            font-size: 28px !important;
            font-weight: 800;
            color: #0f172a;
        }

        .wg-box {
            background: #ffffff;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.02);
            border: 1px solid #eef2f6;
        }

        /* Action Button */
        .btn-add-new {
            background: #4f46e5;
            color: #fff !important;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease-in-out;
            text-decoration: none;
            font-size: 16px;
        }

        .btn-add-new:hover {
            background: #3730a3;
            transform: translateY(-2px);
        }

        /* Modern Table */
        .modern-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1200px;
        }

        .modern-table thead th {
            padding: 18px 10px;
            background: #f1f5f9;
            color: #334155;
            font-size: 16px;
            text-transform: uppercase;
            font-weight: 700;
        }

        .modern-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: 0.3s;
        }

        .modern-table tbody tr:hover {
            background: #f8faff;
        }

        .modern-table tbody td {
            padding: 20px 10px;
            vertical-align: middle;
            text-align: center;
            color: #1e293b;
            font-size: 16px;
        }

        /* Product Image Style */
        .prod-img-wrapper {
            width: 75px;
            height: 75px;
            margin: 0 auto;
            border-radius: 12px;
            overflow: hidden;
            border: 2px solid #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .prod-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.4s;
        }

        .prod-img-wrapper:hover img {
            transform: scale(1.1);
        }

        /* Featured Badge */
        .badge-featured {
            padding: 5px 10px;
            border-radius: 6px;
            font-weight: 800;
            font-size: 12px;
        }

        .bg-yes {
            background: #dcfce7;
            color: #15803d;
        }

        .bg-no {
            background: #fee2e2;
            color: #b91c1c;
        }

        /* Stock Status */
        .stock-status {
            font-weight: 700;
            text-transform: capitalize;
        }

        .text-instock {
            color: #10b981;
        }

        .text-outofstock {
            color: #ef4444;
        }

        /* Action Icons */
        .action-icon {
            font-size: 22px;
            padding: 10px;
            border-radius: 10px;
            transition: all 0.4s;
            display: inline-block;
        }

        .icon-edit {
            color: #10b981;
            background: #ecfdf5;
        }

        .icon-edit:hover {
            background: #10b981;
            color: #fff;
            transform: scale(1.1);
        }

        .icon-delete {
            color: #ef4444;
            background: #fef2f2;
            border: none;
            cursor: pointer;
        }

        .icon-delete:hover {
            background: #ef4444;
            color: #fff;
            transform: scale(1.1);
        }
    </style>
@endpush

@section('content')
    <div class="main-content-inner">
        <div class="flex items-center justify-between flex-wrap gap-4 mb-8">
            <div>
                <h3>Products</h3>
                <p class="text-slate-500 font-medium text-lg">Manage your inventory details</p>
            </div>
            <a class="btn-add-new" href="{{ route('admin.product.add') }}">
                <i class="ri-add-line"></i> Add New Product
            </a>
        </div>

        <div class="wg-box">
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Sale Price</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Featured</th>
                            <th>Stock</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $key => $product)
                            <tr>
                                <td><span class="font-bold text-slate-400">{{ $products->firstItem() + $key }}</span></td>
                                <td class="text-left" style="max-width: 200px;">
                                    <div class="font-bold text-slate-800" style="font-size: 16px;">{{ $product->name }}
                                    </div>
                                    <div class="text-xs text-slate-400 mt-1">{{ $product->slug }}</div>
                                </td>
                                <td>
                                    <div class="prod-img-wrapper">
                                        <img src="{{ $product->image ? asset('uploads/products/' . $product->image) : asset('images/no-image.png') }}"
                                            alt="">
                                    </div>
                                </td>
                                <td><span class="font-bold text-slate-700">${{ $product->regular_price }}</span></td>
                                <td><span
                                        class="font-bold text-indigo-600">{{ $product->sale_price ? '$' . $product->sale_price : '-' }}</span>
                                </td>
                                <td><span
                                        class="bg-slate-100 px-2 py-1 rounded text-sm font-medium">{{ $product->sku }}</span>
                                </td>
                                <td><span class="font-semibold">{{ $product->category?->name ?? '-' }}</span></td>
                                <td><span class="font-semibold">{{ $product->brand?->name ?? '-' }}</span></td>
                                <td>
                                    <span class="badge-featured {{ $product->featured == 0 ? 'bg-no' : 'bg-yes' }}">
                                        {{ $product->featured == 0 ? 'NO' : 'YES' }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="stock-status {{ $product->stock_status == 'instock' ? 'text-instock' : 'text-outofstock' }}">
                                        {{ $product->stock_status }}
                                    </span>
                                </td>
                                <td><span class="font-bold text-lg">{{ $product->quantity }}</span></td>
                                <td>
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('admin.product.edit', $product->id) }}"
                                            class="action-icon icon-edit">
                                            <i class="ri-edit-line"></i>
                                        </a>
                                        <form action="{{ route('admin.product.destroy', $product->id) }}" method="POST"
                                            class="inline">
                                            @csrf @method('DELETE')
                                            <button type="button" class="action-icon icon-delete delete-btn"
                                                data-id="{{ $product->id }}">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-8">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    Swal.fire({
                        title: 'Are you sure?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        confirmButtonText: 'Yes, Delete'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/admin/product/destroy/${id}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': token,
                                        'Accept': 'application/json'
                                    }
                                }).then(res => res.json())
                                .then(data => {
                                    location.reload();
                                });
                        }
                    });
                });
            });
        });
    </script>
@endpush
