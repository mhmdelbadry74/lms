{{-- resources/views/Admins/collections/create.blade.php --}}
@extends('Admins.layout.master')
@section('content')
    <div class="container-fluid">
        <div class="content-wrapper">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title mb-0">{{ __($form_title) }}</h3>
                                <a href="{{ route('admin.collection.index') }}" class="btn btn-light btn-sm">
                                    <i class="fa fa-arrow-left mr-1"></i> {{ __('Back') }}
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ isset($collection)?route('admin.collection.update',$collection->id):route('admin.collection.store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="row">
                                    <!-- English Section -->
                                    <div class="col-md-6 border-right">
                                        <h5 class="text-center mb-4 text-primary">{{ __('English Information') }}</h5>
                                        
                                        <div class="form-group">
                                            <label for="name_en">{{ __('Name (English)') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="name_en" id="name_en"
                                                class="form-control @error('name_en') is-invalid @enderror"
                                                value="{{ old('name_en', isset($collection) ? $collection->name_en : '') }}" required>
                                            @error('name_en')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="description_en">{{ __('Description (English)') }}</label>
                                            <textarea name="description_en" id="description_en" rows="3"
                                                class="form-control @error('description_en') is-invalid @enderror">{{ old('description_en', isset($collection) ? $collection->description_en : '') }}</textarea>
                                            @error('description_en')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Arabic Section -->
                                    <div class="col-md-6">
                                        <h5 class="text-center mb-4 text-primary">{{ __('Arabic Information') }}</h5>

                                        <div class="form-group">
                                            <label for="name_ar">{{ __('Name (Arabic)') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="name_ar" id="name_ar"
                                                class="form-control text-right @error('name_ar') is-invalid @enderror"
                                                value="{{ old('name_ar', isset($collection) ? $collection->name_ar : '') }}" required dir="rtl">
                                            @error('name_ar')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="description_ar">{{ __('Description (Arabic)') }}</label>
                                            <textarea name="description_ar" id="description_ar" rows="3"
                                                class="form-control text-right @error('description_ar') is-invalid @enderror" dir="rtl">{{ old('description_ar', isset($collection) ? $collection->description_ar : '') }}</textarea>
                                            @error('description_ar')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Fields -->
                                <div class="row mt-3">
                                   
                                </div>

                                <!-- Rest of your form remains the same -->
                                <!-- Status Toggles -->
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" name="is_active" class="custom-control-input"
                                                    id="is_active" value="1" {{ old('is_active', isset($collection) ? $collection->is_active : false) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="is_active">{{ __('Active Collection') }}</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" name="is_featured" class="custom-control-input"
                                                    id="is_featured" value="1" @if(isset($collection) && $collection->is_featured) checked @endif>
                                                <label class="custom-control-label" for="is_featured">{{ __('Featured Collection') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Image Upload -->
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="image">{{ __('Collection Image') }}</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="image" name="image">
                                                <label class="custom-file-label" for="image">{{ __('Choose file') }}</label>
                                            </div>
                                            @if(isset($collection) && $collection->image)
                                                <div class="mt-2">
                                                    <img src="{{ asset('storage/' . $collection->image) }}" alt="Collection Image" style="max-height: 100px;">
                                                </div>
                                            @endif
                                            @error('image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fa fa-save mr-1"></i> {{ isset($collection) ? __('Update Collection') : __('Save Collection') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Debugging - check if elements exist
        console.log('name_en element:', document.getElementById('name_en'));
        console.log('slug element:', document.getElementById('slug'));
        console.log('generate-slug button:', document.getElementById('generate-slug'));

        // Update file input label
        document.querySelectorAll('.custom-file-input').forEach(function(input) {
            input.addEventListener('change', function(e) {
                var fileName = e.target.files[0] ? e.target.files[0].name : '{{ __('Choose file') }}';
                var label = e.target.nextElementSibling;
                label.textContent = fileName;
            });
        });

        // Slug generation function
        function generateSlug(text) {
            if (!text) return '';
            return text.toString().toLowerCase()
                .replace(/\s+/g, '-')           // Replace spaces with -
                .replace(/[^\w\-]+/g, '')       // Remove all non-word chars except -
                .replace(/\-\-+/g, '-')         // Replace multiple - with single -
                .replace(/^-+/, '')             // Trim - from start of text
                .replace(/-+$/, '');            // Trim - from end of text
        }

        // Initialize auto-generated state if not set
        const slugInput = document.getElementById('slug');
        if (!slugInput.dataset.autoGenerated) {
            slugInput.dataset.autoGenerated = 'true';
        }

        // Auto-generate slug from English name when input changes
        document.getElementById('name_en').addEventListener('input', function() {
            const slugInput = document.getElementById('slug');
            console.log('name_en input event:', this.value);
            
            // Only auto-generate if slug is empty or matches the previous auto-generated value
            if (!slugInput.value || slugInput.dataset.autoGenerated === 'true') {
                const generatedSlug = generateSlug(this.value);
                console.log('Generating slug:', generatedSlug);
                slugInput.value = generatedSlug;
                slugInput.dataset.autoGenerated = 'true';
                document.getElementById('slug-generator').classList.remove('d-none');
            }
        });

        // Manual slug generation button
        document.getElementById('generate-slug').addEventListener('click', function() {
            const nameInput = document.getElementById('name_en');
            const slugInput = document.getElementById('slug');
            console.log('Generate button clicked');
            
            if (nameInput.value) {
                const generatedSlug = generateSlug(nameInput.value);
                console.log('Generated slug:', generatedSlug);
                slugInput.value = generatedSlug;
                slugInput.dataset.autoGenerated = 'true';
                document.getElementById('slug-generator').classList.remove('d-none');
            }
        });

        // Allow manual editing of slug without auto-overwriting
        document.getElementById('slug').addEventListener('input', function() {
            console.log('slug manually edited');
            this.dataset.autoGenerated = 'false';
        });

        // Also generate slug when the English name field loses focus (if empty)
        document.getElementById('name_en').addEventListener('blur', function() {
            const slugInput = document.getElementById('slug');
            console.log('name_en blur event');
            
            if (this.value && (!slugInput.value || slugInput.dataset.autoGenerated === 'true')) {
                const generatedSlug = generateSlug(this.value);
                console.log('Generated slug on blur:', generatedSlug);
                slugInput.value = generatedSlug;
                slugInput.dataset.autoGenerated = 'true';
                document.getElementById('slug-generator').classList.remove('d-none');
            }
        });
    });
</script>