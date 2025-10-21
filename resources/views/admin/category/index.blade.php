@extends('layouts.admin')

@section('content')
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    @endpush

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Categories</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Categories</div>
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
                    <a class="tf-button style-1 w208" href="{{ route('admin.category.add') }}">
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
                                    <th class="text-center">Category Image</th>
                                    <th class="text-center">Slug</th>
                                    <th class="text-center">Products</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $key => $category)
                                    <tr>
                                        <td class="text-center">{{ $categories->firstItem() + $key }}</td>
                                        <td class="pname d-flex justify-content-center align-items-center>
                                            <a href="#"
                                            class="body-title-2">{{ $category->name }}</a>
                                        </td>
                                        <td class="text-center">
                                            <img src="{{ $category->image ? asset('uploads/categories/' . $category->image) : asset('images/no-image.png') }}"
                                                alt="{{ $category->name }}" class="img-fluid rounded"
                                                style="width: 80px; height: 80px; object-fit: cover;">
                                        </td>
                                        <td class="text-center">{{ $category->slug }}</td>
                                        <td class="text-center"><a href="#" target="_blank">1</a></td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <a href="{{route('admin.category.edit',$category->id)}}"
                                                    class="text-success fs-4">
                                                    <i class="ri-edit-2-line" style="font-size: 25px"></i>
                                                </a>

                                                <form action="{{ route('admin.category.destroy',$category->id) }}" method="POST"
                                                    class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="text-danger border-0 bg-transparent delete-btn fs-4"
                                                        data-id="{{ $category->id }}">
                                                        <i class="ri-delete-bin-5-line" style="font-size: 25px"></i>
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
                        {{ $categories->links('pagination::bootstrap-5') }}
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
                   const categoryId = this.dataset.id;

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
                           fetch(`/admin/category/destroy/${categoryId}`, {
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
