{{-- Button to trigger modal --}}
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#update"><i
        class="fa fa-cog"></i>
</button>

{{-- Update Modal --}}
<div id="update" class="modal fade" tabindex="-1" aria-labelledby="updateLabel" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" method="POST" action="{{ route('admin.attributes.update', $attribute->id) }}">
            @method('PATCH')
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="updateLabel">{{ __('Edit Attribute') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name_ar">{{ __('Arabic Name') }}</label>
                            <input type="text" class="form-control @error('name_ar') is-invalid @enderror" 
                                   id="name_ar" name="name_ar" value="{{ old('name_ar', $attribute->name_ar) }}" required>
                            @error('name_ar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name_en">{{ __('English Name') }}</label>
                            <input type="text" class="form-control @error('name_en') is-invalid @enderror" 
                                   id="name_en" name="name_en" value="{{ old('name_en', $attribute->name_en) }}" required>
                            @error('name_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                     <div class='col-12'>
                        <div class='form-group'>
                            <label for='categories'>{{ __('Categories') }}</label>
                            <select name="categories[]" id="categories{{ $attribute->id }}"
                                class="form-control" multiple>
                                @foreach ($categories as $category)
                                    <option value='{{ $category->id }}'@if(in_array($category->id,$attribute->categoryAttributes ()->pluck("category_id")->toArray())) selected @endif>
                                        @if (app()->getLocale() == "en")
                                            {{ $category->name_en }}
                                        @else
                                            {{ $category->name_ar }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class='col-6'>
                        <livewire:attribute-type :model='$attribute->id'/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-bs-dismiss="modal">{{ __('Close') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
            </div>
        </form>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
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
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
   document.addEventListener('DOMContentLoaded', function() {
    // Initialize TomSelect for categories
        const selectEl = document.getElementById('categories{{ $attribute->id }}');
        
        // Get currently selected category IDs
        const selectedValues = Array.from(selectEl.querySelectorAll('option[selected]'))
                                .map(option => Number(option.value));
        new TomSelect(selectEl, {
            plugins: ['remove_button'],
            create: false,
            maxItems: null,
            items: selectedValues, // Set initially selected items
            render: {
                option: function(data, escape) {
                    return '<div>' + escape(data.text) + '</div>';
                },
                item: function(data, escape) {
                    return '<div>' + escape(data.text) + '</div>';
                }
            }
        });

        // Reinitialize when modal is shown
        document.getElementById('update').addEventListener('shown.bs.modal', function() {
            const ts = selectEl.tomselect;
            if (ts) {
                ts.sync();
                // Re-set values in case modal was closed and reopened
                ts.setValue(selectedValues);
            }
        });
    });
</script>
