<div class="card">
    <div class="card-header">
        <h3 class="card-title">Search Brands</h3>
    </div>
    <div class="card-body">
        <form id="searchForm" action="{{ route('admin.brand.search') }}" method="post">
            @csrf
            <!-- Name Section -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="search" class="form-label">{{ __('Search') }}</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fa fa-font text-info"></i></span>
                        <input type="text" id="search" name="search" class="form-control"
                            value="{{ request('search') }}">
                    </div>
                </div>
            </div>

            <!-- Status & Special -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="search_status" class="form-label">{{ __('Status') }}</label>
                    <select id="search_status" name="is_active" class="form-select">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>{{ __('Active') }}
                        </option>
                        <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>{{ __('Inactive') }}
                        </option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="search_is_featured" class="form-label">{{ __('featured Item') }}</label>
                    <select id="search_is_featured" name="is_featured" class="form-select">
                        <option value="">{{ __('All Items') }}</option>
                        <option value="1" {{ request('is_featured') == '1' ? 'selected' : '' }}>
                            {{ __('Yes') }}</option>
                        <option value="0" {{ request('is_featured') == '0' ? 'selected' : '' }}>
                            {{ __('No') }}</option>
                    </select>
                </div>
            </div>

            <button type="button" class="btn btn-outline-secondary" id="resetSearch">
                <i class="fa fa-undo me-1"></i> {{ __('Reset') }}
            </button>
            <button type="submit" form="searchForm" class="btn btn-info">
                <i class="fa fa-search me-1"></i> {{ __('Search') }}
            </button>
        </form>
    </div>
</div>
