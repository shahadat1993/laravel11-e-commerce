@extends('layouts.admin')
@section('content')
  @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    @endpush
 <div class="main-content-inner">
                            <div class="main-content-wrap">
                                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                    <h3>Slider</h3>
                                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                                        <li>
                                            <a href="{{route('admin.index')}}">
                                                <div class="text-tiny">Dashboard</div>
                                            </a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <div class="text-tiny">Slider</div>
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
                                        <a class="tf-button style-1 w208" href="{{route('admin.slide.add')}}"><i
                                                class="icon-plus"></i>Add new</a>
                                    </div>
                                    <div class="wg-table table-all-user">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class='text-center'>#</th>
                                                    <th class='text-center'>Image</th>
                                                    <th class='text-center'>Tagline</th>
                                                    <th class='text-center'>Title</th>
                                                    <th class='text-center'>Subtitle</th>
                                                    <th class='text-center'>Link</th>
                                                    <th class='text-center'>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($slides as $key=>$slide)
                                                <tr>
                                                    <td class='text-center'>{{ $slides->firstItem() + $key }}</td>
                                                    <td class="pname text-center">
                                                        <div class="image" style="max-width:60%; max-height:80%; object-fit:cover;">
                                                            <img src="{{asset('uploads/slides/'.$slide->image)}}" alt="{{$slide->title}}" class="image img-fluid">
                                                        </div>
                                                    </td>
                                                    <td class='text-center'>{{$slide->tagline}}</td>
                                                    <td class='text-center'>{{$slide->title}}</td>
                                                    <td class='text-center'>{{$slide->subtitle}}</td>
                                                    <td class='text-center' style="max-width: 250px; word-break: break-all;">{{$slide->link}}</td>

                                                    <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center gap-3">
                                                
                                                <!-- Edit Button -->
                                                <a href="{{route('admin.slide.edit',$slide->id)}}" class="text-success">
                                                    <i class="ri-edit-2-line" style="font-size: 20px"></i>
                                                </a>

                                                <!-- Delete Form -->
                                                <form action="{{route('admin.slide.delete',$slide->id)}}" method="POST" class="m-0 p-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="text-danger border-0 delete-btn bg-transparent p-0"
                                                    data-id="{{ $slide->id }}">
                                                    
                                                        
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
                                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                                        {{ $slides->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
                        </div>

@endsection
@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    @if(session('success'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    @endif
</script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const slideId = this.dataset.id;

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
                            fetch(`/admin/slide/destroy/${slideId}`, {
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
