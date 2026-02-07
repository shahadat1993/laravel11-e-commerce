@php
    use Illuminate\Support\Facades\Auth;
@endphp

@extends('layouts.admin')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap');

        .main-content-inner {
            font-family: 'Outfit', sans-serif;
            background: #f4f7fa;
            padding: 30px;
        }

        /* Modern Breadcrumbs */
        .breadcrumbs li div, .breadcrumbs li a {
            font-weight: 500;
            color: #64748b;
        }

        /* Search Box High-End Design */
        .form-search {
            position: relative;
            max-width: 400px;
        }
        .form-search input {
            width: 100%;
            padding: 12px 20px 12px 45px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            transition: all 0.3s;
        }
        .form-search input:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
            outline: none;
        }
        .button-submit {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        /* Table Card */
        .wg-box {
            background: #ffffff;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
            border: 1px solid #f1f5f9;
        }

        /* Premium Table Styling */
        .table-responsive {
            border-radius: 15px;
            overflow: hidden;
        }

        .table-all-user table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-all-user thead th {
            background: #f8fafc;
            color: #475569;
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            padding: 18px;
            border-bottom: 2px solid #f1f5f9;
        }

        .table-all-user tbody tr {
            transition: all 0.2s;
        }

        .table-all-user tbody tr:hover {
            background-color: #fcfaff;
        }

        .table-all-user tbody td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            color: #1e293b;
            font-size: 14px;
            /* Text Overflow Control */
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* User Profile Style */
        .user-img {
            width: 55px;
            height: 55px;
            object-fit: cover;
            border-radius: 12px;
            border: 2px solid #fff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        /* Order Count Badge */
        .order-count-btn {
            background: #eef2ff;
            color: #4f46e5;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 700;
            text-decoration: none;
            transition: 0.3s;
        }
        .order-count-btn:hover {
            background: #4f46e5;
            color: #fff;
        }

        /* Delete Button Action */
        .delete-btn-custom {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: #fff1f2;
            color: #e11d48;
            transition: 0.3s;
            border: none;
        }
        .delete-btn-custom:hover {
            background: #e11d48;
            color: #fff;
            transform: rotate(10deg);
        }

        /* Custom Scrollbar for Table */
        .table-responsive::-webkit-scrollbar {
            height: 6px;
        }
        .table-responsive::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
    </style>
@endpush

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <div>
                    <h3 class="text-3xl font-bold text-slate-800">User Management</h3>
                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10 mt-2">
                        <li><a href="{{ route('dashboard') }}" class="text-blue-600">Dashboard</a></li>
                        <li><i class="ri-arrow-right-s-line text-slate-400"></i></li>
                        <li class="text-slate-500">All Registered Users</li>
                    </ul>
                </div>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap mb-6">
                    <div class="wg-filter flex-grow">
                        <form class="form-search">
                            <div class="button-submit">
                                <i class="ri-search-line"></i>
                            </div>
                            <input type="text" placeholder="Search by name or email..." name="name" tabindex="2">
                        </form>
                    </div>
                </div>

                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center"># Index</th>
                                    <th>User Info</th>
                                    <th class="text-center">Avatar</th>
                                    <th class="text-center">Phone/Mobile</th>
                                    <th>Email Address</th>
                                    <th class="text-center">Total Orders</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $user)
                                    <tr>
                                        <td class="text-center font-bold text-slate-400">
                                            {{ sprintf('%02d', $users->firstItem() + $key) }}
                                        </td>
                                        <td class="font-semibold text-slate-700" title="{{ $user->name }}">
                                            {{ $user->name }}
                                        </td>
                                        <td class="text-center">
                                            <img src="{{ $user->image_url }}" alt="{{ $user->name }}" class="user-img">
                                        </td>
                                        <td class="text-center text-slate-600 font-medium">
                                            {{ $user->mobile ?? 'N/A' }}
                                        </td>
                                        <td class="text-slate-600 italic" title="{{ $user->email }}">
                                            {{ $user->email }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.user.orders', $user->id) }}" class="order-count-btn">
                                                <i class="ri-shopping-bag-3-line mr-1"></i>
                                                {{ $user->orders->count() }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <div class="flex justify-center">
                                                <button type="button" class="delete-btn-custom delete-btn" data-id="{{ $user->id }}" title="Delete User">
                                                    <i class="ri-delete-bin-6-line fs-5"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-8 flex items-center justify-between flex-wrap gap10">
                    <p class="text-sm text-slate-500">Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users</p>
                    <div class="wgp-pagination">
                        {{ $users->links('pagination::bootstrap-5') }}
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

            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const userId = this.dataset.id;

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This user and their data will be permanently removed!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e11d48',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Yes, Delete Now!',
                        borderRadius: '15px'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/admin/user/delete/${userId}`, {
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
                                        text: data.message,
                                        icon: 'success',
                                        confirmButtonColor: '#4f46e5'
                                    }).then(() => location.reload());
                                })
                                .catch(() => {
                                    Swal.fire('Error!', 'Something went wrong while deleting!', 'error');
                                });
                        }
                    });
                });
            });
        });
    </script>
@endpush
