<nav class="navbar navbar-expand-lg navbar-light bg-light">

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">

            <li class="nav-item">
                <a class="btn btn-primary" href="{{ route('seller.products.create') }}">Add New</a>
            </li>

            <li class="nav-item">
                <div class="d-md-flex">
                    <div class="m-b-10 m-r-15 m-l-15">
                        <select
                            class="select2"
                            id='categories' name="category">
                            <option value="all" selected>All Cateogries</option>
                            @foreach ( $categories as  $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category')  == $category->id ? 'selected' : '' }}
                                    >{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="m-b-10">
                        <select class="select2" name="availability" style="min-width: 180px;">
                            <option value="1" {{ request('availability') == 1 || ! request()->has( 'availability' ) ? 'selected' : '' }} >Available</option>
                            <option value="0" {{ request('availability')  == '0' ? 'selected' : '' }} >Not Available</option>
                        </select>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <div class="m-b-10 m-l-15">
                    <select class="select2" id='limit' name="limit">
                        <option value="15" selected>Number of rows:</option>
                        <option value="25" {{ request('limit')  == '25' ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('limit')  == '50' ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('limit')  == '100' ? 'selected' : '' }}>100</option>
                        <option value="500" {{ request('limit')  == '500' ? 'selected' : '' }}>500</option>
                    </select>
                </div>
            </li>

            <li class="nav-item m-l-15">
                <select class="select2" id='sales' name="sales">
                    <option value="only_has_sales" {{ request('sales')  == 'only_has_sales' ? 'selected' : '' }}>Has Sales</option>
                    <option value="has_no_sales" {{ request('sales')  == 'has_no_sales' ? 'selected' : '' }}>Has No Sales</option>
                </select>
            </li>
            <li class="nav-item m-l-15 d-flex align-items-center">
                <div class="checkbox">
                    <input name="trahsed" value="true" id="trahsed" type="checkbox" {{ request('trahsed')  == 'true' ? 'checked' : '' }}>
                    <label for="trahsed" class="m-b-0">Only Trashed</label>
                </div>
            </li>
            <li class="nav-item m-l-15">
                <button class="btn btn-success my-2 my-sm-0" type="submit">Filter</button>
                <a href="{{ route( 'seller.products.index' ) }}" class="btn btn-info my-2 my-sm-0 m-l-3">Clear Filter</a>
            </li>
        </ul>
    </div>
</nav>

@push('products-filter-bar')
    <script src="{{ asset('js/dashboard/select2.min.js') }}"></script>
    <script>
        $('.select2').select2();
    </script>
@endpush

