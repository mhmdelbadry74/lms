<!-- Default Modals -->
<button type="button" class="btn btn-primary " data-bs-toggle="modal"
    data-bs-target="#myModal">{{ __('sending offer to client') }}</button>
<div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">{{ __('sending offer to client') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <div class="modal-body">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">
                                        <i class="fa fa-search me-2"></i>{{ __('Search for offers') }}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="input-group">
                                        <span class="input-group-text bg-white">
                                            <i class="fa fa-search"></i>
                                        </span>
                                        <input type="text" class="form-control form-control-lg"
                                            id="client_{{ $client->id }}_search_field"
                                            placeholder="{{ __('Type offer name or description...') }}"
                                            onkeyup="searchOffer('#client_{{ $client->id }}_search_field','#offer_results_{{ $client->id }}')">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">
                                        <i class="fa fa-tags me-2"></i>{{ __('Available Offers') }}
                                    </h5>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="80px">{{ __('ID') }}</th>
                                                    <th>{{ __('Name') }}</th>
                                                    <th width="120px">{{ __('Expire Date') }}</th>
                                                    <th width="120px">{{ __('Price') }}</th>
                                                    <th width="100px">{{ __('Actions') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody id="offer_results_{{ $client->id }}">
                                                <tr>
                                                    <td colspan="6" class="text-center py-4 text-muted">
                                                        {{ __('Search for offers to display results') }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary ">Save Changes</button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Toastr Notification Setup -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    // Configuration
    const app_locale = "{{ app()->getLocale() }}";
    const offer_search_url = "{{ route('admin.offers.ajax.search') }}";
    const attach_offer_url = "{{ route('admin.offers.ajax.sendOfferToClient') }}";
    const client_id = "{{ $client->id }}";
    const network_error_msg = "{{ __('Network error occurred') }}";
    const send_whats_up_button="{{ __('send by whats up') }}";
    const send_email_button="{{  __('send by email')}}";
    // Toastr configuration
    toastr.options = {
        positionClass: 'toast-top-right',
        timeOut: 5000,
        closeButton: true,
        progressBar: true,
        newestOnTop: true
    };

    // Enhanced search function with debounce
    let searchTimer;

    function searchOffer(keyword_place, results_place) {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => {
            const keyword = $(keyword_place).val().trim();

            if (keyword.length < 2 && keyword.length !== 0) {
                return;
            }

            $(results_place).html(`
                <tr>
                    <td colspan="6" class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 mb-0">{{ __('Searching...') }}</p>
                    </td>
                </tr>
            `);

            fetch(offer_search_url + `?keyword=${encodeURIComponent(keyword)}`)
                .then(response => {
                    if (!response.ok) throw new Error(network_error_msg);
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        displayResults(data.data, results_place);
                    } else {
                        throw new Error(data.message || 'API Error');
                    }
                })
                .catch(error => {
                    $(results_place).html(`
                        <tr>
                            <td colspan="6" class="text-center py-4 text-danger">
                                <i class="fa fa-exclamation-circle me-2"></i>
                                ${error.message}
                            </td>
                        </tr>
                    `);
                    toastr.error(error.message);
                });
        }, 500);
    }

    // Enhanced results display
    function displayResults(offers, results_place) {
        if (offers.length === 0) {
            $(results_place).html(`
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        <i class="fa fa-info-circle me-2"></i>
                        {{ __('No offers found matching your criteria') }}
                    </td>
                </tr>
            `);
            return;
        }

        let html = '';
        offers.forEach(offer => {
            html += `
                <tr>
                    <td class="fw-bold">${offer.id}</td>
                    <td>${app_locale === "ar" ? offer.name_ar : offer.name_en}</td>
                    <td>
                        <span class="badge ${new Date(offer.expire_date) > new Date() ? 'bg-success' : 'bg-danger'}">
                            ${offer.expire_date}
                        </span>
                    </td>
                    <td class="fw-bold text-primary">${offer.price}</td>

                    <td>
                        <button type="button" 
                                class="btn btn-sm btn-primary"
                                onclick="addclientToOffer(${offer.id}, ${client_id},0)">
                                ${send_whats_up_button}
                        </button>
                    </td>
                    <td>
                        <button type="button" 
                                class="btn btn-sm btn-primary"
                                onclick="addclientToOffer(${offer.id}, ${client_id}, 1)">
                            <i class="fa fa-plus me-1"></i> ${send_email_button}
                        </button>
                    </td>
                </tr>
            `;
        });
        $(results_place).html(html);
    }

    // Enhanced add client function with toast feedback
    async function addclientToOffer(offer_id, client_id, by_email) {

        try {
            const response = await fetch(
                `${attach_offer_url}?offer_id=${offer_id}&client_id=${client_id}&by_email=${by_email}`
            );

            if (!response.ok) throw new Error(network_error_msg);

            const data = await response.json();

            if (data.success) {
                toastr.success(data.message || "{{ __('client added to offer successfully') }}");

                // Close modal after success
                $('#add_client_' + client_id + '_to_offer_modal').modal('hide');

                // Optional: Refresh parent page or specific elements
                if (typeof refreshOfferList === 'function') {
                    refreshOfferList();
                }
            } else {
                throw new Error(data.message || "{{ __('Operation failed') }}");
            }
        } catch (error) {
            toastr.error(error.message);
            console.error('Error:', error);
        }
    }
</script>
