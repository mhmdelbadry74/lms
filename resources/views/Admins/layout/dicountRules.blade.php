<!-- Default Modals -->
<button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#myModal">{{$button_name}}</button>
<div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">{{$button_name}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="" method="POST">
                    @csrf
                    <input type="hidden" name="operator" value="{{ $model }}">
                    <input type="hidden" name="value" value="{{ $model_id }}">
                    <input type="hidden" name="discount_conditions" value="{{ $discount_conditions }}">
                  
                    <div class='mb-3'>
                        <label for="coupon_code">{{__("coupon code ")}}</label>
                        <input type="text" class="form-control" id="coupon_code" name="coupon_code" placeholder="{{ __('coupon code') }}" required>
                        <div class="invalid-feedback">
                            {{ __('please enter a coupon code') }}
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal_{{ $model_id }}">Close</button>
                <button type="button" class="btn btn-primary" data-assign-discount-rule="modal_{{ $model_id }}">{{ $button_name }}</button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function () {
        $('[data-assign-discount-rule="modal_{{ $model_id }}"]').on('click', function (e) {
            e.preventDefault();
            var model = $(this).data('assign-discount-rule');
            var form = $('#myModal form');
            var actionUrl = "{{ route('admin.offers.assignDiscountRuleToModel') }}";
            form.attr('action', actionUrl);

            // Clear previous validation
            form.find('.is-invalid').removeClass('is-invalid');

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                success: function(response) {
                    // You can customize this part as needed
                    $('#myModal').modal('hide');
                    // Optionally show a success message
                    alert("Discount rule assigned successfully!");
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        // Laravel validation error
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            var input = form.find('[name="' + key + '"]');
                            input.addClass('is-invalid');
                            input.next('.invalid-feedback').text(value[0]);
                        });
                    } else {
                        alert("An error occurred. Please try again.");
                    }
                }
            });
        });
    });
</script>