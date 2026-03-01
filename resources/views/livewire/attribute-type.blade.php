<div class="">
    <div class="col-6">
        <div class="form-group mt-3">
            <label for="attribute_type">{{ __('Attribute Type') }}</label>
            <select wire:change="$set('selectedAttributeType', $event.target.value)" class="form-control" id="attribute_type" name="attribute_type" required>
                <option value="" disabled>Select Attribute Type</option>
                @foreach($attributeTypes as $attributeType)
                    <option value="{{ $attributeType->value }}"@if($this->model && $this->model->attribute_type==\App\Enums\AttributeTypeEnum::SELECT->value) selected @endif>{{ $attributeType->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    
    <div class="col-12 container">
        <div class=" mt-3">
            <label>{{ __('Attribute Value') }}</label>

            @if($this->model && $this->model->attribute_type==\App\Enums\AttributeTypeEnum::SELECT->value)
                @foreach ($this->model->values as $index=>$value)
                    <div class='row'>
                        <input type="text" name="attribute_value[{{ $index }}][en]" class="col-6 form-control"style='width:50% !important' placeholder="{{ __('English Value') }}" value="{{ $value->value['en'] }}">
                        <input type="text" name="attribute_value[{{ $index }}][ar]" class="col-6 form-control"style='width:50% !important'  placeholder="{{ __('Arabic Value') }}" value="{{ $value->value['ar'] }}">
                    </div>

                @endforeach
            @endif
             @if($this->options)
                
                <div class='row'>

                        @foreach($options as $key => $value)
                                <input type="text" name="attribute_value[{{ $key }}][en]" class="col-6 form-control"style='width:50% !important' placeholder="{{ __('English Value') }}" value="{{ $value }}">
                                <input type="text" name="attribute_value[{{ $key }}][ar]" class="col-6 form-control"style='width:50% !important'  placeholder="{{ __('Arabic Value') }}" value="{{ $value }}">

                        @endforeach
                        
                </div>
            @endif

            @if($selectedAttributeType)
                @switch($selectedAttributeType)
                    @case('select')
                        <div class="list-group-item">
                            {{-- button to add options --}}
                            <button type="button" class="btn btn-primary" wire:click="addOption">
                                <i class="fa fa-plus"></i> {{ __('Add Option') }}
                            </button>
                        </div>
                        @break
                @endswitch
            @endif
        </div>
    </div>
</div>