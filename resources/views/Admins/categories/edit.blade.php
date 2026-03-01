@extends('Admins.layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="card col-12">
                <div class="card-header">
                    <h3>
                        {{ __($form_title) }}
                    </h3>
                </div>

            </div>
            <div class="card col-12">
                <div class="card-header">

                    <!-- Display general form errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger mt-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <form class="row"method="POST" action={{ isset($category) ? route("admin.categories.Update",$category->id) : route('admin.categories.add') }} enctype="multipart/form-data">
                        @csrf
                        <!-- Category Name -->
                        <div class="mb-3 col-6">
                            <label for="categoryName" class="form-label">{{ __('Name') }}</label>
                            <input type="text"name="name_ar" value="{{ old('name_ar', $category?->name_ar ?? '') }}"
                                class="form-control" id="categoryName" required>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="categoryName" class="form-label">{{ __('English Name') }}</label>
                            <input type="text" class="form-control"name="name_en"
                                value="{{ old('name_en', $category?->name_en ?? '') }}"id="categoryName" required>
                        </div>
                        <!-- Size Selection -->
                        <div class="mb-3 col-6">
                            <label for="categoryParent" class="form-label">{{ __('Parent Category') }}</label>
                            <select class="form-select"name="parent_category_id" id="categoryParent">
                                <option value="">{{ __('Select Category') }}</option>
                                @foreach ($categories as $category_object)
                                @if (app()->getLocale()=="ar")
                                    <option
                                    value="{{ $category_object->id }}"@if (old('parent_category_id', $category?->parent_category_id ?? null) == $category_object->id) selected @endif>
                                    {{ $category_object->name_ar }}</option>
                                @else
                                    <option
                                    value="{{ $category_object->id }}"@if (old('parent_category_id', $category?->parent_category_id ?? null) == $category_object->id) selected @endif>
                                    {{ $category_object->name_en }}</option>
                                @endif
                                    
                                @endforeach
                            </select>
                        </div>
                
                        <div class="mb-3 col-12">
                            <label for="description_ar" class="form-label">{{ __('Description (Arabic)') }}</label>
                            <textarea class="form-control" id="description_ar" name="description_ar" rows="2">{{ old('description_ar', $category?->description_ar ?? '') }}</textarea>
                        </div>
                        <div class="mb-3 col-12">
                            <label for="description_ar" class="form-label">{{ __('description (english)') }}</label>
                            <textarea class="form-control" id="description_ar" name="description_en" rows="2">{{ old('description_en', $category?->description_en ?? '') }}</textarea>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="image" class="form-label">{{ __('Image') }}</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            @if(isset($category) && $category->image)
                                <div class="mt-2">
                                    <small>Current Image:</small>
                                    <img src="{{ asset($category->image) }}" alt="Category image" class="img-thumbnail" width="100">
                                </div>
                            @endif
                        </div>
                        <div class="mb-3 col-3 d-flex align-items-center">
                            <div class="form-check me-3">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', isset($category) ? $category->is_active : 1) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    {{ __('Is Active') }}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', isset($category) ? $category->is_featured : 1) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    {{ __('Is Featured') }}
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">@if(isset($category)){{ __("update") }}@else{{ __('create') }}@endif</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- Move jQuery loading to the head or before your scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function() {

        // Your existing delete button handler
        $('.delete-btn').click(function() {
            const form = $(this).closest('form');
            const adminName = $(this).data('name');

            $('#admin-name').text(adminName);
            $('#deleteModal').modal('show');

            $('#confirm-delete').off('click').on('click', function() {
                form.submit();
            });
        });
    });
</script>
