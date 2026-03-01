<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('features') }}</h3>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <td>{{ __('Name') }}</td>
                    <td>{{ __('Value') }}</td>
                </thead>
                <tbody>
                    @foreach ($product->featurePivot as $feature)
                        <tr id="feature_row_{{ $feature->id }}">
                            @if (app()->getLocale() == 'ar')
                                <td>
                                    {{ $feature->feature->name_ar }}
                                </td>
                                <td>
                                    @if ($feature->feature->field_type == App\Enums\FeatureFieldTypeEnum::TEXT->value)
                                        <input type="text"class="form-control" value="{{ $feature->current_value }}"
                                            disabled>
                                    @elseif($feature->feature->field_type == App\Enums\FeatureFieldTypeEnum::NUMBER->value)
                                        <input type="number"class="form-control" value="{{ $feature->current_value }}"
                                            disabled>
                                    @elseif($feature->feature->field_type == App\Enums\FeatureFieldTypeEnum::COLOR->value)
                                        <input type="color"class="form-control" value="{{ $feature->curent_value }}"
                                            disabled>
                                    @elseif ($feature->feature->field_type == App\Enums\FeatureFieldTypeEnum::CHOICES->value)
                                        @php
                                            $currentValue = json_decode($feature->current_value, true);
                                            $displayValue =
                                                app()->getLocale() == 'ar'
                                                    ? $currentValue['ar'] ?? ''
                                                    : $currentValue['en'] ?? '';
                                        @endphp
                                        <input type="text" class="form-control" value="{{ $displayValue }}" disabled>
                                    @endif
                                </td>
                                <td>
                                    <button
                                        class="btn btn-danger"onclick="deleteFeature({{ $feature->id }},'#feature_row_{{ $feature->id }}')"><i
                                            class="fa fa-trash"></i></button>
                                </td>
                            @else
                                <td>
                                    {{ $feature->feature->name_en }}
                                </td>
                                <td>
                                    @if ($feature->feature->field_type == App\Enums\FeatureFieldTypeEnum::TEXT->value)
                                        <input type="text"class="form-control" value="{{ $feature->current_value }}"
                                            disabled>
                                    @elseif($feature->feature->field_type == App\Enums\FeatureFieldTypeEnum::NUMBER->value)
                                        <input tyoe="number"class="form-control" value="{{ $feature->curent_value }}"
                                            disabled>
                                    @elseif($feature->feature->field_type == App\Enums\FeatureFieldTypeEnum::COLOR->value)
                                        <input tyoe="color"class="form-control" value="{{ $feature->curent_value }}"
                                            disabled>
                                    @elseif ($feature->feature->field_type == App\Enums\FeatureFieldTypeEnum::CHOICES->value)
                                        @php
                                            $currentValue = json_decode($feature->current_value, true);
                                            $displayValue =
                                                app()->getLocale() == 'ar'
                                                    ? $currentValue['ar'] ?? ''
                                                    : $currentValue['en'] ?? '';
                                        @endphp
                                        <input type="text" class="form-control" value="{{ $displayValue }}"
                                            disabled>
                                    @endif
                                </td>
                                <td>
                                    <button
                                        class="btn btn-danger"onclick="deleteFeature({{ $feature->id }},'#feature_row_{{ $feature->id }}')"><i
                                            class="fa fa-trash"></i></button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
