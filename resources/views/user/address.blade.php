@extends('layouts.app')
@section('content')
    <style>
        /* User Account Design Enhancement */
        .my-account {
            padding-top: 50px;
            padding-bottom: 80px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 800;
            color: #111;
            margin-bottom: 30px;
            letter-spacing: -0.5px;
        }

        /* Left Sidebar Navigation */
        .account-nav {
            list-style: none;
            padding: 0;
            border: 1px solid #efefef;
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
        }

        .account-nav li {
            /* border-bottom: 1px solid #efefef; */
        }

        .account-nav li:last-child {
            border-bottom: none;
        }

        .menu-link_us-s {
            display: block;
            padding: 15px 20px;
            font-size: 14px;
            font-weight: 600;
            color: #666;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            /* ডিফল্ট ট্রান্সপারেন্ট বর্ডার */
        }

        .menu-link_us-s:hover {
            background: #fcfcfc;
            color: #000;
            text-decoration: none;

        }

        /* একটিভ ক্লাসের স্টাইল */
        .menu-link_us-s.active {
            background: #fcfcfc;
            color: #000;
            border-left: 4px solid #000;
        }

        /* থিমের ::after ইফেক্ট পুরোপুরি বন্ধ করার জন্য */
        .menu-link_us-s::after {
            display: none !important;
            content: none !important;
            width: 0 !important;
        }

        /* হোভার করলেও যেন ফিরে না আসে */
        .menu-link_us-s:hover::after,
        .menu-link_us-s.active::after {
            display: none !important;
            width: 0 !important;
        }

        /* বাকি অ্যাড্রেস কার্ড স্টাইল একই রাখা হয়েছে */
        .address-card {
            border-radius: 14px;
            border: 1px solid #f0f0f0;
            transition: 0.3s;
            background: #fff;
            overflow: hidden;
        }

        .address-card:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .card-header-custom {
            padding: 18px 25px;
            background: #fafafa;
            border-bottom: 1px solid #f0f0f0;
        }

        .card-body-custom {
            padding: 25px;
        }

        .address-item {
            display: flex;
            margin-bottom: 8px;
            font-size: 14px;
            color: #555;
        }

        .address-item strong {
            width: 110px;
            color: #111;
            font-weight: 700;
            flex-shrink: 0;
        }

        .btn-add-new {
            background: #000;
            color: #fff;
            border: none;
            padding: 10px 22px;
            border-radius: 8px;
            font-weight: 700;
            transition: 0.3s;
        }

        .btn-add-new:hover {
            background: #333;
            transform: translateY(-2px);
        }

        .action-btn {
            font-size: 12px;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 6px;
            text-transform: uppercase;
        }

        .empty-state {
            border: 2px dashed #eee;
            border-radius: 20px;
            padding: 60px 20px;
            background: #fcfcfc;
        }
    </style>

    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title text-center text-lg-start">Addresses</h2>
            <div class="row gx-lg-5">
                {{-- Left Sidebar --}}
                <div class="col-lg-3 mb-4">
                    <ul class="account-nav shadow-sm" id="account-menu">
                        <li><a href="{{ route('user.index') }}"
                                class="menu-link menu-link_us-s {{ request()->routeIs('user.index') ? 'active' : '' }}">Dashboard</a>
                        </li>
                        <li><a href="{{ route('user.orders') }}"
                                class="menu-link menu-link_us-s {{ request()->routeIs('user.orders') ? 'active' : '' }}">Orders</a>
                        </li>
                        <li><a href="{{ route('user.address') }}"
                                class="menu-link menu-link_us-s {{ request()->routeIs('user.address*') ? 'active' : '' }}">Addresses</a>
                        </li>
                        <li><a href="{{ route('user.account.details') }}"
                                class="menu-link menu-link_us-s {{ request()->routeIs('user.account.details') ? 'active' : '' }}">Account
                                Details</a></li>
                        <li><a href="{{ route('user.wishlist') }}"
                                class="menu-link menu-link_us-s {{ request()->routeIs('user.wishlist') ? 'active' : '' }}">Wishlist</a>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="post" id="logout-form">
                                @csrf
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit()"
                                    class="menu-link menu-link_us-s text-danger">Logout</a>
                            </form>
                        </li>
                    </ul>
                </div>

                {{-- Main Content --}}
                <div class="col-lg-9">
                    <div class="page-content my-account__address">
                        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                            <p class="notice-text mb-2 mb-lg-0 text-muted italic">The following addresses will be used on
                                the checkout page by default.</p>
                            @if ($addresses->count() > 0)
                                <a href="{{ route('user.address.add') }}" class="btn-add-new shadow-sm">
                                    <i class="fa fa-plus me-1"></i> Add New Address
                                </a>
                            @endif
                        </div>

                        @if ($addresses->count() > 0)
                            @foreach ($addresses as $address)
                                <div class="address-card mb-4 shadow-sm">
                                    <div class="card-header-custom d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 fw-bold">
                                            {{ $address->name }}
                                            @if ($address->isdefault)
                                                <span class="badge bg-success ms-2 rounded-pill px-3"
                                                    style="font-size: 10px;">DEFAULT ADDRESS</span>
                                            @endif
                                        </h6>

                                        <div class="d-flex gap-2">
                                            @if (!$address->isdefault)
                                                <form action="{{ route('user.address.default', $address->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button class="btn btn-sm btn-outline-success action-btn">Make
                                                        Default</button>
                                                </form>
                                            @endif
                                            <a href="{{ route('user.address.edit', $address->id) }}"
                                                class="btn btn-sm btn-outline-dark action-btn">Edit</a>
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger action-btn delete-btn"
                                                data-id="{{ $address->id }}">Delete</button>
                                        </div>
                                    </div>

                                    <div class="card-body-custom">
                                        <div class="address-item"><strong>Address:</strong>
                                            <span>{{ $address->address }}</span>
                                        </div>
                                        <div class="address-item"><strong>Landmark:</strong>
                                            <span>{{ $address->landmark }}</span>
                                        </div>
                                        <div class="address-item"><strong>City/State:</strong> <span>{{ $address->city }},
                                                {{ $address->state }}, {{ $address->country }}</span></div>
                                        <div class="address-item"><strong>ZIP:</strong> <span>{{ $address->zip }}</span>
                                        </div>
                                        <div class="address-item"><strong>Phone:</strong> <span
                                                class="fw-bold text-dark">{{ $address->phone }}</span></div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="empty-state text-center shadow-sm mt-4">
                                <div class="mb-4"><i class="fa fa-map-marker-alt fa-3x text-muted opacity-50"></i></div>
                                <h5 class="fw-bold">No Address Found</h5>
                                <a href="{{ route('user.address.add') }}" class="btn btn-dark px-5 py-2">Add Your First
                                    Address</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // ১. Active Class Manipulation via JS
            const menuLinks = document.querySelectorAll('.menu-link_us-s');
            menuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    menuLinks.forEach(item => item.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // ২. Delete Logic
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const addressId = this.dataset.id;
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This address will be deleted permanently!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#000',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then(result => {
                        if (!result.isConfirmed) return;
                        fetch(`/user/address/delete/${addressId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': token,
                                    'Accept': 'application/json'
                                }
                            })
                            .then(res => res.json())
                            .then(data => {
                                Swal.fire('Deleted!', data.message, 'success').then(
                                    () => location.reload());
                            })
                            .catch(() => Swal.fire('Error!', 'Something went wrong!',
                                'error'));
                    });
                });
            });
        });
    </script>
@endpush
