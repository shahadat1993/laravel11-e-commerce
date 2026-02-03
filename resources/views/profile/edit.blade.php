@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <h3>Profile Settings</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Profile Image --}}
            <div class="mb-3">
                <img src="{{ $user->profile_photo_path ? asset('storage/'.$user->profile_photo_path) : asset('images/placeholder.png') }}" alt="Profile" style="width:120px;height:120px;object-fit:cover;border-radius:50%;">
                <input type="file" name="profile_photo" class="form-control mt-2">
            </div>

            {{-- Name --}}
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
            </div>

            {{-- Mobile --}}
            <div class="mb-3">
                <label>Mobile</label>
                <input type="text" name="mobile" value="{{ old('mobile', $user->mobile) }}" class="form-control" required>
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
            </div>

            {{-- Password --}}
            <h5>Password Change</h5>
            <div class="mb-3">
                <label>Old Password</label>
                <input type="password" name="old_password" class="form-control">
            </div>
            <div class="mb-3">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control">
            </div>
            <div class="mb-3">
                <label>Confirm New Password</label>
                <input type="password" name="new_password_confirmation" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Save Changes</button>
        </form>
    </div>
</div>
@endsection