<div class="col-12 card">
    <div class="card-header">
        <h3 class="card-title">
            {{ __('add feature') }}
        </h3>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach ($features as $feature)
                <div class="col-12  mt-2">
                    <form id="attach_feature_{{ $feature->id }}_to_{{ $product->id }}">
                        @csrf
                        <div class="input-group">
                            <label class="input-group-text">
                                @if (app()->getLocale() == 'ar')
                                    {{ $feature->name_ar }}
                                @else
                                    {{ $feature->name_en }}
                                @endif
                            </label>
                            @if ($feature->field_type == App\Enums\FeatureFieldTypeEnum::COLOR->value)
                                <input type="color"name="value" class="form-control form-control-color"
                                    id="{{ $feature->field_type }}_{{ $feature->id }}">
                            @elseif ($feature->field_type == App\Enums\FeatureFieldTypeEnum::NUMBER->value)
                                <input type="number"name="value" class="form-control"
                                    id="{{ $feature->field_type }}_{{ $feature->id }}">
                            @elseif($feature->field_type == App\Enums\FeatureFieldTypeEnum::TEXT->value)
                                <input type="text"name="value" class="form-control"
                                    id="{{ $feature->field_type }}_{{ $feature->id }}">
                            @elseif ($feature->field_type == App\Enums\FeatureFieldTypeEnum::CHOICES->value)
                                <select class="form-control"name="value"
                                    id="{{ $feature->field_type }}_{{ $feature->id }}">
                                    @foreach ($feature->values as $value)
                                        <option value='@json($value)'>
                                            @if (app()->getLocale() == 'ar')
                                                {{ $value['ar'] }}
                                            @else
                                                {{ $value['en'] }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                            <button type="button"
                                class="btn btn-info"onclick="attachProductToFeature('attach_feature_{{ $feature->id }}_to_{{ $product->id }}')"><i
                                    class="fa fa-solid fa-link"></i></button>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</div>
<script>
    function attachProductToFeature(form_id) {
        const form = document.getElementById(form_id);
        const formData = new FormData(form);

        // Add required fields
        formData.append('product_id', "{{ $product->id }}");
        formData.append('feature_id', form_id.split('_')[2]);

        fetch("{{ route('admin.features.attach') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                // Clone the response to read it twice if needed
                const responseClone = response.clone();

                // First check the status
                if (!response.ok) {
                    return response.text().then(text => {
                        try {
                            // Try to parse as JSON if possible
                            const json = JSON.parse(text);
                            throw new Error(json.message || 'Request failed');
                        } catch (e) {
                            // If not JSON, throw the raw text
                            throw new Error(text || 'Request failed');
                        }
                    });
                }

                // If status is OK, parse as JSON
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showSuccessToast(data.message);
                    // Reset form input
                    const input = document.querySelector(`#${form_id} [class*="form-control"]`);
                    if (input) input.value = '';
                } else {
                    showErrorToast(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showErrorToast(error.message);

                // Special handling for authentication issues
                if (error.message.includes('Unauthenticated') ||
                    error.message.toLowerCase().includes('login')) {
                    window.location.href = "{{ route('admin.login') }}";
                }
            });
    }

    function deleteFeature(feature_product_id, feature_row) {
        // Create the data object to send
        const postData = {
            feature_product_id: feature_product_id,
            _token: document.querySelector('input[name="_token"]').value
        };

        fetch("{{ route('admin.features.deattach') }}", {
                method: 'POST',
                body: JSON.stringify(postData), // Stringify the object
                headers: {
                    'Content-Type': 'application/json', // Crucial for JSON data
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                // First check if response is JSON
                const contentType = response.headers.get('content-type');
                if (!response.ok) {
                    return response.text().then(text => {
                        try {
                            const json = JSON.parse(text);
                            throw new Error(json.message || 'Request failed');
                        } catch {
                            throw new Error(text || 'Request failed');
                        }
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showSuccessToast(data.message);
                    if (feature_row) $(feature_row).hide();
                } else {
                    showErrorToast(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showErrorToast(error.message);
            });
    }

    function showSuccessToast(message, title = 'Success') {
        toastr.success(message, title, {
            timeOut: 3000,
            progressBar: true,
            closeButton: true
        });
    }

    function showErrorToast(message, title = 'Error') {
        toastr.error(message, title, {
            timeOut: 5000, // Longer timeout for errors
            progressBar: true,
            closeButton: true
        });
    }

    function showWarningToast(message, title = 'Warning') {
        toastr.warning(message, title);
    }

    function showInfoToast(message, title = 'Info') {
        toastr.info(message, title);
    }
</script>
