@extends('layouts.app')

@section('content')

<style>
    /* Modern Hover Effect */
    .product-card {
        transition: all 0.3s ease;
        border-radius: 12px;
        overflow: hidden;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .product-img {
        height: 220px;
        object-fit: cover;
        border-bottom: 1px solid #f1f1f1;
    }

    .badge-custom {
        background: #ff7f50;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 12px;
        color: white;
    }

    .product-title {
        font-size: 18px;
        font-weight: 600;
        color: #333;
    }

    .product-title:hover {
        color: #ff7f50;
    }

    .price-text {
        font-size: 17px;
        font-weight: 700;
        color: #28a745;
    }

    @media (max-width: 576px) {
        .product-img {
            height: 160px;
        }
        .product-title {
            font-size: 16px;
        }
    }
</style>

<div class="container py-4">

    <!-- Category Title -->
    <h2 class="mb-4 text-center fw-bold" style="letter-spacing: 1px;">
        {{ $category->name }} – Products
    </h2>

    <!-- If no products -->
    @if($products->count() == 0)
        <div class="alert alert-warning text-center">
            No products available in this category.
        </div>
    @endif

    <div class="row g-4">
        @foreach($products as $product)
        <div class="col-lg-3 col-md-4 col-sm-6 col-6">

            <div class="card product-card shadow-sm">

                <!-- Product Image -->
                <img src="{{ asset('uploads/products/'.$product->image) }}"
                     class="product-img w-100"
                     alt="{{ $product->name }}">

                <div class="card-body text-center">

                    <!-- Product Title -->
                    <a href="{{ route('shop.details', $product->slug) }}"
                       class="product-title text-decoration-none">
                       {{ $product->name }}
                    </a>

                    <!-- Price -->
                    <p class="price-text mt-2">
                        @if ($product->sale_price)
                        <s style="margin-right: 6px">{{ $product->regular_price }}  </s>{{ $product->sale_price }} ৳
                    @else
                    {{ $product->regular_price }} ৳
                    @endif
                         
                    </p>

                    <!-- Details Button -->
                    <a href="{{ route('shop.details', $product->slug) }}"
                       class="btn btn-outline-primary btn-sm mt-2">
                       View Details
                    </a>

                </div>
            </div>

        </div>
        @endforeach
    </div>

</div>
@endsection
