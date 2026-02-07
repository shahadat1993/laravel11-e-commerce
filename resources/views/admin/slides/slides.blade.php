@extends('layouts.admin')

@section('content')
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap');

            .main-content-inner {
                font-family: 'Plus Jakarta Sans', sans-serif;
                background: #f0f2f5;
                padding: 40px 25px;
            }

            /* প্রিমিয়াম হেডার */
            .page-title {
                font-size: 32px !important;
                font-weight: 800;
                background: linear-gradient(to right, #1e293b, #4f46e5);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                letter-spacing: -1px;
            }

            /* মেইন বক্স ডিজাইন */
            .wg-box {
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(10px);
                border-radius: 30px;
                padding: 35px;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.05);
                border: 1px solid #ffffff;
            }

            /* সার্চ এবং অ্যাড বাটন এরিয়া */
            .inner-search-wrapper {
                position: relative;
                max-width: 350px;
            }

            .inner-search-wrapper input {
                width: 100%;
                padding: 12px 20px 12px 45px !important;
                border-radius: 15px !important;
                border: 1.5px solid #e2e8f0 !important;
                background: #f8fafc !important;
                font-weight: 600;
                transition: 0.4s all;
            }

            .inner-search-wrapper input:focus {
                border-color: #4f46e5 !important;
                background: #fff !important;
                box-shadow: 0 8px 20px rgba(79, 70, 229, 0.08) !important;
            }

            .search-icon-inside {
                position: absolute;
                left: 15px;
                top: 50%;
                transform: translateY(-50%);
                color: #94a3b8;
                font-size: 18px;
            }

            .btn-add-new {
                background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
                color: white !important;
                padding: 12px 25px;
                border-radius: 15px;
                font-weight: 700;
                display: flex;
                align-items: center;
                gap: 8px;
                transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                box-shadow: 0 10px 20px rgba(79, 70, 229, 0.2);
                font-size: 15px;
            }

            .btn-add-new:hover {
                transform: translateY(-3px) scale(1.02);
                box-shadow: 0 15px 25px rgba(79, 70, 229, 0.3);
            }

            /* টেবিল ডিজাইন */
            .table-responsive {
                border-radius: 20px;
            }

            .table {
                border-collapse: separate;
                border-spacing: 0 15px;
                margin-top: -15px;
            }

            .table thead th {
                background: transparent;
                border: none;
                color: #64748b;
                font-weight: 700;
                text-transform: uppercase;
                font-size: 16px;
                letter-spacing: 1.5px;
                padding: 15px;
            }

            .table tbody tr {
                background: #ffffff;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.02);
                transition: 0.4s ease;
            }

            .table tbody tr:hover {
                transform: translateY(-3px);
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.06);
            }

            .table td {
                padding: 15px !important;
                border: none;
                vertical-align: middle;
                font-size: 14px;
            }

            .table td:first-child {
                border-radius: 20px 0 0 20px;
            }

            .table td:last-child {
                border-radius: 0 20px 20px 0;
            }

            /* স্লাইডার ইমেজ প্রিভিউ */
            .slide-img-container {
                width: 140px;
                height: 80px;
                overflow: hidden;
                border-radius: 12px;
                border: 2px solid #f1f5f9;
                transition: 0.4s;
            }

            .slide-img-container img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: 0.6s;
            }

            tr:hover .slide-img-container img {
                transform: scale(1.1);
            }

            /* অ্যাকশন বাটন এনিমেশন */
            .action-btn {
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 12px;
                transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                text-decoration: none;
            }

            .btn-edit {
                background: #dcfce7;
                color: #166534;
            }

            .btn-edit:hover {
                background: #166534;
                color: #fff;
                transform: rotate(15deg) scale(1.2);
            }

            .btn-delete {
                background: #fee2e2;
                color: #991b1b;
                cursor: pointer;
                border: none;
            }

            .btn-delete:hover {
                background: #991b1b;
                color: #fff;
                transform: rotate(-15deg) scale(1.2);
            }

            /* লিংক টেক্সট */
            .link-box {
                background: #f1f5f9;
                padding: 6px 12px;
                border-radius: 8px;
                font-size: 12px;
                color: #475569;
                max-width: 200px;
                display: inline-block;
            }

            @media (max-width: 768px) {
                .flex.justify-between {
                    flex-direction: column;
                    gap: 15px;
                }

                .inner-search-wrapper {
                    max-width: 100%;
                }
            }
        </style>
    @endpush

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h3 class="page-title">Manage Sliders</h3>
                    <div class="flex items-center gap-2 text-slate-500 font-medium mt-1">
                        <span>Admin</span> <i class="ri-arrow-right-s-line"></i> <span>Sliders List</span>
                    </div>
                </div>
                <a class="btn-add-new" href="{{ route('admin.slide.add') }}">
                    <i class="ri-add-circle-fill text-xl"></i> Add New Slide
                </a>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap mb-6">
                    <div class="inner-search-wrapper flex-grow">
                        <i class="ri-search-eye-line search-icon-inside"></i>
                        <form class="form-search">
                            <input type="text" placeholder="Search sliders..." name="name" required>
                        </form>
                    </div>
                </div>

                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class='text-center'>#</th>
                                    <th class='text-center'>Preview</th>
                                    <th class='text-center'>Tagline</th>

                                    <th class='text-center'>Title</th>
                                    <th class='text-center'>SubTitle</th>

                                    <th class='text-center'>Target Link</th>
                                    <th class='text-center'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($slides as $key => $slide)
                                    <tr>
                                        <td class='text-center font-bold text-slate-300'>{{ $slides->firstItem() + $key }}
                                        </td>
                                        <td class="text-center">
                                            <div class="flex justify-center">
                                                <div class="slide-img-container shadow-sm">
                                                    <img src="{{ asset('uploads/slides/' . $slide->image) }}"
                                                        alt="{{ $slide->title }}">
                                                </div>
                                            </div>
                                        </td>
                                        <td class='text-center'>
                                            <span
                                                class="bg-indigo-50 text-indigo-600 px-3 py-1 rounded-full text-xs font-extrabold">
                                                {{ $slide->tagline }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="font-extrabold text-slate-800">{{ $slide->title }}</div>

                                        </td>
                                        <td>

                                            <div class="text-xs text-slate-400 font-medium">{{ $slide->subtitle }}</div>
                                        </td>
                                        <td class='text-center'>
                                            <div class="link-box text-truncate">{{ $slide->link }}</div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center gap-3">
                                                <a href="{{ route('admin.slide.edit', $slide->id) }}"
                                                    class="action-btn btn-edit" title="Edit Slide">
                                                    <i class="ri-edit-box-line"></i>
                                                </a>
                                                <form action="{{ route('admin.slide.delete', $slide->id) }}" method="POST"
                                                    class="m-0 p-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="action-btn btn-delete delete-btn"
                                                        data-id="{{ $slide->id }}" title="Delete Slide">
                                                        <i class="ri-delete-bin-7-line"></i>
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

                <div class="divider my-6"></div>
                <div class="d-flex justify-content-center">
                    {{ $slides->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('success'))
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

        document.addEventListener('DOMContentLoaded', function() {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const slideId = this.dataset.id;

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This slide will be permanently removed!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#4f46e5',
                        cancelButtonColor: '#ef4444',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'No, keep it'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/admin/slide/destroy/${slideId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': token,
                                        'Accept': 'application/json',
                                    }
                                })
                                .then(res => res.json())
                                .then(data => {
                                    Swal.fire('Deleted!', data.message, 'success')
                                        .then(() => location.reload());
                                })
                                .catch(err => {
                                    Swal.fire('Error!', 'Something went wrong!',
                                        'error');
                                });
                        }
                    });
                });
            });
        });
    </script>
@endpush
