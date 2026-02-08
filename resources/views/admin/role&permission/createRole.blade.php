@php
    use Illuminate\Support\Facades\Session;
@endphp
@extends('layouts.admin')

@section('content')
    <style>
        .permission-item {
            background: #ffffff;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            border: 2px solid #e2e8f0 !important;
        }

        .permission-item:hover {
            border-color: #4f46e5 !important;
            background-color: #f5f3ff;
        }

        /* সিলেক্টেড বা চেকড অবস্থা (Highlight Effect) */
        .permission-item:has(.permission-checkbox:checked) {
            border-color: #4f46e5 !important;
            background-color: #f0efff !important;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
        }

        .permission-item:has(.permission-checkbox:checked) .label-text {
            color: #4f46e5 !important;
            font-weight: 700;
        }

        .permission-checkbox {
            width: 1.5rem;
            height: 1.5rem;
            cursor: pointer;
            border: 2px solid #cbd5e1;
        }

        .permission-checkbox:checked {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }

        .is-invalid-input {
            border: 1px solid #ef4444 !important;
            background-color: #fff1f2 !important;
        }

        .error-text {
            color: #ef4444;
            font-size: 0.85rem;
            font-weight: 600;
            margin-top: 5px;
            display: block;
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem !important;
            }

            .btn {
                width: 100%;
            }
        }
    </style>

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-bold text-dark mb-0">Role Management</h3>
                    <a href="{{ route('admin.roles') }}" class="btn btn-outline-primary shadow-sm px-4"
                        style="border-radius: 10px; font-weight: 600; font-size: 15px; margin-bottom: 10px;">
                        <i class="fas fa-list me-2"></i> View Role List
                    </a>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm mb-4 animate__animated animate__shakeX"
                         style="border-radius: 15px; background: #fff1f2; color: #e11d48;">
                        <ul class="mb-0 fw-bold">
                            @foreach ($errors->all() as $error)
                                <li><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card border-0 shadow-lg" style="border-radius: 20px; background: #ffffff; overflow: hidden;">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <div class="d-flex align-items-center">
                            <div class="icon-box me-3"
                                style="background: #4f46e5; color: white; padding: 12px; border-radius: 12px;">
                                <i class="fas fa-user-shield fa-lg"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-0 text-dark">Create New Role</h4>
                                <p class="text-muted mb-0 small">Assign permissions to define user access levels</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('admin.storeRole') }}" method="POST">
                            @csrf

                            <div class="row mb-5">
                                <div class="col-lg-12">
                                    <label class="form-label fw-bold text-dark mb-2" style="font-size: 1rem;">Role Name</label>
                                    <div class="input-group shadow-sm @error('name') is-invalid-input @enderror"
                                        style="border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0;">
                                        <span class="input-group-text border-0 bg-white px-3"><i class="fas fa-tag text-muted"></i></span>
                                        <input type="text" name="name" class="form-control border-0 py-3"
                                            placeholder="Ex: Senior Editor, Manager" required value="{{ old('name') }}"
                                            style="font-size: 16px; outline: none !important; box-shadow: none;">
                                    </div>
                                    @error('name')
                                        <span class="error-text"><i class="fas fa-info-circle"></i> {{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="permissions-container bg-light p-4 rounded-4" style="border: 1px dashed #cbd5e1;">
                                <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                                    <h5 class="fw-bold text-dark mb-0"><i class="fas fa-lock me-2 text-primary"></i>Assign Permissions</h5>

                                    <div class="form-check d-flex align-items-center m-0 p-0">
                                        <input class="form-check-input" type="checkbox" id="selectAll"
                                            style="width: 1.2rem; height: 1.2rem; cursor: pointer; float: none; margin: 0;">
                                        <label class="form-check-label fw-bold text-primary ms-2 mt-1" for="selectAll"
                                            style="cursor: pointer; user-select: none;">
                                            Select All
                                        </label>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    @foreach ($permissions as $permission)
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                            <label class="permission-item p-3 border rounded-4 d-flex align-items-center h-100 mb-0 transition-all"
                                                for="perm-{{ $permission->id }}">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                    id="perm-{{ $permission->id }}"
                                                    class="permission-checkbox form-check-input me-3"
                                                    {{ is_array(old('permissions')) && in_array($permission->name, old('permissions')) ? 'checked' : '' }}>
                                                <span class="text-dark fw-medium text-capitalize label-text"
                                                    style="font-size: 16px;">
                                                    {{ str_replace(['-', '_'], ' ', $permission->name) }}
                                                </span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('permissions')
                                    <span class="error-text mt-3"><i class="fas fa-info-circle"></i> {{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mt-5 d-flex flex-column flex-md-row justify-content-end gap-3">
                                <button type="reset" id="resetBtn" class="btn btn-light fw-bold px-4 py-3"
                                    style="border-radius: 12px;font-size: 15px; border: 1px solid #e2e8f0;">Clear Form</button>
                                <button type="submit" class="btn btn-primary fw-bold px-5 py-3 shadow"
                                    style="background: #4f46e5 !important; border: none; border-radius: 12px; font-size: 15px;">
                                    <i class="fas fa-check-circle me-2"></i> Save New Role
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // SweetAlert Notifications
        @if(Session::has('success'))
            Swal.fire({
                icon: 'success',
                title: 'Great!',
                text: "{{ Session::get('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if(Session::has('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ Session::get('error') }}",
            });
        @endif

        // 'Select All' ফাংশনালিটি
        document.getElementById('selectAll').addEventListener('change', function() {
            let checkboxes = document.querySelectorAll('.permission-checkbox');
            checkboxes.forEach(cb => {
                cb.checked = this.checked;
            });
        });

        // ইন্ডিভিজুয়াল চেক করার সময় 'Select All' অটো-আপডেট হওয়া
        const permissionCheckboxes = document.querySelectorAll('.permission-checkbox');
        permissionCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const selectAll = document.getElementById('selectAll');
                const allChecked = Array.from(permissionCheckboxes).every(cb => cb.checked);
                selectAll.checked = allChecked;
            });
        });

        // পেজ লোড হওয়ার সময় চেক করা (যদি old data থাকে)
        window.addEventListener('load', function() {
            const selectAll = document.getElementById('selectAll');
            const allChecked = Array.from(permissionCheckboxes).every(cb => cb.checked);
            if(permissionCheckboxes.length > 0) {
                selectAll.checked = allChecked;
            }
        });
    </script>
    @endpush
@endsection
