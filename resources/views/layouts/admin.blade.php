<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <title>Surfside Media</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="surfside media" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/animate.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/animation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('font/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('icon/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('images/favicon.ico') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    @stack('styles')
    <style>
        #header {
            padding-top: 8px;
            padding-bottom: 8px;
        }

        .logo__image {
            max-width: 220px;
        }

        /* toast styles */
        /* Toast style */
        .toast-wrapper {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        .app-toast {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 320px;
            max-width: 420px;
            padding: 18px 22px;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            font-family: system-ui, sans-serif;
            animation: slideIn 0.4s ease forwards;
            position: relative;
        }

        .app-toast.success {
            border-left: 6px solid #22c55e;
        }

        .toast-icon {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #22c55e;
            color: #fff;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .toast-content strong {
            font-size: 15px;
            color: #111;
        }

        .toast-content p {
            margin: 2px 0 0;
            font-size: 14px;
            color: #555;
        }

        .toast-close {
            margin-left: auto;
            cursor: pointer;
            font-size: 20px;
            color: #888;
        }

        .toast-close:hover {
            color: #000;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(40px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* 🌙 Dark mode support */
        @media (prefers-color-scheme: dark) {
            .app-toast {
                background: #1f2937;
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.6);
            }

            .toast-content strong {
                color: #fff;
            }

            .toast-content p {
                color: #d1d5db;
            }
        }


        .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 4px;
            width: 100%;
            background: linear-gradient(90deg, #22c55e, #16a34a);
            animation: toastProgress 3s linear forwards;
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
        }

        @keyframes toastProgress {
            from {
                width: 100%;
            }

            to {
                width: 0%;
            }
        }

        /* SEARCH METHOD STYLES */
        .search-wrapper {
            position: relative;
            max-width: 120px;
        }

        /* magnifying glass inside input */
        .

        /* search result box */
        #box-content-search {
            position: absolute;
            top: calc(100% + 6px);
            /* input-এর ঠিক নিচে আসবে */
            left: 0;
            width: 100%;
            /* input-এর সাথে width match করবে */
            max-width: 420px;
            /* চাইলে adjust করো */
            background: #ffffff;
            border-radius: 12px;
            padding: 6px 0;
            box-shadow: 0 14px 35px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(0, 0, 0, 0.06);
            z-index: 9999;
            max-height: 300px;
            overflow-y: auto;
            box-sizing: border-box;
            font-family: sans-serif;
        }

        /* each list item */
        #box-content-search li {
            list-style: none;
        }

        /* links inside search results */
        #box-content-search a {
            display: block;
            padding: 10px 18px;
            font-size: 14.5px;
            color: #222;
            text-decoration: none;
            transition: background 0.15s ease, padding-left 0.15s ease;
        }

        /* hover effect */
        #box-content-search a:hover {
            background: #f3f6ff;
            padding-left: 24px;
            color: #2b59ff;
        }

        /* optional: empty message */
        #box-content-search .search-empty {
            padding: 10px 18px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>

<body class="body">
    <div id="wrapper">
        <div id="page" class="">
            <div class="layout-wrap">

                <!-- <div id="preload" class="preload-container">
    <div class="preloading">
        <span></span>
    </div>
