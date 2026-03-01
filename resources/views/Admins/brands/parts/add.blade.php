<!-- Add New Item Button -->
<button type="button" class="btn btn-success btn-icon" data-bs-toggle="modal" data-bs-target="#addModal">
  <i class="fa fa-plus me-1"></i> 
</button>

<!-- Enhanced Modal -->
<div id="addModal" class="modal fade" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content border-0 shadow">
          <!-- Modal Header -->
          <div class="modal-header bg-success text-white">
              <h5 class="modal-title" id="addModalLabel">
                  <i class="fa fa-plus-circle me-2"></i> {{__("add brand")}}
              </h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          
          <!-- Modal Body -->
          <div class="modal-body">
              <form id="addForm" action="{{ route('admin.brand.store') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  
                  <!-- Name Section -->
                  <div class="row mb-3">
                      <div class="col-md-6">
                          <label for="name_ar" class="form-label">{{__("Arabic Name")}} <span class="text-danger">*</span></label>
                          <div class="input-group">
                              <span class="input-group-text bg-light"><i class="fa fa-font text-success"></i></span>
                              <input type="text" id="name_ar" name="name_ar" class="form-control" value="{{ old('name_ar') }}" required>
                              @error('name_ar')
                              <div class="invalid-feedback">
                                  {{ $message }}
                              </div>
                              @enderror
                          </div>
                      </div>
                      <div class="col-md-6">
                          <label for="name_en" class="form-label">{{__("English Name")}} <span class="text-danger">*</span></label>
                          <div class="input-group">
                              <span class="input-group-text bg-light"><i class="fa fa-font text-success"></i></span>
                              <input type="text" id="name_en" name="name_en" class="form-control" value="{{ old('name_en') }}" required>
                              @error('name_en')
                              <div class="invalid-feedback">
                                  {{ $message }}
                              </div>
                              @enderror
                          </div>
                      </div>
                  </div>
                  
                 
                  <!-- Description -->
                
                  <div class='mb-3'>
                    <label for="description_en">{{__("description (english)")}}</label>
                    <textarea class='form-control'id="description_en"name='description_en'>{{ old('description_en') }}</textarea>
                    @error('description_en')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                  </div>
                  <div class='mb-3'>
                    <label for="description_ar">{{__("description (arabic)")}}</label>
                    <textarea class='form-control'id="description_ar"name='description_ar'>{{ old('description_ar') }}</textarea>
                    @error('description_ar')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                  </div>
                  <!-- Status & Special -->
                  <div class="row mb-3">
                      <div class="col-md-4">
                          <div class="form-check">
                              <input type="checkbox" id="status" name="is_active" class="form-check-input" value="1" {{ old('is_active') ? 'checked' : '' }}>
                              <label for="status" class="form-check-label">{{__("Active")}}</label>
                          </div>
                      </div>
                      
                      <div class="col-md-4">
                          <div class="form-check">
                              <input type="checkbox" id="is_featured" name="is_featured" class="form-check-input" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                              <label for="is_featured" class="form-check-label">{{__("Featured")}}</label>
                          </div>
                      </div>
                  </div>
                  
                  <!-- Image Upload -->
                  <div class="mb-3">
                      <label for="image" class="form-label">{{__("Image")}} <span class="text-danger">*</span></label>
                      <div class="input-group">
                          <input type="file" id="image" name="image" class="form-control" accept="image/*" required>
                          <button class="btn btn-outline-secondary" type="button" id="clearImage">
                              <i class="fa fa-times"></i> {{__("Clear")}}
                          </button>
                      </div>
                      <div class="form-text">{{__("Allowed formats: JPG, PNG, GIF. Max size: 2MB")}}</div>
                      <div class="preview-container mt-2 d-none">
                          <img id="imagePreview" src="#" alt="{{__("Image preview")}}" class="img-thumbnail" style="max-height: 150px;">
                      </div>
                  </div>
                   <button type="submit" form="addForm" class="btn btn-success">
                      <i class="fa fa-save me-1"></i> {{__("Save")}}
                   </button>
              </form>
          </div>
          
          <!-- Modal Footer -->
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                  <i class="fa fa-times me-1"></i> {{__("Cancel")}}
              </button>
             
          </div>
      </div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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
        
        // Slug generation was canceled
        // $('#generateSlug').click(function() {
        //     alert();
        //     const enName = $('#name_en').val();
        //     if (enName) {
        //         const slug = enName.toLowerCase()
        //             .replace(/[^\w\s-]/g, '')
        //             .replace(/[\s_-]+/g, '-')
        //             .replace(/^-+|-+$/g, '');
        //         $('#slug').val(slug);
        //     }
        // });
        
        // Auto-generate slug when English name changes
        $('#name_en').on('blur', function() {
            if (!$('#slug').val()) {
                $('#generateSlug').click();
            }
        });

      
        
        function showError(message) {
            Toastify({
                text: message,
                duration: 5000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#dc3545",
            }).showToast();
        }
        
        // Clear validation errors when modal is closed
        $('#addModal').on('hidden.bs.modal', function() {
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
            $('#addForm')[0].reset();
            $('.preview-container').addClass('d-none');
        });
    });
</script>

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
  
  /* Responsive adjustments */
  @media (max-width: 768px) {
      .row > div {
          margin-bottom: 1rem;
      }
  }
</style>