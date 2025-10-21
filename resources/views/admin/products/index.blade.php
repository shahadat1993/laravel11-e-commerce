@extends('layouts.admin')

@section('content')
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    @endpush

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Products</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Products</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search">
                            <fieldset class="name">
                                <input type="text" placeholder="Search here..." name="name" value="">
                            </fieldset>
                            <div class="button-submit">
                                <button type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('admin.product.add') }}">
                        <i class="icon-plus"></i>Add new
                    </a>
                </div>

                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Image</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Sale Price</th>
                                    <th class="text-center">SKU</th>
                                    <th class="text-center">Category</th>
                                    <th class="text-center">Brand</th>
                                    <th class="text-center">Featured</th>
                                    <th class="text-center">Stock</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $key => $product)
                                    <tr>
                                        <td class="text-center">{{ $products->firstItem() + $key }}</td>
                                        <td class="pname d-flex justify-content-center align-items-center">

                                            <div class="name">
                                                <a href="#" class="body-title-2">{{ $product->name }}</a>
                                                <div class="text-tiny mt-3">{{ $product->slug }}</div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <img src="{{ $product->image ? asset('uploads/products/' . $product->image) : asset('images/no-image.png') }}"
                                                alt="{{ $product->name }}" class="img-fluid rounded"
                                                style="width:80px;height:80px;object-fit:cover;">

                                        </td>
                                        <td class="text-center">{{ $product->regular_price }}</td>
                                        <td class="text-center">{{ $product->sale_price }}</td>
                                        <td class="text-center">{{ $product->sku }}</td>
                                        <td class="text-center">{{ $product->category?->name ?? '-' }}</td>
                                        <td class="text-center">{{ $product->brand?->name ?? '-' }}</td>
                                        <td
                                            class="{{ $product->featured == 0 ? 'text-danger' : 'text-success' }} text-center">
                                            {{ $product->featured == 0 ? 'NO' : 'YES' }}
                                        </td>
                                        <td
                                            class="{{ $product->stock_status == 'instock' ? 'text-success' : 'text-danger' }} text-center">
                                            {{ $product->stock_status }}
                                        </td>
                                        <td class="text-center">{{ $product->quantity }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center gap-3">
                                                <!-- View Button -->
                                                <a href="#" target="_blank" class="text-primary">
                                                    <i class="ri-eye-fill" style="font-size: 20px"></i>
                                                </a>

                                                <!-- Edit Button -->
                                                <a href="{{route('admin.product.edit',$product->id)}}" class="text-success">
                                                    <i class="ri-edit-2-line" style="font-size: 20px"></i>
                                                </a>

                                                <!-- Delete Form -->
                                                <form action="{{route('admin.product.destroy',$product->id)}}" method="POST" class="m-0 p-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="text-danger border-0 delete-btn bg-transparent p-0"
                                                        data-id="{{ $product->id }}">
                                                        <i class="ri-delete-bin-5-line" style="font-size: 20px"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="divider"></div>
                    <div class="d-flex align-items-center justify-content-center">
                        {{ $products->links('pagination::bootstrap-5') }}
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
                    const productId = this.dataset.id;

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/admin/product/destroy/${productId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': token,
                                        'Accept': 'application/json',
                                    }
                                })
                                .then(res => {
                                    if (!res.ok) throw new Error(
                                        'Network response was not ok');
                                    return res.json();
                                })
                                .then(data => {
                                    Swal.fire('Deleted!', data.message ||
                                            'Brand deleted successfully.', 'success')
                                        .then(() => location.reload());
                                })
                                .catch(err => {
                                    Swal.fire('Error!', 'Something went wrong!',
                                        'error');
                                    console.error(err);
                                });
                        }
                    });
                });
            });
        });
    </script>
@endpush
