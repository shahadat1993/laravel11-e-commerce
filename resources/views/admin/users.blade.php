@extends('layouts.admin')
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
@endpush
@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Users</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('dashboard') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">All User</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search">
                            <fieldset class="name">
                                <input type="text" placeholder="Search here..." class="" name="name"
                                    tabindex="2" value="" aria-required="true" required="">
                            </fieldset>
                            <div class="button-submit">
                                <button class="" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="wg-table table-all-user">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">User</th>
                                    <th class="text-center">Profile Image</th>
                                    <th class="text-center">Phone</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center" class="text-center">Total Orders</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $user)
                                    <tr>
                                        <td class="text-center">{{ $users->firstItem() + $key }}</td>
                                        <td class="text-center" class="pname">
                                            {{ $user->name }}
                                        </td>
                                        <td class="text-center">
                                            <img src="{{ $user->image ? asset('uploads/profile/' . $user->image) : asset('images/no-image.png') }}"
                                                alt="{{ $user->name }}" class="img-fluid rounded"
                                                style="width:80px;height:80px;object-fit:cover;">
                                        </td>
                                        <td class="text-center">{{ $user->mobile }}</td>
                                        <td class="text-center">{{ $user->email }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.user.orders', $user->id) }}" target="_blank">
                                                {{ $user->orders->count() }}
                                            </a>
                                        </td>

                                        <td class="text-center">
                                            <div
                                                class="list-icon-function text-center d-flex justify-content-center align-items-center gap10">
                                                <form action="{{ route('admin.user.delete', $user->id) }}" method="POST"
                                                    class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="text-danger border-0 bg-transparent delete-btn fs-4"
                                                        data-id="{{ $user->id }}">
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

                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{ $users->links('pagination::bootstrap-5') }}
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
                    const userId = this.dataset.id;

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
                            fetch(`/admin/user/delete/${userId}`, {
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
