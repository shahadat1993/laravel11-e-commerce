@extends('layouts.admin')

@section('content')
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap');

            .main-content-inner {
                font-family: 'Plus Jakarta Sans', sans-serif;
                background: #f0f2f5;
                padding: 40px 25px;
            }

            /* প্রিমিয়াম হেডার */
            .page-title {
                font-size: 32px !important;
                font-weight: 800;
                background: linear-gradient(to right, #1e293b, #4f46e5);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                letter-spacing: -1px;
            }

            /* মেইন বক্স ডিজাইন */
            .wg-box {
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(10px);
                border-radius: 30px;
                padding: 35px;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.05);
                border: 1px solid #ffffff;
            }

            /* ইন-বক্স সার্চ বার */
            .inner-search-wrapper {
                position: relative;
                max-width: 350px;
            }

            .inner-search-wrapper input {
                width: 100%;
                padding: 12px 20px 12px 45px !important;
                border-radius: 15px !important;
                border: 1.5px solid #e2e8f0 !important;
                background: #f8fafc !important;
                font-weight: 600;
                transition: 0.4s all;
            }

            .inner-search-wrapper input:focus {
                border-color: #4f46e5 !important;
                background: #fff !important;
                box-shadow: 0 8px 20px rgba(79, 70, 229, 0.08) !important;
                outline: none;
            }

            .search-icon-inside {
                position: absolute;
                left: 15px;
                top: 50%;
                transform: translateY(-50%);
                color: #94a3b8;
                font-size: 18px;
            }

            /* অ্যাড নিউ বাটন */
            .btn-add-new {
                background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
                color: white !important;
                padding: 12px 25px;
                border-radius: 15px;
                font-weight: 700;
                display: flex;
                align-items: center;
                gap: 8px;
                font-size: 16px;
                transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                box-shadow: 0 10px 20px rgba(79, 70, 229, 0.2);
            }

            .btn-add-new:hover {
                transform: translateY(-3px) scale(1.02);
                box-shadow: 0 15px 25px rgba(79, 70, 229, 0.3);
            }

            /* টেবিল ডিজাইন */
            .table-responsive {
                border-radius: 20px;
            }

            .table {
                border-collapse: separate;
                border-spacing: 0 12px;
                margin-top: -12px;
            }

            .table thead th {
                background: transparent;
                border: none;
                color: #64748b;
                font-weight: 700;
                text-transform: uppercase;
                font-size: 15px;
                letter-spacing: 1.5px;
                padding: 15px 20px;
            }

            .table tbody tr {
                background: #ffffff;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.02);
                transition: 0.4s ease;
            }

            .table tbody tr:hover {
                transform: translateY(-3px) scale(1.005);
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.06);
            }

            .table td {
                padding: 20px !important;
                border: none;
                vertical-align: middle;
                font-size: 14px;
            }

            .table td:first-child {
                border-radius: 20px 0 0 20px;
            }

            .table td:last-child {
                border-radius: 0 20px 20px 0;
            }

            /* কুপন কোড স্টাইল */
            .coupon-code {
                background: #f1f5f9;
                padding: 6px 12px;
                border-radius: 10px;
                font-family: 'Courier New', Courier, monospace;
                font-weight: 800;
                color: #1e293b;
                border: 1px dashed #cbd5e1;
            }

            /* টাইপ ব্যাজ */
            .type-badge {
                padding: 6px 14px;
                border-radius: 10px;
                font-weight: 800;
                font-size: 11px;
                text-transform: uppercase;
            }

            .type-fixed {
                background: #e0e7ff;
                color: #4338ca;
            }

            .type-percent {
                background: #fef9c3;
                color: #854d0e;
            }

            /* অ্যাকশন বাটন এনিমেশন */
            .action-btn {
                width: 42px;
                height: 42px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 14px;
                transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                text-decoration: none;
            }

            .btn-edit {
                background: #dcfce7;
                color: #166534;
            }

            .btn-edit:hover {
                background: #166534;
                color: #fff;
                transform: rotate(15deg) scale(1.15);
            }

            .btn-delete {
                background: #fee2e2;
                color: #991b1b;
                cursor: pointer;
                border: none;
            }

            .btn-delete:hover {
                background: #991b1b;
                color: #fff;
                transform: rotate(-15deg) scale(1.15);
            }

            .value-text {
                font-weight: 800;
                color: #4f46e5;
                font-size: 16px;
            }

            @media (max-width: 768px) {
                .wg-filter {
                    width: 100%;
                    margin-bottom: 15px;
                }

                .inner-search-wrapper {
                    max-width: 100%;
                }
            }
        </style>
    @endpush

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h3 class="page-title">Coupons & Offers</h3>
                    <div class="flex items-center gap-2 text-slate-500 font-medium mt-1">
                        <span>Admin</span> <i class="ri-arrow-right-s-line"></i> <span>Manage Coupons</span>
                    </div>
                </div>
                <a class="btn-add-new" href="{{ route('admin.coupon.add') }}">
                    <i class="ri-add-circle-fill text-xl"></i> Add New Coupon
                </a>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap mb-6">
                    <div class="inner-search-wrapper flex-grow">
                        <i class="ri-search-2-line search-icon-inside"></i>
                        <form class="form-search">
                            <input type="text" placeholder="Search by code..." name="name" required>
                        </form>
                    </div>
                </div>

                <div class="wg-table">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Coupon Code</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Value</th>
                                    <th class="text-center">Min Cart</th>
                                    <th class="text-center">Expiry Date</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coupons as $key => $coupon)
                                    <tr id="row_{{ $coupon->id }}">
                                        <td class="text-center font-bold text-slate-300">#{{ $coupons->firstItem() + $key }}
                                        </td>
                                        <td class="text-center">
                                            <span class="coupon-code">{{ $coupon->code }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="type-badge {{ $coupon->type == 'fixed' ? 'type-fixed' : 'type-percent' }}">
                                                {{ $coupon->type }}
                                            </span>
                                        </td>
                                        <td class="text-center value-text">
                                            {{ $coupon->type == 'percent' ? $coupon->value . '%' : '$' . $coupon->value }}
                                        </td>
                                        <td class="text-center font-bold text-slate-600">${{ $coupon->cart_value }}</td>
                                        <td class="text-center font-semibold text-slate-400">
                                            <i class="ri-calendar-event-line"></i>
                                            {{ \Carbon\Carbon::parse($coupon->expiry_date)->format('d M, Y') }}
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center gap-3">
                                                <a href="{{ route('admin.coupon.edit', $coupon->id) }}"
                                                    class="action-btn btn-edit" title="Edit Coupon">
                                                    <i class="ri-edit-line"></i>
                                                </a>

                                                <form action="{{ route('admin.coupon.destroy', $coupon->id) }}"
                                                    method="POST" class="delete-form m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="action-btn btn-delete delete-btn"
                                                        data-id="{{ $coupon->id }}" title="Delete Coupon">
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
                </div>

                <div class="divider my-6"></div>
                <div class="d-flex align-items-center justify-content-center">
                    {{ $coupons->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            let id = $(this).data('id');

            Swal.fire({
                title: "Are you sure?",
                text: "This coupon will be permanently deleted!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#ef4444',
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('/admin/coupons/destroy') }}/" + id,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: response.message,
                                    icon: "success",
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                $("#row_" + id).fadeOut(500, function() {
                                    $(this).remove();
                                });
                            } else {
                                Swal.fire("Error!", "Something went wrong.", "error");
                            }
                        },
                        error: function() {
                            Swal.fire("Error!", "Failed to delete the coupon.", "error");
                        }
                    });
                }
            });
        });
    </script>
@endpush
