@extends('layouts.admin')

@section('content')
    <style>
        :root {
            --bg-main: #f8fafc;
            --accent-primary: #4338ca;
            --accent-secondary: #6366f1;
            --text-dark: #1e1b4b;
            --text-light: #64748b;
            --border-soft: #e2e8f0;
            --shadow-lux: 0 10px 30px rgba(0, 0, 0, 0.04);
        }

        body {
            background-color: var(--bg-main);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Header Styling */
        .header-card {
            background: #ffffff;
            padding: 40px;
            /* Increased Padding */
            border-radius: 24px;
            box-shadow: var(--shadow-lux);
            border: 1px solid #ffffff;
        }

        .icon-orb {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
            color: white;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 10px 20px rgba(67, 56, 202, 0.2);
        }

        .title-text {
            font-weight: 800;
            color: var(--text-dark);
            font-size: 28px;
            letter-spacing: -0.5px;
        }

        .subtitle-text {
            color: var(--text-light);
            font-size: 15px;
        }

        /* Button Styling */
        .btn-premium-add {
            position: relative;
            display: inline-flex;
            background: var(--text-dark);
            color: white;
            padding: 14px 28px;
            border-radius: 14px;
            font-weight: 700;
            text-decoration: none;
            overflow: hidden;
            transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-premium-add:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            color: white;
        }

        .btn-shimmer {
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
            transition: 0.6s;
        }

        .btn-premium-add:hover .btn-shimmer {
            left: 100%;
        }

        /* Table Spacing */
        .table-container {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: var(--shadow-lux);
            border: 1px solid var(--border-soft);
            overflow: hidden;
        }

        .table thead th {
            background: #fcfdfe;
            color: var(--text-light);
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            border-bottom: 1px solid #f1f5f9;
        }

        .premium-row {
            transition: background 0.2s ease;
            border-bottom: 1px solid #f8fafc;
        }

        .premium-row:hover {
            background-color: #fcfdff;
        }

        /* Identity & Avatar */
        .identity-box {
            display: flex;
            align-items: center;
        }

        .avatar-capsule {
            width: 46px;
            height: 46px;
            background: #f0f4ff;
            color: var(--accent-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-weight: 800;
            font-size: 14px;
        }

        .role-name {
            font-weight: 700;
            color: var(--text-dark);
            font-size: 16px;
            margin-bottom: 2px;
        }

        .role-id {
            font-size: 13px;
            color: var(--text-light);
        }

        /* Tag Cloud Spacing */
        .glass-tag {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 6px 14px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            color: #475569;
        }

        .plus-more {
            font-size: 12px;
            font-weight: 700;
            color: var(--accent-primary);
            background: #eff2ff;
            padding: 6px 10px;
            border-radius: 8px;
        }

        /* Metric Spacing */
        .user-metric {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .metric-value {
            font-weight: 800;
            font-size: 18px;
            color: var(--text-dark);
        }

        .metric-label {
            font-size: 11px;
            color: var(--text-light);
            text-transform: uppercase;
            font-weight: 600;
            margin-top: 2px;
        }

        /* Action Links */
        .orbit-link {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s ease;
            text-decoration: none;
            font-size: 16px;
            border: none;
        }

        .edit {
            background: #f0f7ff;
            color: #0284c7;
        }

        .delete {
            background: #fff1f2;
            color: #e11d48;
        }

        .orbit-link:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        /* Responsive Spacing Adjustments */
        @media (max-width: 991px) {
            .header-card {
                padding: 30px;
                text-align: center;
            }

            .header-card .d-flex {
                flex-direction: column;
                gap: 15px;
            }

            .btn-premium-add {
                width: 100%;
                justify-content: center;
            }

            .table thead {
                display: none;
            }

            .ps-5,
            .pe-5 {
                padding-left: 20px !important;
                padding-right: 20px !important;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <div class="role-management-wrapper py-5 px-3 px-lg-0">
        <div class="container-fluid px-lg-5">

            <div class="header-card mb-5 animate__animated animate__fadeIn">
                <div class="row align-items-center py-2 px-3">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center gap-4">
                            <div class="icon-orb">
                                <i class="fas fa-fingerprint"></i>
                            </div>
                            <div>
                                <h2 class="title-text mb-1">Role Architecture</h2>
                                <p class="subtitle-text mb-0">Manage system access levels with precision</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end mt-4 mt-md-0">
                        <a href="{{ route('admin.createRole') }}" class="btn-premium-add">
                            <div class="btn-content">
                                <i class="fas fa-plus me-2"></i>
                                <span>New Access Role</span>
                            </div>
                            <div class="btn-shimmer"></div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="table-container animate__animated animate__fadeInUp">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-5 py-4">Role Identity</th>
                                <th class="py-4">Capabilities</th>
                                <th class="text-center py-4">Active Workforce</th>
                                <th class="text-end pe-5 py-4">Orchestrate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr class="premium-row">
                                    <td class="ps-5 py-4">
                                        <div class="identity-box">
                                            <div class="avatar-capsule">
                                                {{ strtoupper(substr($role->name, 0, 2)) }}
                                            </div>
                                            <div class="ms-3">
                                                <div class="role-name">{{ $role->name }}</div>
                                                <div class="role-id">#ID-{{ $role->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        <div class="permission-cloud d-flex flex-wrap gap-2">
                                            @forelse($role->permissions->take(3) as $permission)
                                                <span class="glass-tag">
                                                    {{ str_replace(['-', '_'], ' ', $permission->name) }}
                                                </span>
                                            @empty
                                                <span class="no-access">Limited Access</span>
                                            @endforelse
                                            @if ($role->permissions->count() > 3)
                                                <span class="plus-more">+{{ $role->permissions->count() - 3 }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center py-4">
                                        <div class="user-metric">
                                            <span
                                                class="metric-value">{{ $role->users_count ?? $role->users->count() }}</span>
                                            <span class="metric-label">Users</span>
                                        </div>
                                    </td>
                                    <td class="text-end pe-5 py-4">
                                        <div class="action-orbit d-flex justify-content-end gap-3">
                                            <a href="{{ route('admin.editRole', $role->id) }}" class="orbit-link edit"
                                                title="Edit Structure">
                                                <i class="fas fa-pen-fancy"></i>
                                            </a>
                                            <form id="delete-form-{{ $role->id }}"
                                                action="{{ route('admin.deleteRole', $role->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="button" class="orbit-link delete delete-btn"
                                                    data-id="{{ $role->id }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($roles->hasPages())
                    <div class="pagination-container py-4 px-5 border-top border-light d-flex justify-content-center">
                        {{ $roles->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    // এটি ফর্মের ডিফল্ট সাবমিশন আটকাবে
                    e.preventDefault();

                    const id = this.dataset.id;
                    const form = document.getElementById(`delete-form-${id}`);

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This role and its permissions will be removed!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e11d48', // আপনার ডিলিট বাটনের কালার
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Yes, Delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
