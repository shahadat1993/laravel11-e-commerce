@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Slide</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="{{ route('admin.slide.index') }}">
                            <div class="text-tiny">Slides</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">New Slide</div>
                    </li>
                </ul>
            </div>
            <!-- new-category -->
            <div class="wg-box">
                <form class="form-new-product form-style-1" action="{{ route('admin.slide.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <fieldset class="name">
                        <div class="body-title">Tagline <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Tagline" name="tagline" tabindex="0"
                            value="{{ old('tagline') }}" aria-required="true" required="">
                        @error('tagline')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </fieldset>

                    <fieldset class="name">
                        <div class="body-title">Title<span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Title" name="title" tabindex="0"
                            value="{{ old('title') }}" aria-required="true" required="">
                        @error('title')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </fieldset>

                    <fieldset class="name">
                        <div class="body-title">Subtitle<span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="SubTitle" name="subtitle" tabindex="0"
                            value="{{ old('subtitle') }}" aria-required="true" required="">
                        @error('subtitle')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </fieldset>

                    <fieldset class="name">
                        <div class="body-title">Link<span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Link" name="link" tabindex="0"
                            value="{{ old('link') }}" aria-required="true" required="">
                        @error('link')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </fieldset>

                    <fieldset>
                        <div class="body-title">Upload images <span class="tf-color-1">*</span></div>
                        <div class="upload-image flex-grow">
                            <div class="item up-load">
                                <label class="uploadfile" for="myFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">Drop your images here or <span class="tf-color">click to
                                            browse</span></span>

                                    <!-- File input with preview trigger -->
                                    <input type="file" id="myFile" name="image" onchange="previewImage(event)">
                                    @error('image')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </label>
                            </div>
                        </div>

                        <!-- Image preview -->
                        <div class="mt-3">
                            <img id="preview" src="" style="max-width: 220px; display:none; border-radius:10px;">
                        </div>

                    </fieldset>


                    <fieldset class="category">
                        <div class="body-title">Select category icon</div>
                        <div class="select flex-grow">
                            <select class="" name="status">
                                <option value="" disabled>---Select status---</option>
                                <option value="1" @if (old('status') == '1') selected @endif>Active</option>
                                <option value="0" @if (old('status') == '0') selected @endif>Inactive</option>
                            </select>
                            @error('status')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </fieldset>

                    <div class="bot">
                        <div></div>
                        <button class="tf-button w208" type="submit">Save</button>
                    </div>
                </form>
            </div>
            <!-- /new-category -->
        </div>
        <!-- /main-content-wrap -->
    </div>
@endsection
@push('scripts')
    <script>
        function previewImage(event) {
            const output = document.getElementById('preview');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.style.display = "block";
            output.onload = function() {
                URL.revokeObjectURL(output.src); // free memory
            }
        }
    </script>
@endpush
