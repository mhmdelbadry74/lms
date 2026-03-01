@extends('Admins.layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('features') }}</h4>
                        @include("Admins.layout.parts.alert")

                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#myModal"><span
                                class="fa fa-plus"></span></button>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('Id') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('English Name') }}</th>
                                    {{-- removed but kept<th>{{ __('Field Type') }}</th> --}}
                                    {{-- <th>{{ __("Field's Values") }}</th> --}}
                                    <th>{{ __('actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($features as $feature)
                                    <tr>
                                        <td>{{ $feature->id }}</td>
                                        <td>{{ $feature->name_ar }}</td>
                                        <td>{{ $feature->name_en }}</td>
                                        {{-- <td>{{ __($feature->field_type) }}</td> --}}
                                        {{-- removed but kept <td>
                                            @if ($feature->field_type == App\Enums\FeatureFieldTypeEnum::CHOICES->value)
                                                <table>
                                                    <thead>
                                                        <td>
                                                            {{ __('English') }}
                                                        </td>
                                                        <td>{{ __('Arabic') }}</td>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($feature->values as $value)
                                                            <tr>
                                                                <td>
                                                                    {{ $value['en'] }}
                                                                </td>
                                                                <td>
                                                                    {{ $value['ar'] }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                        </td> --}}
                                        <td class="row">
                                            <div class="col-6">
                                                <form method="get"
                                                    action="{{ route('admin.features.delete', $feature->id) }}">
                                                    <button class="btn btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="col-6">
                                                <button type="button" class="btn btn-primary " data-bs-toggle="modal"
                                                    data-bs-target="#editfeature{{ $feature->id }}">{{ __('edit feature') }}</button>

                                                <div id="editfeature{{ $feature->id }}" class="modal fade" tabindex="-1"
                                                    aria-labelledby="myModalLabel" aria-hidden="true"
                                                    style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="myModalLabel">
                                                                    {{ __('edit feature') }}</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"> </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="row" method="get"
                                                                    action="{{ route('admin.features.edit', $feature->id) }}">
                                                                    @csrf
                                                                    @method('patch')
                                                                    <!-- Arabic Name Field -->
                                                                    <div class="form-group col-6">
                                                                        <label for="arabicName"
                                                                            class="form-label">{{ __('Arabic Name') }}</label>
                                                                        <input
                                                                            class="form-control @error('name_ar') is-invalid @enderror"
                                                                            name="name_ar" type="text" id="arabicName"
                                                                            value="{{ $feature->name_ar }}">
                                                                        @error('name_ar')
                                                                            <div class="invalid-feedback">{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>

                                                                    <!-- English Name Field -->
                                                                    <div class="form-group col-6">
                                                                        <label for="englishName"
                                                                            class="form-label">{{ __('English Name') }}</label>
                                                                        <input
                                                                            class="form-control @error('name_en') is-invalid @enderror"
                                                                            type="text" name="name_en" id="englishName"
                                                                            value="{{ $feature->name_en }}">
                                                                        @error('name_en')
                                                                            <div class="invalid-feedback">{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>

                                                                    <!-- Field Type Select -->
                                                                    {{-- <div class="form-group col-6">
                                                                        <label for="field_type"
                                                                            class="form-label">{{ __('field type') }}</label>
                                                                            <select name="field_type" class="form-control field-type-select @error('field_type') is-invalid @enderror">

                                                                            @foreach (App\Enums\FeatureFieldTypeEnum::cases() as $fieldType)
                                                                                <option value="{{ $fieldType->value }}"
                                                                                    {{ old('field_type') == $fieldType->value ? 'selected' : '' }}>
                                                                                    {{ $fieldType->label() }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('field_type')
                                                                            <div class="invalid-feedback">{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>  --}}
{{-- 
                                                                  <!-- Dynamic Values Section --> removed but kept
                                                                    <div class="form-group row col-12 choices_values"
                                                                        id="choices_values">
                                                                        <div class="col-12">
                                                                            @if ($feature->field_type==App\Enums\FeatureFieldTypeEnum::CHOICES)
                                                                            <button type='button' class="btn btn-info"
                                                                            onclick="appendValues()">
                                                                            <i class="fa fa-plus"></i>
                                                                        </button>
                                                                            @endif
                                                                            
                                                                        </div>

                                                                        <!-- Display existing errors for feature values -->
                                                                        @error('feature_value')
                                                                            <div class="col-12">
                                                                                <div class="alert alert-danger">
                                                                                    {{ $message }}</div>
                                                                            </div>
                                                                        @enderror

                                                                        <!-- Display errors for initial inputs -->
                                                                        <div class="col-12">
                                                                            @error('feature_value.0.en')
                                                                                <div class="text-danger small">
                                                                                    {{ $message }}</div>
                                                                            @enderror
                                                                            @error('feature_value.0.ar')
                                                                                <div class="text-danger small">
                                                                                    {{ $message }}</div>
                                                                            @enderror
                                                                        </div>

                                                                        <!-- Dynamically added inputs will be placed here -->
                                                                    </div>  --}}

                                                                    <!-- Submit Button -->
                                                                    <div class="mt-3">
                                                                        <button type="submit"
                                                                            class="btn btn-primary">{{ __('Save') }}</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">

                                                            </div>

                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">{{ __('No features found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Default Modals -->

        <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">{{ __('adding Feature') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                    </div>
                    <div class="modal-body">

                        <form class="row" method="POST" action="{{ route('admin.features.store') }}">
                            @csrf

                            <!-- Arabic Name Field -->
                            <div class="form-group col-6">
                                <label for="arabicName" class="form-label">{{ __('Arabic Name') }}</label>
                                <input class="form-control @error('name_ar') is-invalid @enderror" name="name_ar"
                                    type="text" id="arabicName" value="{{ old('name_ar') }}">
                                @error('name_ar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- English Name Field -->
                            <div class="form-group col-6">
                                <label for="englishName" class="form-label">{{ __('English Name') }}</label>
                                <input class="form-control @error('name_en') is-invalid @enderror" type="text"
                                    name="name_en" id="englishName" value="{{ old('name_en') }}">
                                @error('name_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- <!-- Field Type Select --> removed but kept
                            <div class="form-group col-6">
                                <label for="field_type" class="form-label">{{ __('field type') }}</label>
                                <select name="field_type" class="form-control field-type-select @error('field_type') is-invalid @enderror">

                                    @foreach (App\Enums\FeatureFieldTypeEnum::cases() as $fieldType)
                                        <option value="{{ $fieldType->value }}"
                                            {{ old('field_type') == $fieldType->value ? 'selected' : '' }}>
                                            {{ $fieldType->label() }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('field_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Dynamic Values Section -->
                            <div class="form-group row col-12 choices_values" id="choices_values">
                                <div class="col-12">
                                    <button type='button' class="btn btn-info" onclick="appendValues()">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>

                                <!-- Display existing errors for feature values -->
                                @error('feature_value')
                                    <div class="col-12">
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    </div>
                                @enderror

                                <!-- Initial value inputs -->
                                <div class="col-12 input-group mt-2">
                                    <input class='form-control @error('feature_value.0.en') is-invalid @enderror'
                                        type="text" name="feature_value[0][en]"
                                        placeholder="{{ __('English Value') }}" value="{{ old('feature_value.0.en') }}">
                                    <input class='form-control @error('feature_value.0.ar') is-invalid @enderror'
                                        type="text" name="feature_value[0][ar]"
                                        placeholder="{{ __('Arabic Value') }}" value="{{ old('feature_value.0.ar') }}">
                                </div>

                                <!-- Display errors for initial inputs -->
                                <div class="col-12">
                                    @error('feature_value.0.en')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                    @error('feature_value.0.ar')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Dynamically added inputs will be placed here -->
                            </div> --}}

                            <!-- Submit Button -->
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        // let index = 0;
        // $(document).on('change', '.field-type-select', function() {
        //     // Find the closest modal and look for the choices_values within it
        //     const modal = $(this).closest('.modal-content');
        //     const choicesSection = modal.find('.choices_values');
        //     if (this.value === 'choices') {
        //         choicesSection.fadeIn();
        //     } else {
        //         choicesSection.fadeOut();
        //     }
        // });

        // // Initialize visibility on page load and modal show
        // $(document).ready(function() {
        //     // For the create modal
        //     const createFieldType = $('#myModal #field_type');
        //     if (createFieldType.val() === 'choices') {
        //         $('#myModal .choices_values').fadeIn();
        //     } else {
        //         $('#myModal .choices_values').fadeOut();
        //     }
        // });

        // // For edit modals when they're shown
        // $(document).on('show.bs.modal', '.modal', function() {
        //     const fieldType = $(this).find('.field-type-select');
        //     const choicesSection = $(this).find('.choices_values');
        //     if (fieldType.val() === 'choices') {
        //         choicesSection.fadeIn();
        //     } else {
        //         choicesSection.fadeOut();
        //     }
        // });
        // let englishPlaceholder="{{ __('English Value')  }}";
        // let arabicPlaceholder="{{ __('Arabic Value') }}";
        // function appendValues() {
        //     index += 1;
        //     $(".choices_values").append(`
        //         <div class='col-12 input-group mt-2'>
        //             <input class='form-control' type='text' name='feature_value[${index}][en]' placeholder='${englishPlaceholder}'>
        //             <input class='form-control' type='text' name='feature_value[${index}][ar]' placeholder='${arabicPlaceholder}'>
        //         </div>
        //     `);
        // }
    </script>
@endsection
