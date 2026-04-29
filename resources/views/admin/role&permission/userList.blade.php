@extends('layouts.admin')

@section('content')
    <style>
        :root {
            --primary-blue: #4f46e5;
            --soft-blue: #f0f4ff;
            --text-main: #0f172a;
            --border-color: #f1f5f9;
        }

        body {
            background-color: #f8fafc;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .fw-700 {
            font-weight: 700;
        }

        .fw-800 {
            font-weight: 800;
        }

        .fs-13 {
            font-size: 13px;
        }

        .fs-14 {
            font-size: 14px;
        }

        .fs-16 {
            font-size: 16px;
        }

        /* Header & Add Button */
        .btn-add-user {
            background: var(--text-main);
            color: white;
            padding: 14px 28px;
            border-radius: 14px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s;
        }

        .btn-add-user:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            color: #fff;
        }

        /* Stat Card */
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        }

        .stat-icon {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .stat-icon.blue {
            background: var(--soft-blue);
            color: var(--primary-blue);
        }

        /* Table Styling */
        .user-card-container {
            background: white;
            border-radius: 24px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.03);
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .table thead th {
            background: #fafbff;
            color: #64748b;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .user-row {
            border-bottom: 1px solid var(--border-color);
            transition: 0.3s;
        }

        .user-row:hover {
            background-color: #fcfdff;
        }

        /* Avatar Styling */
        .user-avatar-wrapper {
            position: relative;
            width: 48px;
            height: 48px;
        }

        .user-img,
        .user-initials {
            width: 100%;
            height: 100%;
            border-radius: 15px;
            object-fit: cover;
        }

        .user-initials {
            background: var(--soft-blue);
            color: var(--primary-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
        }

        .status-dot {
            position: absolute;
            bottom: -2px;
            right: -2px;
            width: 12px;
            height: 12px;
            background: #10b981;
            border: 2px solid white;
            border-radius: 50%;
        }

        /* Badge & Contact */
        .role-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 14px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            color: #475569;
        }

        .contact-box i {
            color: #94a3b8;
        }

        /* Action Buttons Animation */
        .action-flex {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        .action-btn {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            transition: 0.3s;
            text-decoration: none;
            border: none;
        }

        .action-btn.edit {
            background: #f0f7ff;
            color: var(--primary-blue);
        }

        .action-btn.delete {
            background: #fff1f2;
            color: #ef4444;
        }

        .action-btn:hover {
            transform: scale(1.15) rotate(5deg);
        }

        .action-btn.edit:hover {
            background: var(--primary-blue);
            color: white;
        }

        .action-btn.delete:hover {
            background: #ef4444;
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .table thead {
                display: none;
            }

            .user-row {
                display: block;
                padding: 20px;
            }

            .action-flex {
                justify-content: flex-start;
                margin-top: 15px;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <div class="user-list-wrapper py-5">
        <div class="container-fluid px-lg-5">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-4">
                <div class="animate__animated animate__fadeInLeft">
                    <h2 class="fw-800 text-dark mb-1" style="letter-spacing: -1px;">System Managed Users</h2>
                    <p class="text-muted mb-0">Displaying only the users manually created by administrators.</p>
                </div>
                <div class="animate__animated animate__fadeInRight">
                    <a href="{{ route('admin.createUser.index') }}" class="btn-add-user">
                        <i class="ri-user-add-line"></i>
                        <span>Create New User</span>
                    </a>
                </div>
            </div>

            <div class="row mb-4 g-4 animate__animated animate__fadeIn">
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-icon blue"><i class="ri-user-settings-line"></i></div>
                        <div>
                            <h4 class="mb-0 fw-700">{{ $users->count() }}</h4>
                            <p class="text-muted mb-0 small">Admin Created Users</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="user-card-container animate__animated animate__fadeInUp pt-5 mt-5">
                <div class="table-responsive">
                    <table class="table table-borderless align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4 py-4">User Profile</th>
                                <th class="py-4">Access Level</th>
                                <th class="py-4">Contact Info</th>
                                <th class="py-4">Created At</th>
                                <th class="text-end pe-4 py-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr class="user-row">
                                    <td class="ps-4 py-4">
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar-wrapper">
                                                @php
        $imagePath = null;

        if ($user->image) {
            if (file_exists(public_path('uploads/profile/' . $user->image))) {
                $imagePath = asset('uploads/profile/' . $user->image);
            } elseif (file_exists(public_path('uploads/users/' . $user->image))) {
                $imagePath = asset('uploads/users/' . $user->image);
            }
        }
    @endphp
                                                @if ($user->image)
                                                    <img src="{{ $imagePath ?? asset('images/no-image.png') }}"
                                                        alt="User Image">
                                                @else
                                                    <div class="user-initials">{{ strtoupper(substr($user->name, 0, 2)) }}
                                                    </div>
                                                @endif
                                                <span class="status-dot"></span>
                                            </div>
                                            <div class="ms-3">
                                                <div class="fw-700 text-dark fs-16">{{ $user->name }}</div>
                                                <div class="text-muted fs-13">UID: #USR-{{ $user->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        <div class="role-badge">
                                            <i class="ri-shield-check-line me-1"></i>
                                            {{ $user->roles->pluck('name')->first() ?? 'Staff' }}
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        <div class="contact-box">
                                            <div class="fs-14 fw-600 text-dark"><i
                                                    class="ri-mail-line me-2 text-muted"></i>{{ $user->email }}</div>
                                            <div class="fs-13 text-muted"><i
                                                    class="ri-smartphone-line me-2 text-muted"></i>{{ $user->mobile ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 text-muted fs-14">
                                        {{ $user->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="text-end pe-4 py-4">
                                        <div class="action-flex">
                                            <a href="{{ route('admin.createUser.edit', $user->id) }}"
                                                class="action-btn edit" title="Edit User">
                                                <i class="ri-edit-circle-line"></i>
                                            </a>
                                            <form action="{{ route('admin.createUser.destroy', $user->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="button"
                                                    class="action-btn
                                                    delete delete-btn"
                                                    title="Delete User" data-id="{{ $user->id }}">
                                                    <i class="ri-delete-bin-7-line"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80"
                                            class="mb-3 opacity-50">
                                        <h5 class="text-muted">No admin-created users found.</h5>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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
                    const id = this.dataset.id;
                    Swal.fire({
                        title: 'Are you sure?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        confirmButtonText: 'Yes, Delete'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/admin/delete-user/${id}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': token,
                                        'Accept': 'application/json'
                                    }
                                }).then(res => res.json())
                                .then(data => {
                                    location.reload();
                                });
                        }
                    });
                });
            });
        });
    </script>
@endpush
