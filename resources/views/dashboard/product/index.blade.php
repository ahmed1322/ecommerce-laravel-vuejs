@extends('layouts.dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/select2.css') }}">
@endsection

@section('dashboard')

    <form action="{{ route( 'seller.products.filter' ) }}" method="GET">
        @include('partials.dashboard.products-filter-bar')
    </form>

    <form id="bulk_form" method="post">
        @csrf
        @include('partials.dashboard.products-actions-bar')
        <div class="card">
            <div class="card-body">
                <div class="m-t-25">
                    <table id="data-table" class="table">
                        <thead>
                            <tr>
                                <th>
                                    <div class="checkbox">
                                        <input id="bulk_check_all" type="checkbox">
                                        <label for="bulk_check_all" class="m-b-0"></label>
                                    </div>
                                </th>
                                <th>Product Name</th>
                                <th>Sales</th>
                                <th>Categories</th>
                                <th>Colors</th>
                                <th>Sizes</th>
                                <th>Stock Quantity</th>
                                <th>Avability</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ( $products as $product)
                            <tr role="row">
                                <td class="">
                                    <div class="checkbox">
                                        <input id="check-item-{{ $product->id }}" value="{{ $product->id }}" name="products_bluk[]" type="checkbox" />
                                        <label for="check-item-{{ $product->id }}" class="m-b-0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img class="img-fluid rounded" src="{{ $product->photo->thumb ?? ' ' }}" style="max-width: 60px;" alt="" />
                                        <h6 class="m-b-0 m-l-10">{{ $product->name }}</h6>
                                    </div>
                                </td>
                                <td> {{ $product->sales->count() }} </td>
                                <td class="sorting_1">{{ $product->categoriesName() }}</td>
                                <td>{{ $product->color }}</td>
                                <td>{{ $product->size }}</td>
                                <td>{{ $product->stock_quantity }}</td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        @if ( $product->isAvailabile() )
                                            <div class="badge badge-success badge-dot m-r-10"></div><div>In Stock</div>
                                        @else
                                            <div class="badge badge-danger badge-dot m-r-10"></div><div>Out of Stock</div>
                                        @endif
                                    </div>
                                </td>

                                <td>
                                    <a
                                        href="{{ route( 'seller.products.edit', $product->id ) }}"
                                        class="btn btn-icon btn-hover btn-sm btn-rounded pull-right btn-success">
                                        <i class="anticon anticon-edit"></i>
                                    </a>
                                    <button data-ele-delete-url="{{ route( 'seller.products.destroy', $product->id ) }}" class="btn btn-icon btn-hover btn-sm btn-rounded btn-danger">
                                        <i class="anticon anticon-delete"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                                <h2 class="text-center">No Products Found</h2>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing 1 to 7 of 7 entries</div>
                    </div>
                </div> --}}
            </div>
        </div>
    </form>

    <form
        id="delete_form"
        action=""
        method="post"
        class="d-none">
        @csrf
        @method('DELETE')
    </form>


    {{ $products->links( 'vendor.pagination.bootstrap-4' ) }}
@endsection

@section('scripts')
    <script src="{{ asset('js/dashboard/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dashboard/dataTables.bootstrap.min.js') }}"></script>
    @stack('categories-list-select2')
    @stack('products-actions-bar')
    @stack('products-filter-bar')
@endsection
