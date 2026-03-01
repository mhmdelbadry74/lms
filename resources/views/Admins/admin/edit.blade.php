@extends('Admins.layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="card col-12">
                <div clas="card-header">
                    <h3>{{ __($form_title) }}</h3>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="row" enctype="multipart/form-data"method="POST" action="{{ isset($admin)?route('admin.index.update',$admin->id):route('admin.index.add') }}">
                        @csrf
                        <div class="form-group col-6">
                            <label for="name"class="input-group-addon">{{ __('Name') }}</label>
                            <input type="text"name="name"value="{{ isset($admin)?$admin->name:"" }}" class="form-control"id="name">
                        </div>
                        <div class="form-group col-6">
                            <label for="email"class="input-group-addon">{{ __('Email') }}</label>
                            <input type="text"name="email" value="{{ isset($admin)?$admin->email:"" }}"class="form-control"id="email">
                        </div>
                        <div class="form-group col-6">
                            @if (isset($admin))
                                <div class="text-warning">{{ __("let password field empty if you want to keep the current password") }}</div>
                            @endif
                            <label for="password"class="input-group-addon">{{ __('Password') }}</label>
                            <input type="password"name="password" class="form-control"id="password">
                        </div>
                        <div class="form-group col-6">
                            @if (isset($admin))
                                <div class="text-warning">{{ __("let password field empty if you want to keep the current password") }}</div>
                            @endif
                            <label for="confirm_password"class="input-group-addon">{{ __('Password Confirmation') }}</label>
                            <input type="password"name="confirm_password" class="form-control"id="confirm_password">
                        </div>
                        <div class="form-group col-6">
                            <label for="role_name"class="input-group-addon">{{ __('Role') }}</label>
                            <select name="role_name"class="form-control" id="role_name">
                                @foreach (\Spatie\Permission\Models\Role::get() as $role)
                                    <option value="{{ $role->name }}" @if (isset($admin)&&$admin->hasRole($role->name))
                                        selected
                                    @endif>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <div class="mb-3">
                                <label for="imageInput" class="form-label">{{ __('Personal image') }}</label>
                                <input class="form-control" type="file" id="imageInput"
                                    accept="image/png, image/jpeg, image/jpg, image/gif"name="personal_img" >
                                <div class="invalid-feedback">(PNG, JPG, JPEG, or GIF).</div>
                                <div class="valid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <img id="imagePreview" src="@if (isset($admin))
                                    {{ $admin->personal_img }}
                                     @else
                                     
                                @endif" alt="Preview" class="preview-image img-thumbnail">
                            </div>

                            <button type="submit" class="btn btn-primary">{{ __('Choose') }}</button>
                        </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        document.getElementById('imageInput').addEventListener('change', function(e) {
            const fileInput = e.target;
            const file = fileInput.files[0];
            const preview = document.getElementById('imagePreview');
            const validFeedback = fileInput.nextElementSibling.nextElementSibling;
            const invalidFeedback = fileInput.nextElementSibling;

            // Reset classes
            fileInput.classList.remove('is-valid', 'is-invalid');

            if (file) {
                // Check if the file is an image
                if (file.type.match('image.*')) {
                    // Show preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    }
                    reader.readAsDataURL(file);

                    // Show validation
                    fileInput.classList.add('is-valid');
                    validFeedback.style.display = 'block';
                    invalidFeedback.style.display = 'none';
                } else {
                    // Invalid file type
                    preview.style.display = 'none';
                    fileInput.classList.add('is-invalid');
                    validFeedback.style.display = 'none';
                    invalidFeedback.style.display = 'block';
                }
            } else {
                preview.style.display = 'none';
            }
        });

        document.getElementById('imageUploadForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Form would submit now with valid image (in a real application)');
        });
    </script>
@endsection
