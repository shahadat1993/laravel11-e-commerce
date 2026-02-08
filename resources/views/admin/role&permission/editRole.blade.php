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
    </style>

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-bold text-dark mb-0">Role Management</h3>
                    <a href="{{ route('admin.roles') }}" class="btn btn-outline-primary shadow-sm px-4"
                        style="border-radius: 10px; font-weight: 600; font-size: 15px;">
                        <i class="fas fa-list me-2"></i> View Role List
                    </a>
                </div>

                <div class="card border-0 shadow-lg" style="border-radius: 20px; background: #ffffff; overflow: hidden;">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <div class="d-flex align-items-center">
                            <div class="icon-box me-3"
                                style="background: #4f46e5; color: white; padding: 12px; border-radius: 12px;">
                                <i class="fas fa-edit fa-lg"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-0 text-dark">Edit Role: {{ $role->name }}</h4>
                                <p class="text-muted mb-0 small">Update name and modify permission access</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('admin.updateRole', $role->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row mb-5">
                                <div class="col-lg-12">
                                    <label class="form-label fw-bold text-dark mb-2">Role Name</label>
                                    <div class="input-group shadow-sm"
                                        style="border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0;">
                                        <span class="input-group-text border-0 bg-white px-3"><i
                                                class="fas fa-tag text-muted"></i></span>
                                        <input type="text" name="name" value="{{ old('name', $role->name) }}"
                                            class="form-control border-0 py-3" required
                                            style="outline: none !important; box-shadow: none;">
                                    </div>
                                </div>
                            </div>

                            <div class="permissions-container bg-light p-4 rounded-4" style="border: 1px dashed #cbd5e1;">
                                <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                                    <h5 class="fw-bold text-dark mb-0"><i class="fas fa-lock me-2 text-primary"></i>Modify
                                        Permissions</h5>

                                    <div class="form-check d-flex align-items-center m-0 p-0">
                                        <input class="form-check-input" type="checkbox" id="selectAll"
                                            {{ count($permissions) == count($rolePermissions) ? 'checked' : '' }}
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
                                            <label
                                                class="permission-item p-3 border rounded-4 d-flex align-items-center h-100 mb-0 transition-all"
                                                for="perm-{{ $permission->id }}">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                    id="perm-{{ $permission->id }}"
                                                    class="permission-checkbox form-check-input me-3"
                                                    {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                                                <span class="text-dark fw-medium text-capitalize label-text"
                                                    style="font-size: 15px;">
                                                    {{ str_replace(['-', '_'], ' ', $permission->name) }}
                                                </span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mt-5 d-flex flex-column flex-md-row justify-content-end gap-3">
                                <a href="{{ route('admin.roles') }}" class="btn btn-light fw-bold px-4 py-3"
                                    style="border-radius: 12px; border: 1px solid #e2e8f0;">Cancel</a>
                                <button type="submit" class="btn btn-primary fw-bold px-5 py-3 shadow"
                                    style="background: #4f46e5 !important; border: none; border-radius: 12px;">
                                    <i class="fas fa-save me-2"></i> Update Role
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Select All functionality (এডিট মোডের জন্যও কার্যকর)
        document.getElementById('selectAll').addEventListener('change', function() {
            let checkboxes = document.querySelectorAll('.permission-checkbox');
            checkboxes.forEach(cb => {
                cb.checked = this.checked;
            });
        });

        const permissionCheckboxes = document.querySelectorAll('.permission-checkbox');
        permissionCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const selectAll = document.getElementById('selectAll');
                const allChecked = Array.from(permissionCheckboxes).every(cb => cb.checked);
                selectAll.checked = allChecked;
            });
        });
    </script>
@endsection
