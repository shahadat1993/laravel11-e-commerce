@extends('layouts.admin')

@section('content')
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap');

            .main-content-inner {
                font-family: 'Plus Jakarta Sans', sans-serif;
                background: #f8fafc;
                padding: 30px 20px;
            }

            /* Breadcrumbs & Header */
            h3 {
                font-size: 28px !important;
                font-weight: 800;
                color: #1e293b;
            }

            .text-tiny {
                font-size: 13px;
                color: #64748b;
                font-weight: 500;
            }

            /* Modern Box Style */
            .wg-box {
                background: #ffffff;
                border-radius: 20px;
                padding: 25px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
                border: 1px solid #f1f5f9;
            }

            /* Search & Filter Section */
            .form-search input {
                border-radius: 12px !important;
                border: 1.5px solid #e2e8f0 !important;
                padding: 10px 18px !important;
                transition: 0.3s;
            }

            .form-search input:focus {
                border-color: #4f46e5 !important;
                box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1) !important;
            }

            .tf-button {
                background: #4f46e5 !important;
                border-radius: 12px !important;
                font-weight: 700 !important;
                transition: 0.4s !important;
            }

            .tf-button:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(79, 70, 229, 0.3);
            }

            /* Modern Table Design */
            .table {
                border-collapse: separate;
                border-spacing: 0 10px;
            }

            .table thead th {
                background: #f8fafc;
                border: none;
                color: #64748b;
                text-transform: uppercase;
                font-size: 12px;
                letter-spacing: 1px;
                padding: 15px;
            }

            .table tbody tr {
                background: #fff;
                transition: 0.3s;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
            }

            .table tbody tr:hover {
                transform: scale(1.005);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            }

            .table td {
                border: none;
                padding: 20px !important;
                vertical-align: middle;
            }

            .table td:first-child {
                border-radius: 15px 0 0 15px;
            }

            .table td:last-child {
                border-radius: 0 15px 15px 0;
            }

            /* Image Style */
            .brand-img {
                width: 60px;
                height: 60px;
                object-fit: cover;
                border-radius: 12px;
                border: 2px solid #f1f5f9;
                transition: 0.3s;
            }

            .brand-img:hover {
                transform: scale(1.1);
            }

            /* Animated Icons */
            .action-icon {
                font-size: 22px;
                transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                display: inline-block;
            }

            .edit-link:hover .ri-edit-2-line {
                color: #4f46e5;
                transform: scale(1.3) rotate(-10deg);
            }

            .delete-btn:hover .ri-delete-bin-5-line {
                color: #ef4444;
                transform: scale(1.3) shake;
                animation: shake 0.4s infinite;
            }

            @keyframes shake {
                0% {
                    transform: scale(1.3) rotate(0);
                }

                25% {
                    transform: scale(1.3) rotate(5deg);
                }

                75% {
                    transform: scale(1.3) rotate(-5deg);
                }

                100% {
                    transform: scale(1.3) rotate(0);
                }
            }

            /* Badge */
            .product-count {
                background: #e0e7ff;
                color: #4338ca;
                padding: 4px 12px;
                border-radius: 20px;
                font-weight: 700;
                font-size: 13px;
            }

            /* Pagination Customization */
            .pagination {
                gap: 5px;
            }

            .page-link {
                border-radius: 10px !important;
                border: none;
                color: #64748b;
                font-weight: 600;
            }

            .page-item.active .page-link {
                background: #4f46e5;
            }
        </style>
    @endpush

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <div>
                    <h3>Brands</h3>
                    <p class="text-tiny">Manage your product brands and manufacturers</p>
                </div>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li><a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a></li>
                    <li><i class="ri-arrow-right-s-line"></i></li>
                    <li>
                        <div class="text-tiny">Brands</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap mb-4">
                    <div class="wg-filter flex-grow">
                        <form class="form-search">
                            <fieldset class="name relative">
                                <input type="text" placeholder="Search brands..." name="name" value=""
                                    class="w-full">
                                <button type="submit" class="absolute right-3 top-3 text-slate-400"><i
                                        class="ri-search-line"></i></button>
                            </fieldset>
                        </form>
                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('admin.add-brand') }}">
                        <i class="ri-add-circle-line text-xl"></i> Add New Brand
                    </a>
                </div>

                <div class="wg-table">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Name</th>
                                    <th class="text-center">Logo</th>
                                    <th class="text-center">Slug</th>
                                    <th class="text-center">Total Products</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($brands as $key => $brand)
                                    <tr>
                                        <td class="text-center font-bold text-slate-400">{{ $brands->firstItem() + $key }}
                                        </td>
                                        <td>
                                            <a href="#"
                                                class="body-title-2 font-bold text-slate-700 hover:text-indigo-600">{{ $brand->name }}</a>
                                        </td>
                                        <td class="text-center">
                                            <img src="{{ $brand->image ? asset('uploads/brands/' . $brand->image) : asset('images/no-image.png') }}"
                                                alt="{{ $brand->name }}" class="brand-img">
                                        </td>
                                        <td class="text-center"><code
                                                class="text-xs bg-slate-100 px-2 py-1 rounded">{{ $brand->slug }}</code>
                                        </td>
                                        <td class="text-center">
                                            <span class="product-count">{{ $brand->products_count }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center gap-3">
                                                <a href="{{ route('admin.edit-brand', $brand->id) }}" class="edit-link"
                                                    title="Edit Brand">
                                                    <i class="ri-edit-2-line action-icon text-slate-400"></i>
                                                </a>

                                                <form action="{{ route('admin.brand.delete', $brand->id) }}" method="POST"
                                                    class="delete-form m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="border-0 bg-transparent delete-btn p-0"
                                                        data-id="{{ $brand->id }}" title="Delete Brand">
                                                        <i class="ri-delete-bin-5-line action-icon text-slate-400"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="divider my-4"></div>
                    <div class="pagination-wrapper d-flex justify-content-center">
                        {{ $brands->links('pagination::bootstrap-5') }}
                    </div>
                </div>
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
                    const brandId = this.dataset.id;

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This brand and its associated data will be removed!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#4f46e5',
                        cancelButtonColor: '#ef4444',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel',
                        background: '#ffffff',
                        customClass: {
                            popup: 'rounded-3xl',
                            confirmButton: 'rounded-xl px-4 py-2',
                            cancelButton: 'rounded-xl px-4 py-2'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/admin/brand/${brandId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': token,
                                        'Accept': 'application/json',
                                    }
                                })
                                .then(res => res.json())
                                .then(data => {
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: data.message ||
                                            'Brand has been deleted.',
                                        icon: 'success',
                                        timer: 2000,
                                        showConfirmButton: false
                                    }).then(() => location.reload());
                                })
                                .catch(err => {
                                    Swal.fire('Error!', 'Something went wrong!',
                                        'error');
                                });
                        }
                    });
                });
            });
        });
    </script>
@endpush
