@extends('layouts.dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard/select2.css') }}">
@endsection

@section('dashboard')
    <form
        action="{{ route( 'seller.products.update', $product->id ) }}"
        method="POST"
        enctype="multipart/form-data">

        <div class="col-md-10 mx-auto">

            <div class="row">

                <div class="col-lg-12">
                    <div class="form-group">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $product->id }}">
                    </div>
                </div>

                <div class="col-lg-7">

                    <div class="form-group">
                        <label for="product_name">Product Name</label>
                        <input
                            type="text"
                            class="form-control form-control-lg @error('name') is-invalid @enderror"
                            id="product_name"
                            name="name"
                            placeholder="product Name"
                            value="{{ old('name') ? old('name') : $product->name }}"
                        />

                        @error('name')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">Product Price</label>
                        <input
                            type="text"
                            class="form-control form-control-lg @error('price') is-invalid @enderror"
                            id="price"
                            name="price"
                            placeholder="Product Price"
                            value="{{ old('price') ? old('price') : $product->price }}"
                        />
                        @error('price')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="color">Product Colors</label>
                        <input
                            type="text"
                            class="form-control form-control-lg @error('color') is-invalid @enderror"
                            id="color"
                            name="color"
                            placeholder="Product Color"
                            value="{{ old('color') ? old('color') : $product->color }}"
                        />
                        @error('color')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="sizes">Product Sizes</label>
                        <input
                            type="text"
                            class="form-control form-control-lg @error('size') is-invalid @enderror"
                            id="sizes"
                            name="size"
                            placeholder="Product Sizes"
                            value="{{ old('size') ? old('size') : $product->size }}"
                        />
                        @error('size')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="stock_quantity">Product Stock Quantity</label>
                        <input
                            type="number"
                            class="form-control form-control-lg @error('stock_quantity') is-invalid @enderror"
                            id="stock_quantity"
                            name="stock_quantity"
                            placeholder="Product Stock Quantity"
                            value="{{ old('stock_quantity') ? old('stock_quantity') : $product->stock_quantity }}"
                        />
                        @error('stock_quantity')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <div class="col-md-4 ml-md-auto">

                    <div class="form-group">
                        @include( 'components.categories-list', [
                            'multiple_select' => true
                        ] )
                    </div>

                    <div class="card card-body">
                        <div class="d-flex align-items-center">
                            <div class="switch w-100">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group d-flex align-items-center">
                                            <div class="switch m-r-10" id="switch_checkbox">
                                                <input  type="checkbox"
                                                        name="availability"
                                                        value="{{ $product->isAvailabile() ? 1 : 0 }}"
                                                        id="switch-1" {{ $product->isAvailabile() ? 'checked' : '' }}>
                                                <label for="switch-1"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <label>{{ $product->availability }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">

                        <img src="{{ $product->photo->main ?? '' }}" id="product_cover_preview" class="img-thumbnail" alt="">

                        <div id="change_product_cover">

                            <label class="btn btn-light mt-3" for="image">Choose to other Image</label>
                            <input
                                type="file"
                                name="product_cover"
                                class="input_product_cover d-none form-control @error('product_cover') is-invalid @enderror"
                                id="image">

                        </div>

                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Update</button>
        </div>
    </form>
@endsection

@section('scripts')

    @stack('categories-list-select2')

    <script>


        let product_cover = document.querySelector('.input_product_cover'),
            product_cover_preview = document.getElementById('product_cover_preview'),
            change_product_cover = document.getElementById('change_product_cover');

        product_cover.addEventListener('change', function() {

            let file = this.files[0];

            if( file ){

                let reader = new FileReader();

                reader.onload = function() {
                    product_cover_preview.setAttribute( 'src', this.result )
                };

                reader.readAsDataURL(file)

            }

        } );

        document.getElementById( 'switch_checkbox' ).addEventListener( 'click', e => {
            if( e.target.value == 0 ){
                e.target.value = 1
            }else{
                e.target.value = 1
            }
        } )

    </script>

@endsection
