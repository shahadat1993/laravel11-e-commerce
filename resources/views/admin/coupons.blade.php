@extends('layouts.admin')
 @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    @endpush
@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Coupons</h3>
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
                        <div class="text-tiny">Coupons</div>
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
                    <a class="tf-button style-1 w208" href="{{ route('admin.coupon.add') }}"><i class="icon-plus"></i>Add
                        new</a>
                </div>
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Code</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Value</th>
                                    <th class="text-center">Cart Value</th>
                                    <th class="text-center">Expiry Date</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coupons as $key => $coupon)
                                    <tr id="row_{{ $coupon->id }}">
                                        <td class="text-center">{{ $coupons->firstItem() + $key }}</td>
                                        <td class="text-center">{{ $coupon->code }}</td>
                                        <td class="text-center">{{ $coupon->type }}</td>
                                        <td class="text-center">{{ $coupon->value }}</td>
                                        <td class="text-center">{{ $coupon->cart_value }}</td>
                                        <td class="text-center">{{ $coupon->expiry_date }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <a href="{{route('admin.coupon.edit', $coupon->id)}}"
                                                    class="text-success fs-4">
                                                    <i class="ri-edit-2-line" style="font-size: 25px"></i>
                                                </a>

                                                <form action="{{route('admin.coupon.destroy',$coupon->id)}}" method="POST"
                                                    class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="text-danger border-0 bg-transparent delete-btn fs-4"
                                                        data-id="{{ $coupon->id }}"
                                                        type="button"
                                                       >
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
                        Swal.fire("Deleted!", response.message, "success");
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

