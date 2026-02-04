@extends('layouts.app')
@section('content')
    <style>
        .brand-list li,
        .category-list li {
            line-height: 40px;
        }

        .brand-list li .chk-brand,
        .category-list li .chk-category {
            width: 1rem;
            height: 1rem;
            border: 0.125rem solid currentColor;
            border-radius: 0;
            margin-right: 0.75rem;
            color: #e4e4e4;
        }

        .filled-heart {
            color: orange;
        }


        /* Menu link styles */
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

        .btn-wishlist{
            background: #111;
            color: #fff;
            border-radius: 10px;
            padding: 10px 25px;
            font-weight: 600;
        }
        .btn-wishlist:hover{
            background: transparent;
            color: #000;
            font-weight: 600;
            border: 1px solid #000;
            transition: all 0.3s ease;
        }
    </style>
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">Wishlist</h2>
            <div class="row">
                <div class="col-lg-3">
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


                    </ul>
                </div>

                <div class="col-lg-9">
                    @if (Cart::instance('wishlist')->content()->count() > 0)
                        <div class="page-content my-account__wishlist">
                            <div class="products-grid row row-cols-2 row-cols-lg-3" id="products-grid">
                                @foreach ($items as $key => $item)
                                    <div class="product-card-wrapper">
                                        <div class="product-card mb-3 mb-md-4 mb-xxl-5">
                                            <div class="pc__img-wrapper">
                                                <div class="swiper-container background-img js-swiper-slider"
                                                    data-settings='{"resizeObserver": true}'>
                                                    <div class="swiper-wrapper">
                                                        <div class="swiper-slide">
                                                            <img loading="lazy"
                                                                src="{{ asset('uploads/products/' . $item->model->image) }}"
                                                                width="330" height="400"
                                                                alt="Cropped Faux leather Jacket" class="pc__img">
                                                        </div>
                                                        @if ($item->model->images)
                                                            @foreach (json_decode($item->model->images) as $img)
                                                                <div class="swiper-slide">
                                                                    <img loading="lazy"
                                                                        src="{{ asset('uploads/products/' . $img) }}"
                                                                        width="330" height="400"
                                                                        alt="{{ $item->name }}" class="pc__img">
                                                                </div>
                                                            @endforeach
                                                        @endif

                                                    </div>
                                                    <span class="pc__img-prev"><svg width="7" height="11"
                                                            viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                                                            <use href="#icon_prev_sm" />
                                                        </svg></span>
                                                    <span class="pc__img-next"><svg width="7" height="11"
                                                            viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                                                            <use href="#icon_next_sm" />
                                                        </svg></span>
                                                </div>
                                                @php
                                                    $product = \App\Models\Product::find($item->id);

                                                @endphp
                                                @if (Cart::instance('cart')->content()->where('id', $product->id)->count() > 0)
                                                    <a href="{{ route('cart') }}"
                                                        class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium btn-warning mb-3">Go
                                                        to cart</a>z
                                                @else
                                                    <form name="addtocart-form" method="post"
                                                        action="{{ route('cart.add') }}">
                                                        @csrf
                                                        <input type="hidden" name="product_id"
                                                            value="{{ $product->id }}">
                                                        <button type="submit"
                                                            class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium"
                                                            data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                                                    </form>
                                                @endif

                                                {{-- Buttor for remove product from wishlist --}}
                                                @php
                                                    $product = \App\Models\Product::find($item->id);

                                                    $wishlistItem = Cart::instance('wishlist')
                                                        ->content()
                                                        ->where('id', $product->id)
                                                        ->first();
                                                @endphp
                                                @if ($wishlistItem)
                                                    <form
                                                        action="{{ route('wishlist.item.remove', $wishlistItem->rowId) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn-remove-from-wishlist">
                                                            <svg width="12" height="12" viewBox="0 0 12 12"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <use href="#icon_close" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form method="POST" action="{{ route('wishlist.add') }}">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $product->id }}">
                                                        <input type="hidden" name="name" value="{{ $product->name }}">
                                                        <input type="hidden" name="price"
                                                            value="{{ $product->sale_price == '' ? $product->regular_price : $product->sale_price }}">
                                                        <input type="hidden" name="quantity" value="1">
                                                        <button class="btn-remove-from-wishlist">
                                                            <svg width="12" height="12" viewBox="0 0 12 12"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <use href="#icon_close" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif


                                            </div>

                                            @php
                                                $product = \App\Models\Product::find($item->id);
                                            @endphp
                                            <div class="pc__info position-relative">
                                                <p class="pc__category">{{ $product->category->name ?? 'No Category' }}
                                                </p>
                                                <h6 class="pc__title"><a
                                                        href="{{ route('shop.details', $product->slug) }}">{{ $product->name }}</a>
                                                </h6>
                                                <div class="product-card__price d-flex">
                                                    <span class="money price">
                                                        @if ($product->sale_price)
                                                            <s style="margin-right: 6px">{{ $product->regular_price }}
                                                            </s>{{ $product->sale_price }}
                                                        @else
                                                            {{ $product->regular_price }}
                                                        @endif
                                                    </span>
                                                </div>

                                                @php
                                                    $wishlistItem = Cart::instance('wishlist')
                                                        ->content()
                                                        ->where('id', $product->id)
                                                        ->first();
                                                @endphp
                                                @if ($wishlistItem)
                                                    <form
                                                        action="{{ route('wishlist.item.remove', $wishlistItem->rowId) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist filled-heart"
                                                            title="Remove from Wishlist">
                                                            <svg width="16" height="16" viewBox="0 0 20 20"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <use href="#icon_heart" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form method="POST" action="{{ route('wishlist.add') }}">
                                                        @csrf
                                                        <input type="hidden" name="id"
                                                            value="{{ $product->id }}">
                                                        <input type="hidden" name="name"
                                                            value="{{ $product->name }}">
                                                        <input type="hidden" name="price"
                                                            value="{{ $product->sale_price == '' ? $product->regular_price : $product->sale_price }}">
                                                        <input type="hidden" name="quantity" value="1">
                                                        <button type="submit"
                                                            class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist"
                                                            title="Add To Wishlist">
                                                            <svg width="16" height="16" viewBox="0 0 20 20"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <use href="#icon_heart" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-md-12">
                                <p>No Item found in WishList</p>
                                <a href="{{ route('shop') }}" class="btn btn-wishlist">WishList Now</a>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </section>
    </main>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // ১. Active Class Manipulation via JS
            const menuLinks = document.querySelectorAll('.menu-link_us-s');
            menuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    menuLinks.forEach(item => item.classList.remove('active'));
                    this.classList.add('active');
                });
            })
        });
    </script>
@endpush