</div> -->

                <div class="section-menu-left">
                    <div class="box-logo">
                        <a href="{{ route('admin.index') }}" id="site-logo-inner">
                            <img class="" id="logo_header" alt=""
                                src="{{ asset('images/logo/logo.png') }}"
                                data-light="{{ asset('images/logo/logo.png') }}"
                                data-dark="{{ asset('images/logo/logo.png') }}">
                        </a>
                        <div class="button-show-hide">
                            <i class="icon-menu-left"></i>
                        </div>
                    </div>
                    <div class="center">
                        <div class="center-item">
                            <div class="center-heading">Main Home</div>
                            <ul class="menu-list">
                                <li class="menu-item">
                                    <a href="{{ route('admin.index') }}" class="">
                                        <div class="icon"><i class="icon-grid"></i></div>
                                        <div class="text">Dashboard</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="center-item">
                            <ul class="menu-list">
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-shopping-cart"></i></div>
                                        <div class="text">Products</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.product.add') }}" class="">
                                                <div class="text">Add Product</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.product.index') }}" class="">
                                                <div class="text">Products</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-layers"></i></div>
                                        <div class="text">Brand</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.add-brand') }}" class="">
                                                <div class="text">New Brand</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.brands') }}" class="">
                                                <div class="text">Brands</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-layers"></i></div>
                                        <div class="text">Category</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.category.add') }}" class="">
                                                <div class="text">New Category</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.category.index') }}" class="">
                                                <div class="text">Categories</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-file-plus"></i></div>
                                        <div class="text">Order</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.orders') }}" class="">
                                                <div class="text">Orders</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.order.track') }}" class="">
                                                <div class="text">Order tracking</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item">
                                    <a href="{{ route('admin.slide.index') }}" class="">
                                        <div class="icon"><i class="icon-image"></i></div>
                                        <div class="text">Slides</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="{{ route('admin.coupon') }}" class="">
                                        <div class="icon"><i class="icon-grid"></i></div>
                                        <div class="text">Coupons</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="{{ route('admin.contact.index') }}" class="">
                                        <div class="icon"><i class="icon-grid"></i></div>
                                        <div class="text">Messages</div>
                                    </a>
                                </li>

                                <li class="menu-item">
                                    <a href="{{ route('admin.profile.show') }}" class="">
                                        <div class="icon"><i class="icon-user"></i></div>
                                        <div class="text">User</div>
                                    </a>
                                </li>

                                <li class="menu-item">
                                    <a href="{{ route('admin.profile') }}" class="">
                                        <div class="icon"><i class="icon-settings"></i></div>
                                        <div class="text">Settings</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <form method="post" id="logout-form" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="{{ route('logout') }}" class=""
                                            onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                            <div class="icon"><i class="fa-solid fa-right-from-bracket"></i></div>
                                            <div class="text">LogOut</div>
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="section-content-right">

                    <div class="header-dashboard">
                        <div class="wrap">
                            <div class="header-left">
                                <a href="index-2.html">
                                    <img class="" id="logo_header_mobile" alt=""
                                        src="{{ asset('images/logo/logo.png') }}"
                                        data-light="{{ asset('images/logo/logo.png') }}"
                                        data-dark="{{ asset('images/logo/logo.png') }}" data-width="154px"
                                        data-height="52px" data-retina="{{ asset('images/logo/logo.png') }}">
                                </a>
                                <div class="button-show-hide">
                                    <i class="icon-menu-left"></i>
                                </div>


                                <form class="form-search flex-grow">
                                    <fieldset class="name">
                                        <input type="text" placeholder="Search here..." id="search-input"
                                            class="show-search" name="name" tabindex="2" value=""
                                            aria-required="true" required="">
                                    </fieldset>
                                    <div class="button-submit">
                                        <button class="" type="submit"><i class="icon-search"></i></button>
                                    </div>
                                    <div class="box-content-search">
                                        <ul id="box-content-search" class="search-box"></ul>
                                    </div>
                                </form>

                            </div>
                            <div class="header-grid">

                                <div class="popup-wrap message type-header">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="header-item">
                                                <span class="text-tiny">1</span>
                                                <i class="icon-bell"></i>
                                            </span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end has-content"
                                            aria-labelledby="dropdownMenuButton2">
                                            <li>
                                                <h6>Notifications</h6>
                                            </li>
                                            <li>
                                                <div class="message-item item-1">
                                                    <div class="image">
                                                        <i class="icon-noti-1"></i>
                                                    </div>
                                                    <div>
                                                        <div class="body-title-2">Discount available</div>
                                                        <div class="text-tiny">Morbi sapien massa, ultricies at rhoncus
                                                            at, ullamcorper nec diam</div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="message-item item-2">
                                                    <div class="image">
                                                        <i class="icon-noti-2"></i>
                                                    </div>
                                                    <div>
                                                        <div class="body-title-2">Account has been verified</div>
                                                        <div class="text-tiny">Mauris libero ex, iaculis vitae rhoncus
                                                            et</div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="message-item item-3">
                                                    <div class="image">
                                                        <i class="icon-noti-3"></i>
                                                    </div>
                                                    <div>
                                                        <div class="body-title-2">Order shipped successfully</div>
                                                        <div class="text-tiny">Integer aliquam eros nec sollicitudin
                                                            sollicitudin</div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="message-item item-4">
                                                    <div class="image">
                                                        <i class="icon-noti-4"></i>
                                                    </div>
                                                    <div>
                                                        <div class="body-title-2">Order pending: <span>ID 305830</span>
                                                        </div>
                                                        <div class="text-tiny">Ultricies at rhoncus at ullamcorper
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li><a href="#" class="tf-button w-full">View all</a></li>
                                        </ul>
                                    </div>
                                </div>




                              <!-- Dropdown wrapper -->
