<table class="table table-bordered">
    <thead>
        <tr>
            <th>Attribute</th>
            {{-- @if ($attributes?->first())
                @foreach ($attributes->first()->itsValues as $value)
                    <th>
                        @if (app()->getLocale() == 'en')
                            {{ $value->value['en'] }}
                        @else
                            {{ $value->value['ar'] }}
                        @endif
                    </th>
                @endforeach
                <th>Select All</th>
            @endif --}}

        </tr>
    </thead>
    <tbody>
        @foreach ($attributes as $attribute)
            <tr>
                <td>
                    @if (app()->getLocale() == 'en')
                        {{ $attribute->name_en }}
                    @else
                        {{ $attribute->name }}
                    @endif
                </td>

                @foreach ($attribute->itsValues as $value)
                    <td class="text-center">
                        <input type="checkbox" name="attribute[{{ $attribute->id }}][{{ $value->id }}]"
                            class="attribute-value" data-attribute-id="{{ $attribute->id }}"
                            data-attribute-name="@if (app()->getLocale() == 'en') {{ $attribute->name_en }}@else{{ $attribute->name }} @endif"
                            data-value-id="{{ $value->id }}"
                            data-value-name="@if (app()->getLocale() == 'en') {{ $value->value['en'] }}@else{{ $value->value['ar'] }} @endif">
                    </td>
                @endforeach

                <td class="text-center">
                    <input type="checkbox" class="attribute-select-all" data-attribute-id="{{ $attribute->id }}">
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div id="combinations-container" class="mt-4">
    <h4>Product Variants</h4>
    <table class="table table-bordered variants-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Attributes Combination</th>
                <th>SKU</th>
                <th>Slug</th>
                <th>Retail Price</th>
                <th>Wholesale Price</th>
                <th>Wholesale Min Qty</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="variants-tbody">
            <!-- Variant rows will be inserted here -->
        </tbody>
    </table>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Store selected values
        const selectedValues = {};

        // Initialize select all functionality
        document.querySelectorAll('.attribute-select-all').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const attributeId = this.getAttribute('data-attribute-id');
                selectedValues[attributeId] = this.checked ?
                    Array.from(document.querySelectorAll(
                        `.attribute-value[data-attribute-id="${attributeId}"]`))
                    .map(el => {
                        return {
                            id: el.value,
                            attributeId: attributeId,
                            attributeName: el.getAttribute('data-attribute-name'),
                            valueId: el.getAttribute('data-value-id'),
                            valueName: el.getAttribute('data-value-name')
                        };
                    }) : [];

                document.querySelectorAll(
                    `.attribute-value[data-attribute-id="${attributeId}"]`).forEach(
                    function(item) {
                        item.checked = this.checked;
                    }.bind(this));

                generateCombinations();
            });
        });

        // Handle individual checkbox changes
        document.querySelectorAll('.attribute-value').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const attributeId = this.getAttribute('data-attribute-id');

                if (!selectedValues[attributeId]) {
                    selectedValues[attributeId] = [];
                }

                const valueData = {
                    id: this.value,
                    attributeId: attributeId,
                    attributeName: this.getAttribute('data-attribute-name'),
                    valueId: this.getAttribute('data-value-id'),
                    valueName: this.getAttribute('data-value-name')
                };

                if (this.checked) {
                    selectedValues[attributeId].push(valueData);
                } else {
                    selectedValues[attributeId] = selectedValues[attributeId].filter(
                        v => v.id !== this.value
                    );
                }

                // Update select-all checkbox
                const allChecked = selectedValues[attributeId].length ===
                    document.querySelectorAll(
                        `.attribute-value[data-attribute-id="${attributeId}"]`).length;
                document.querySelector(
                        `.attribute-select-all[data-attribute-id="${attributeId}"]`).checked =
                    allChecked;

                generateCombinations();
            });
        });

        // Generate all possible combinations
        function generateCombinations() {
            const attributesWithValues = Object.values(selectedValues).filter(arr => arr.length > 0);
            const tbody = document.getElementById('variants-tbody');
            tbody.innerHTML = '';

            if (attributesWithValues.length === 0) {
                return;
            }

            // Generate Cartesian product of all selected values
            const combinations = cartesianProduct(attributesWithValues);

            // Display combinations as table rows
            combinations.forEach((combination, index) => {
                const row = document.createElement('tr');
                row.dataset.combinationId = index;

                // Row number
                const numberCell = document.createElement('td');
                numberCell.textContent = index + 1;
                row.appendChild(numberCell);

                // Attributes combination
                const comboCell = document.createElement('td');
                comboCell.innerHTML = combination.map(item =>
                    `<strong>${item.attributeName}</strong>: ${item.valueName}`
                ).join('<br>');
                row.appendChild(comboCell);

                // SKU field
                const skuCell = document.createElement('td');
                const skuInput = document.createElement('input');
                skuInput.type = 'text';
                skuInput.name = `variants[${index}][sku]`;
                skuInput.className = 'form-control';
                skuInput.value = generateSKU(combination);
                skuCell.appendChild(skuInput);
                row.appendChild(skuCell);

                // Slug field
                const slugCell = document.createElement('td');
                const slugInput = document.createElement('input');
                slugInput.type = 'text';
                slugInput.name = `variants[${index}][slug]`;
                slugInput.className = 'form-control';
                slugInput.value = generateSlug(combination);
                slugCell.appendChild(slugInput);
                row.appendChild(slugCell);

                // Retail Price field
                const retailPriceCell = document.createElement('td');
                const retailPriceInput = document.createElement('input');
                retailPriceInput.type = 'number';
                retailPriceInput.name = `variants[${index}][retail_price]`;
                retailPriceInput.className = 'form-control';
                retailPriceInput.placeholder = '0.00';
                retailPriceInput.step = '0.01';
                retailPriceInput.min = '0';
                retailPriceCell.appendChild(retailPriceInput);
                row.appendChild(retailPriceCell);

                // Wholesale Price field
                const wholesalePriceCell = document.createElement('td');
                const wholesalePriceInput = document.createElement('input');
                wholesalePriceInput.type = 'number';
                wholesalePriceInput.name = `variants[${index}][wholesale_price]`;
                wholesalePriceInput.className = 'form-control';
                wholesalePriceInput.placeholder = '0.00';
                wholesalePriceInput.step = '0.01';
                wholesalePriceInput.min = '0';
                wholesalePriceCell.appendChild(wholesalePriceInput);
                row.appendChild(wholesalePriceCell);

                // Wholesale Min Quantity field
                const wholesaleMinQtyCell = document.createElement('td');
                const wholesaleMinQtyInput = document.createElement('input');
                wholesaleMinQtyInput.type = 'number';
                wholesaleMinQtyInput.name = `variants[${index}][wholesale_min_quantity]`;
                wholesaleMinQtyInput.className = 'form-control';
                wholesaleMinQtyInput.placeholder = '0';
                wholesaleMinQtyInput.min = '0';
                wholesaleMinQtyCell.appendChild(wholesaleMinQtyInput);
                row.appendChild(wholesaleMinQtyCell);

                // Action cell with submit button
                const actionCell = document.createElement('td');
                const submitBtn = document.createElement('button');
                submitBtn.className = 'btn btn-primary btn-sm save-variant';
                submitBtn.innerHTML = '<i class="fas fa-save"></i> Save';
                submitBtn.onclick = function() {
                    saveVariant(index, combination);
                };
                actionCell.appendChild(submitBtn);

                // Add status indicator
                const statusSpan = document.createElement('span');
                statusSpan.className = 'status-indicator ml-2';
                statusSpan.style.display = 'none';
                actionCell.appendChild(statusSpan);

                row.appendChild(actionCell);
                tbody.appendChild(row);
            });
        }
        // Generate slug based on combination
        function generateSlug(combination) {
            // Get base product slug (assuming it's available in your template)
            const baseSlug = '{{ $product->slug ?? "product" }}';
            
            // Create slug parts from attribute values
            const slugParts = combination.map(item => {
                // Clean the value name for URL
                return item.valueName.toLowerCase()
                    .replace(/[^\w\s-]/g, '') // Remove special chars
                    .replace(/[\s_-]+/g, '-')  // Replace spaces/underscores with hyphens
                    .replace(/^-+|-+$/g, '');   // Trim hyphens from start/end
            });
            
            // Combine with base slug
            return `${baseSlug}-${slugParts.join('-')}`;
        }
        // Generate a simple SKU based on combination
        function generateSKU(combination) {
            const baseSKU = 'PROD-';
            const attributeCodes = combination.map(item =>
                item.attributeName.substring(0, 3).toUpperCase() +
                item.valueId.toString().padStart(2, '0')
            ).join('-');
            return baseSKU + attributeCodes;
        }

        // Cartesian product function
        function cartesianProduct(arrays) {
            return arrays.reduce((a, b) =>
                a.flatMap(x =>
                    b.map(y => [...x, y])
                ),
                [
                    []
                ]
            ).filter(arr => arr.length > 0);
        }

        // Save variant via AJAX
        function saveVariant(index, combination) {
            const row = document.querySelector(`tr[data-combination-id="${index}"]`);
            const statusIndicator = row.querySelector('.status-indicator');

            // Get form values
            const variantData = {
                attributes: combination.map(item => ({
                    attribute_id: item.attributeId,
                    value_id: item.valueId
                })),
                sku: row.querySelector('input[name*="[sku]"]').value,
                slug: row.querySelector('input[name*="[slug]"]').value,
                retail_price: row.querySelector('input[name*="[retail_price]"]').value,
                wholesale_price: row.querySelector('input[name*="[wholesale_price]"]').value,
                wholesale_min_quantity: row.querySelector('input[name*="[wholesale_min_quantity]"]').value,
                product_id: {{ $product->id ?? 'null' }} // Include product ID
            };

            // Show loading state
            const submitBtn = row.querySelector('.save-variant');
            submitBtn.disabled = true;
            statusIndicator.style.display = 'inline-block';
            statusIndicator.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

            // AJAX request
            $.ajax({
                url: '{{ route('admin.productVariance.store',$product->id ) }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    variant: variantData
                },
                success: function(response) {
                    statusIndicator.innerHTML = '<i class="fa fa-check text-success"></i>';
                    setTimeout(() => {
                        statusIndicator.style.display = 'none';
                    }, 2000);

                    // Update fields with response data
                    if (response.sku) row.querySelector('input[name*="[sku]"]').value = response.sku;
                    if (response.slug) row.querySelector('input[name*="[slug]"]').value = response.slug;
                    if (response.retail_price) row.querySelector('input[name*="[retail_price]"]').value = response.retail_price;
                    if (response.wholesale_price) row.querySelector('input[name*="[wholesale_price]"]').value = response.wholesale_price;
                    if (response.wholesale_min_quantity) row.querySelector('input[name*="[wholesale_min_quantity]"]').value = response.wholesale_min_quantity;
                },
                error: function(xhr) {
                    statusIndicator.innerHTML = '<i class="fa fa-times text-danger"></i>';
                    console.error(xhr.responseText);
                },
                complete: function() {
                    submitBtn.disabled = false;
                    setTimeout(() => {
                        statusIndicator.style.display = 'none';
                    }, 2000);
                }
            });
        }
    });
</script>

<style>
    .variants-table {
        margin-top: 20px;
    }

    .variants-table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }

    .variants-table input.form-control {
        min-width: 100px;
    }

    .save-variant {
        min-width: 80px;
    }

    .status-indicator {
        font-size: 14px;
    }
</style>
