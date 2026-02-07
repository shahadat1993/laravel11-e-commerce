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
            font-size: 26px !important;
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
            padding: 12px 20px;
            border-radius: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease-in-out;
            text-decoration: none;
        }

        .btn-add-new:hover {
            background: #3730a3;
            transform: translateY(-2px);
        }

        /* Modern Table */
        .modern-table {
            width: 100%;
            border-collapse: collapse;
        }

        .modern-table thead th {
            padding: 15px;
            background: #f1f5f9;
            color: #475569;
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .modern-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: 0.3s;
        }

        .modern-table tbody tr:hover {
            background: #f8faff;
        }

        .modern-table tbody td {
            padding: 18px 15px;
            vertical-align: middle;
            text-align: center;
            font-size: 16px;
        }

        /* Image & Icon Styles */
        .cat-img-wrapper {
            width: 70px;
            height: 70px;
            margin: 0 auto;
            border-radius: 15px;
            overflow: hidden;
            border: 2px solid #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .cat-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.4s;
        }

        .cat-img-wrapper:hover img {
            transform: scale(1.15);
        }

        /* Product Count Icon */
        .prod-count-box {
            position: relative;
            display: inline-flex;
            color: #6366f1;
            font-size: 28px;
            transition: 0.3s;
        }

        .prod-count-box:hover {
            transform: translateY(-3px);
            color: #4338ca;
        }

        .count-badge {
            position: absolute;
            top: -5px;
            right: -8px;
            background: #ef4444;
            color: #fff;
            font-size: 11px;
            font-weight: 800;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #fff;
        }

        /* Smooth Icon Animations */
        .action-icon {
            font-size: 22px;
            padding: 8px;
            border-radius: 10px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: inline-block;
        }

        .icon-edit {
            color: #10b981;
            background: #ecfdf5;
        }

        .icon-edit:hover {
            background: #10b981;
            color: #fff;
            transform: rotate(15deg) scale(1.1);
        }

        .icon-delete {
            color: #ef4444;
            background: #fef2f2;
            border: none;
        }

        .icon-delete:hover {
            background: #ef4444;
            color: #fff;
            transform: scale(1.1);
        }

        /* Responsive Mobile Layout */
        @media (max-width: 768px) {
            .modern-table thead {
                display: none;
            }

            .modern-table tbody tr {
                display: block;
                padding: 15px;
                border: 1px solid #f1f5f9;
                border-radius: 15px;
                margin-bottom: 15px;
                background: #fff;
            }

            .modern-table tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 5px;
                text-align: right;
                border: none;
            }

            .modern-table tbody td::before {
                content: attr(data-label);
                font-weight: 700;
                color: #64748b;
                font-size: 13px;
            }

            .cat-img-wrapper {
                margin: 0;
            }
        }
    </style>
@endpush

@section('content')
    <div class="main-content-inner">
        <div class="flex items-center justify-between flex-wrap gap-4 mb-8">
            <div>
                <h3>Categories Area</h3>
                <p class="text-slate-500 font-medium">Manage your product groups efficiently</p>
            </div>
            <a class="btn-add-new" href="{{ route('admin.category.add') }}">
                <i class="ri-add-line"></i> Add Category
            </a>
        </div>

        <div class="wg-box">
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th># SL</th>
                            <th>Category Name</th>
                            <th>Preview</th>
                            <th>Slug</th>
                            <th>Products</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $key => $category)
                            <tr>
                                <td data-label="# SL"><span
                                        class="font-bold text-slate-400">{{ $categories->firstItem() + $key }}</span></td>
                                <td data-label="Category Name"><span
                                        class="font-bold text-slate-800 text-lg">{{ $category->name }}</span></td>
                                <td data-label="Preview">
                                    <div class="cat-img-wrapper">
                                        <img src="{{ $category->image ? asset('uploads/categories/' . $category->image) : asset('images/no-image.png') }}"
                                            alt="">
                                    </div>
                                </td>
                                <td data-label="Slug"><span
                                        class="bg-slate-100 px-3 py-1 rounded-md text-sm font-medium text-slate-600">{{ $category->slug }}</span>
                                </td>
                                <td data-label="Products">
                                    <div class="prod-count-box">
                                        <i class="ri-shopping-bag-3-fill"></i>
                                        <span class="count-badge">{{ $category->products_count }}</span>
                                    </div>
                                </td>
                                <td data-label="Action">
                                    <div class="flex justify-center md:justify-center gap-3">
                                        <a href="{{ route('admin.category.edit', $category->id) }}"
                                            class="action-icon icon-edit">
                                            <i class="ri-edit-line"></i>
                                        </a>
                                        <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="button" class="action-icon icon-delete delete-btn"
                                                data-id="{{ $category->id }}">
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
            <div class="mt-6">
                {{ $categories->links('pagination::bootstrap-5') }}
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
                            fetch(`/admin/category/destroy/${id}`, {
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