<div class="popup-wrap user type-header">
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button"
            id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="header-user wg-user">
                <span class="image">
                    <img src="{{ auth()->user()->image ? asset('uploads/profile/' . auth()->user()->image) : 'https://api.dicebear.com/9.x/initials/svg?seed=' . urlencode(auth()->user()->name) }}"
                        alt="{{ auth()->user()->name }}"
                        class="border"
                        style="width: 48px; height: 48px; object-fit: cover; border-radius: 100%;">
                </span>
                <span class="flex flex-column">
                    <span class="body-title mb-2">{{ auth()->user()->name }}</span>
                    <span class="text-tiny">Admin</span>
                </span>
            </span>
        </button>

        <ul class="dropdown-menu dropdown-menu-end has-content" aria-labelledby="dropdownMenuButton3">
            <li>
                <div class="user-item">
                    <div class="icon"><i class="icon-user"></i></div>
                    <div class="body-title-2">
                        <form action="{{ route('admin.profile') }}" method="GET">
                            @csrf
                            <button type="submit" style="background:none; border:none; padding:0; cursor:pointer;">
                                Profile
                            </button>
                        </form>
                    </div>
                </div>
            </li>
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="user-item">
                    <div class="icon"><i class="icon-log-out"></i></div>
                    <div class="body-title-2">Log out</div>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>


            </li>
        </ul>
    </div>
</div>

<!-- JS scripts at the bottom of body -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Optional: manually initialize all dropdowns to avoid conflicts
        var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
        var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
            return new bootstrap.Dropdown(dropdownToggleEl)
        })
    });
</script>


                            </div>
                        </div>
                    </div>
                    <div class="main-content">
                        @yield('content')

                          {{-- Success Session msg --}}
    @if (session('success'))
        <div class="toast-wrapper">
            <div id="appToast" class="app-toast success">
                <div class="toast-icon">✓</div>

                <div class="toast-content">
                    <strong>Success</strong>
                    <p>{{ session('success') }}</p>
                </div>

                <span class="toast-close">&times;</span>

                {{-- progress bar --}}
                <div class="toast-progress"></div>
            </div>
        </div>
    @endif


                        <div class="bottom-page">
                            <div class="body-text">Copyright © 2024 SurfsideMedia</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @include('sweetalert2::index')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    {{-- <script src="{{ asset('js/bootstrap.min.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    {{-- SEARCH METHOD SCRIPT --}}
    <script>
        const input = document.getElementById('search-input');
        const resultBox = document.getElementById('box-content-search');

        input.addEventListener('keyup', async function() {
            const query = this.value.trim();

            if (query.length < 1) {
                resultBox.innerHTML = '';
                return;
            }

            try {
                const response = await fetch(`{{ route('admin.search') }}?search=${query}`);
                const data = await response.json();

                resultBox.innerHTML = '';

                data.forEach(product => {
                    let url = "{{ route('admin.product.edit', ['id' => '__slug__']) }}";
                    url = url.replace('__slug__', product.id);

                    const li = document.createElement('li');
                    li.innerHTML = `
                <a href="${url}" class="search-item">
                    ${product.name}
                </a>
            `;
                    resultBox.appendChild(li);
                });

            } catch (error) {
                console.error('Search error:', error);
            }
        });
    </script>

     {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Toast trigger --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toast = document.getElementById('appToast');
            if (!toast) return;

            const closeBtn = toast.querySelector('.toast-close');

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(40px)';
                setTimeout(() => toast.remove(), 400);
            }, 3000);

            closeBtn.addEventListener('click', () => toast.remove());
        });
    </script>

    @stack('scripts')
</body>


</html>
