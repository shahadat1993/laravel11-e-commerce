@php
    use Illuminate\Support\Str;
@endphp
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

            .page-title {
                font-size: 32px !important;
                font-weight: 800;
                background: linear-gradient(to right, #1e293b, #4f46e5);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                letter-spacing: -1px;
            }

            .wg-box {
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(10px);
                border-radius: 30px;
                padding: 35px;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.05);
                border: 1px solid #ffffff;
            }

            /* ইন-বক্স সার্চ বার */
            .inner-search-wrapper {
                position: relative;
                max-width: 400px;
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
                box-shadow: 0 8px 20px rgba(79, 70, 229, 0.08) !important;
                outline: none;
            }

            .search-icon-inside {
                position: absolute;
                left: 15px;
                top: 50%;
                transform: translateY(-50%);
                color: #94a3b8;
                font-size: 18px;
            }

            /* টেবিল কাস্টমাইজেশন */
            .table-responsive {
                border-radius: 20px;
            }

            .table {
                border-collapse: separate;
                border-spacing: 0 12px;
                margin-top: -12px;
            }

            .table thead th {
                background: transparent;
                border: none;
                color: #64748b;
                font-weight: 700;
                text-transform: uppercase;
                font-size: 11px;
                letter-spacing: 1px;
                padding: 15px 20px;
                font-size: 16px;
            }

            .table tbody tr {
                background: #ffffff;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.02);
                transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            }

            .table tbody tr:hover {
                transform: translateY(-3px) scale(1.002);
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.06);
            }

            .table td {
                padding: 20px !important;
                border: none;
                vertical-align: middle;
                font-size: 14px;

            }

            /* কন্টাক্ট ইনফো স্টাইল */
            .user-info-box {
                display: flex;
                flex-direction: column;
                gap: 2px;
            }

            .user-name {
                font-weight: 800;
                color: #1e293b;
                font-size: 15px;
            }

            .user-meta {
                font-size: 12px;
                color: #64748b;
                font-weight: 600;
            }

            /* মেসেজ কলাম স্টাইল */
            .message-preview {
                max-width: 250px;
                font-size: 13px;
                color: #475569;
                line-height: 1.5;
                background: #f8fafc;
                padding: 10px 15px;
                border-radius: 12px;
                border: 1px solid #f1f5f9;
                word-wrap: break-word;
            }

            /* ডিলিট বাটন অ্যানিমেশন */
            .btn-delete-msg {
                width: 45px;
                height: 45px;
                background: #fee2e2;
                color: #ef4444;
                border-radius: 15px;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                border: none;
                cursor: pointer;
            }

            .btn-delete-msg:hover {
                background: #ef4444;
                color: #fff;
                transform: rotate(-15deg) scale(1.15);
                box-shadow: 0 10px 20px rgba(239, 68, 68, 0.2);
            }

            .date-badge {
                font-size: 12px;
                font-weight: 700;
                color: #4f46e5;
                background: #eef2ff;
                padding: 5px 12px;
                border-radius: 8px;
                display: inline-block;
            }

            @media (max-width: 768px) {
                .inner-search-wrapper {
                    max-width: 100%;
                    margin-bottom: 20px;
                }
            }
        </style>
    @endpush

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h3 class="page-title">Contact Inquiries</h3>
                    <div class="flex items-center gap-2 text-slate-500 font-medium mt-1">
                        <span>Admin</span> <i class="ri-arrow-right-s-line"></i> <span>Message Inbox</span>
                    </div>
                </div>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap mb-8">
                    <div class="inner-search-wrapper flex-grow">
                        <i class="ri-search-2-line search-icon-inside"></i>
                        <form class="form-search">
                            <input type="text" placeholder="Search by name or email..." name="name" required>
                        </form>
                    </div>
                </div>

                <div class="wg-table">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Sender Details</th>
                                    <th>Message Content</th>
                                    <th class="text-center">Received At</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contacts as $key => $contact)
                                    <tr id="row_{{ $contact->id }}">
                                        <td class="text-center font-bold text-slate-300">
                                            #{{ $contacts->firstItem() + $key }}</td>
                                        <td>
                                            <div class="user-info-box">
                                                <span class="user-name">{{ $contact->name }}</span>
                                                <span class="user-meta"><i class="ri-mail-line"></i>
                                                    {{ $contact->email }}</span>
                                                <span class="user-meta"><i class="ri-phone-line"></i>
                                                    {{ $contact->phone }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="message-preview">
                                                {{ Str::limit($contact->comment, 150) }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="date-badge">
                                                <i class="ri-time-line"></i>
                                                {{ $contact->created_at->format('d M, Y') }}<br>
                                                <small
                                                    class="text-slate-500 font-medium">{{ $contact->created_at->format('h:i A') }}</small>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="flex justify-center">
                                                <form action="{{ route('admin.contact.destroy', $contact->id) }}"
                                                    method="POST" class="delete-form m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn-delete-msg delete-btn"
                                                        data-id="{{ $contact->id }}">
                                                        <i class="ri-delete-bin-line text-2xl"></i>
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
                <div class="d-flex align-items-center justify-content-center">
                    {{ $contacts->links('pagination::bootstrap-5') }}
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
                text: "This Message will be permanently deleted!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#ef4444',
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('/admin/contact/delete') }}/" + id,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: response.message,
                                    icon: "success",
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                $("#row_" + id).fadeOut(500, function() {
                                    $(this).remove();
                                });
                            } else {
                                Swal.fire("Error!", "Something went wrong.", "error");
                            }
                        },
                        error: function() {
                            Swal.fire("Error!", "Failed to delete the message.", "error");
                        }
                    });
                }
            });
        });
    </script>
@endpush
