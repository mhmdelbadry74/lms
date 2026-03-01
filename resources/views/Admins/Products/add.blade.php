@extends('Admins.layout.master')
@section('content')
    @include("Admins.layout.parts.alert")
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">{{ __($form_title) }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ isset($product) ? route('admin.products.updateproduct', $product->id) : route('admin.products.add') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <!-- Arabic Name -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name_ar">{{ __('Arabic Name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name_ar') is-invalid @enderror" id="name_ar"
                                name="name_ar" value="{{ old('name_ar', $product->name_ar ?? '') }}" required>
                            @error('name_ar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- English Name -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name_en">{{ __('English Name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name_en') is-invalid @enderror" id="name_en"
                                name="name_en" value="{{ old('name_en', $product->name_en ?? '') }}" required>
                            @error('name_en')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Slug Field -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="slug">{{ __('Slug') }} <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                id="slug" name="slug" 
                                value="{{ old('slug', $product->slug ?? '') }}" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="generate_slug">
                                    <i class="fa fa-magic"></i> {{ __('Generate') }}
                                </button>
                            </div>
                        </div>
                        @error('slug')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <!-- Image Upload -->
                <div class="form-group">
                    <label for="image">{{ __('Product Image') }} @if(!isset($product))<span class="text-danger">*</span>@endif</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image"
                            name="image" accept="image/*" @if(!isset($product)) required @endif>
                        <label class="custom-file-label" for="image">
                            {{ isset($product) && $product->image ? basename($product->image) : __('Choose file') }}
                        </label>
                        @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <small class="form-text text-muted">
                        {{ __('Allowed formats: jpeg, png, jpg, gif, webp. Max size: 2MB') }}
                    </small>
                    @if(isset($product) && $product->image)
                        <div class="mt-2">
                            <img src="{{ asset($product->image) }}" alt="Current product image" style="max-height: 100px;">
                        </div>
                    @endif
                </div>

                <!-- Arabic Description -->
                <!-- Arabic Description (remove required attribute) -->
                <div class="form-group">
                    <label for="description_ar">{{ __('Arabic Description') }} <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('description_ar') is-invalid @enderror rich-text-editor" 
                        id="description_ar" name="description_ar">{{ old('description_ar', $product->description_ar ?? '') }}</textarea>
                    @error('description_ar')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- English Description -->
                            <!-- Arabic Description (remove required attribute) -->
                <div class="form-group">
                    <label for="description_en">{{ __('Arabic Description') }} <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('description_en') is-invalid @enderror rich-text-editor" 
                        id="description_en" name="description_en">{{ old('description_en', $product->description_ar ?? '') }}</textarea>
                    @error('description_en')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Brand Selection -->
                <div class="form-group">
                    <label for="brand_id">{{ __('Brand') }} <span class="text-danger">*</span></label>
                    <select class="form-control @error('brand_id') is-invalid @enderror" id="brand_id" name="brand_id" required>
                        <option value="">{{ __('Select brand') }}</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" 
                                @if(old('brand_id', $product->brand_id ?? '') == $brand->id) selected @endif>
                                @if (app()->getLocale() == 'en')
                                    {{ $brand->name_en }}
                                @else
                                    {{ $brand->name_ar }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('brand_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Categories Multi-Select -->
                <div class="form-group">
                    <label for="categories">{{ __('Categories') }} <span class="text-danger">*</span></label>
                    <select name="categories[]" id="categories"
                        class="form-control @error('categories') is-invalid @enderror" multiple="multiple" required>
                        @foreach (App\Models\Category::all() as $category)
                            <option value="{{ $category->id }}" 
                                @if((isset($product) && $product->categories->contains($category->id)) || 
                                   (is_array(old('categories')) && in_array($category->id, old('categories')))) selected @endif>
                                @if(app()->getLocale() == "ar")
                                    {{ $category->name_ar }}
                                @else
                                    {{ $category->name_en }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('categories')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="form-group text-right">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> {{ __('Back') }}
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> {{ isset($product) ? __('Update') : __('Save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <!-- CKEditor CSS (loaded from CDN) -->
    <style>
        .ts-wrapper.multi .ts-control {
            min-height: 38px;
            border: 1px solid #ced4da !important;
        }
        .ts-wrapper.focus .ts-control {
            border-color: #80bdff !important;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .ts-dropdown .option:hover, .ts-dropdown .active {
            background-color: #007bff;
            color: #fff;
        }
        .ts-dropdown .create:hover, .ts-dropdown .create.active {
            background-color: #28a745;
        }
        .custom-file-label::after {
            content: "{{ __('Browse') }}";
        }
        .invalid-feedback {
            display: block;
            color: #dc3545;
        }
        .is-invalid {
            border-color: #dc3545;
        }
        /* CKEditor styling */
        .ck-editor__editable {
            min-height: 200px;
        }
    </style>

    <!-- Load jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- TomSelect JS -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <!-- CKEditor JS -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <!-- CKEditor Arabic support -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/translations/ar.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize TomSelect for brand (single select)
            new TomSelect("#brand_id", {
                plugins: ['remove_button'],
                create: false,
                maxItems: 1,
                render: {
                    option: function(data, escape) {
                        return '<div>' + escape(data.text) + '</div>';
                    },
                    item: function(data, escape) {
                        return '<div>' + escape(data.text) + '</div>';
                    }
                }
            });

            // Initialize TomSelect for categories (multi-select)
            new TomSelect("#categories", {
                plugins: ['remove_button'],
                create: false,
                maxItems: null,
                render: {
                    option: function(data, escape) {
                        return '<div>' + escape(data.text) + '</div>';
                    },
                    item: function(data, escape) {
                        return '<div>' + escape(data.text) + '</div>';
                    }
                }
            });

            // Show selected file name in file input
            $('#image').change(function(e) {
                var fileName = e.target.files[0]?.name || '{{ __("Choose file") }}';
                $(this).next('.custom-file-label').text(fileName);
            });

            // Slug generation functions
            function generateSlug(text) {
                return text.toLowerCase()
                    .replace(/[^\w\s-]/g, '') // Remove special chars
                    .replace(/[\s_-]+/g, '-')  // Replace spaces and underscores with hyphens
                    .replace(/^-+|-+$/g, '');  // Trim hyphens from start/end
            }

            // Auto-generate slug when English name changes
            $('#name_en').on('blur', function() {
                if (!$('#slug').val()) { // Only generate if slug is empty
                    const slug = generateSlug($(this).val());
                    $('#slug').val(slug);
                }
            });

            // Manual slug generation button
            $('#generate_slug').click(function() {
                const englishName = $('#name_en').val();
                if (englishName) {
                    const slug = generateSlug(englishName);
                    $('#slug').val(slug);
                } else {
                    alert('{{ __("Please enter an English name first") }}');
                }
            });

            // Initialize CKEditor for English description
            ClassicEditor
                .create(document.querySelector('#description_en'), {
                    toolbar: {
                        items: [
                            'heading', '|',
                            'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                            'outdent', 'indent', '|',
                            'blockQuote', 'insertTable', 'undo', 'redo',
                            'alignment', 'fontBackgroundColor', 'fontColor', 'fontSize', 'fontFamily',
                            'highlight', 'horizontalLine', 'htmlEmbed', 'imageInsert', 'mediaEmbed',
                            'removeFormat', 'specialCharacters', 'strikethrough', 'subscript', 'superscript',
                            'underline', 'code', 'codeBlock'
                        ]
                    },
                    language: 'en',
                    licenseKey: '',
                })
                .then(editor => {
                    window.descriptionEnEditor = editor;
                })
                .catch(error => {
                    console.error('Oops, something went wrong with English editor!');
                    console.error(error);
                });

            // Initialize CKEditor for Arabic description
            ClassicEditor
                .create(document.querySelector('#description_ar'), {
                    toolbar: {
                        items: [
                            'heading', '|',
                            'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                            'outdent', 'indent', '|',
                            'blockQuote', 'insertTable', 'undo', 'redo',
                            'alignment', 'fontBackgroundColor', 'fontColor', 'fontSize', 'fontFamily',
                            'highlight', 'horizontalLine', 'htmlEmbed', 'imageInsert', 'mediaEmbed',
                            'removeFormat', 'specialCharacters', 'strikethrough', 'subscript', 'superscript',
                            'underline', 'code', 'codeBlock'
                        ]
                    },
                    language: 'ar',
                    licenseKey: '',
                })
                .then(editor => {
                    window.descriptionArEditor = editor;
                })
                .catch(error => {
                    console.error('Oops, something went wrong with Arabic editor!');
                    console.error(error);
                });

            // Update textarea values before form submission
            // Update form submission handler
            $('form').on('submit', function(e) {
                // Update textarea values with editor content
                if (window.descriptionEnEditor) {
                    $('#description_en').val(window.descriptionEnEditor.getData());
                }
                if (window.descriptionArEditor) {
                    $('#description_ar').val(window.descriptionArEditor.getData());
                }
                
                // Custom validation
                let isValid = true;
                
                // Validate Arabic description
                const arabicContent = window.descriptionArEditor?.getData().trim();
                if (!arabicContent) {
                    isValid = false;
                    $('[for="description_ar"]').addClass('text-danger');
                    $('#description_ar').addClass('is-invalid');
                    $('#description_ar').next('.invalid-feedback').remove();
                    $('#description_ar').after('<span class="invalid-feedback" role="alert"><strong>This field is required</strong></span>');
                } else {
                    $('[for="description_ar"]').removeClass('text-danger');
                    $('#description_ar').removeClass('is-invalid');
                    $('#description_ar').next('.invalid-feedback').remove();
                }
                
                // Validate English description
                const englishContent = window.descriptionEnEditor?.getData().trim();
                if (!englishContent) {
                    isValid = false;
                    $('[for="description_en"]').addClass('text-danger');
                    $('#description_en').addClass('is-invalid');
                    $('#description_en').next('.invalid-feedback').remove();
                    $('#description_en').after('<span class="invalid-feedback" role="alert"><strong>This field is required</strong></span>');
                } else {
                    $('[for="description_en"]').removeClass('text-danger');
                    $('#description_en').removeClass('is-invalid');
                    $('#description_en').next('.invalid-feedback').remove();
                }
                
                if (!isValid) {
                    e.preventDefault();
                    // Scroll to first error
                    $('html, body').animate({
                        scrollTop: $('.is-invalid').first().offset().top - 100
                    }, 500);
                }
            });
        });
    </script>
