<!-- Add New Item Button -->
<button type="button" class="btn btn-primary btn-icon" data-bs-toggle="modal"
    data-bs-target="#updateBrand_{{ $brand->id }}">
    <i class="fa fa-edit me-1"></i>
</button>

<!-- Enhanced Modal -->
<div id="updateBrand_{{ $brand->id }}" class="modal fade" tabindex="-1" aria-labelledby="addModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <!-- Modal Header -->
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="addModalLabel">
                    <i class="fa fa-plus-circle me-2"></i> {{ __('Update Brand') }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form action="{{ route('admin.brand.updateBrand',$brand->id) }}"method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <!-- Name Section -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name_ar" class="form-label">{{ __('Arabic Name') }} <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fa fa-font text-success"></i></span>
                                <input type="text" id="name_ar" name="name_ar"value="{{ old('name_ar', $brand->name_ar) }}" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="name_en" class="form-label">{{ __('English Name') }} <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fa fa-font text-success"></i></span>
                                <input type="text" id="name_en" name="name_en"value="{{ old('name_en', $brand->name_en) }}" class="form-control" required>
                            </div>
                        </div>
                        <div class='col-md-12'>
                            <label for='description_ar'>{{__("description (arabic)")}}</label>
                            <textarea class='form-control'name="description_ar">{{ old('description_ar', $brand->description_ar) }}</textarea>
                        </div>
                        <div class='col-md-12'>
                            <label for='description_en'>{{__("description (english)")}}</label>
                            <textarea class='form-control'name="description_en">{{ old('description_en', $brand->description_en) }}</textarea>
                        </div>
                    </div>

                   <!-- Status & Special -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input type="checkbox" id="status" name="is_active" class="form-check-input" value="1" {{ old('is_active', $brand->is_active) ? 'checked' : '' }}>
                                <label for="status" class="form-check-label">{{__("Active")}}</label>
                            </div>
                        </div>
                    
                        <div class="col-md-4">
                            <div class="form-check">
                                <input type="checkbox" id="is_featured" name="is_featured" class="form-check-input" value="1" {{ old('is_featured', $brand->is_featured) ? 'checked' : '' }}>
                                <label for="is_featured" class="form-check-label">{{__("Featured")}}</label>
                            </div>
                        </div>
                    </div>
                    <!-- Image Upload -->
                    <img id="imagePreview" src="{{ asset($brand->image) }}" alt="{{ __('Image preview') }}" class="img-thumbnail"
                    style="max-height: 150px;">
                    <div class="mb-3">
                        <label for="image" class="form-label">{{ __('Image') }} <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="file" id="image" name="image" class="form-control" accept="image/*"
                                z>
                            <button class="btn btn-outline-secondary" type="button" id="clearImage">
                                <i class="fa fa-times"></i> {{ __('Clear') }}
                            </button>
                        </div>
                        <div class="form-text">{{ __('Allowed formats: JPG, PNG, GIF. Max size: 2MB') }}</div>
                        <div class="preview-container mt-2 d-none">
                           
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fa fa-times me-1"></i> {{ __('Cancel') }}
                        </button>
                        <button type="submit"  class="btn btn-success">
                            <i class="fa fa-save me-1"></i> {{ __('Save') }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            // Image preview functionality
            $('#image').change(function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreview').attr('src', e.target.result);
                        $('.preview-container').removeClass('d-none');
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Clear image selection
            $('#clearImage').click(function() {
                $('#image').val('');
                $('.preview-container').addClass('d-none');
            });

            // Form submission handling
            
            // // Form submission handling
            // cancled 
            // $('#addForm').submit(function(e) {
            //     e.preventDefault();
            //     // Add your form submission logic here
            //     alert('Form would be submitted here');
            //     $('#addModal').modal('hide');
            // });
        });
    </script>
@endpush

<style>
    .modal-content {
        border-radius: 0.5rem;
    }

    .modal-header {
        border-radius: 0.5rem 0.5rem 0 0;
    }

    .form-label {
        font-weight: 500;
    }

    .input-group-text {
        min-width: 40px;
        justify-content: center;
    }

    #imagePreview {
        display: block;
        max-width: 100%;
        height: auto;
    }
</style>
