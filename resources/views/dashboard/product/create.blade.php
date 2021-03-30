@extends('layouts.dashboard')

@dump($errors)

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard/select2.css') }}">
@endsection

@section('dashboard')
    <form
        action="{{ route( 'seller.products.store' ) }}"
        method="POST"
        enctype="multipart/form-data">

        <div class="col-md-10 mx-auto">

            <div class="row">

                <div class="col-lg-12">
                    <div class="form-group">
                        @csrf
                    </div>
                </div>

                <div class="col-lg-7">

                    <div class="form-group">
                        <label for="product_name">Name</label>
                        <input
                            type="text"
                            class="form-control form-control-lg @error('name') is-invalid @enderror"
                            id="product_name"
                            name="name"
                            placeholder="product Name"
                            value="{{ old('name') }}"
                        />

                        @error('name')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">Price</label>
                        <input
                            type="text"
                            class="form-control form-control-lg @error('price') is-invalid @enderror"
                            id="price"
                            name="price"
                            placeholder="Product Price"
                            value="{{ old('price') }}"
                        />
                        @error('price')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="color">Colors</label>
                        <input
                            type="text"
                            class="form-control form-control-lg @error('color') is-invalid @enderror"
                            id="color"
                            name="color"
                            placeholder="Color"
                            value="{{ old('color') }}"
                        />
                        @error('color')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="sizes">Sizes</label>
                        <input
                            type="text"
                            class="form-control form-control-lg @error('size') is-invalid @enderror"
                            id="sizes"
                            name="size"
                            placeholder="Product Sizes"
                            value="{{ old('size') }}"
                        />
                        @error('size')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="stock_quantity">Stock Quantity</label>
                        <input
                            type="number"
                            class="form-control form-control-lg @error('stock_quantity') is-invalid @enderror"
                            id="stock_quantity"
                            name="stock_quantity"
                            placeholder="Product Stock Quantity"
                            value="{{ old('stock_quantity') }}"
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
                                                        value="1"
                                                        id="switch-1" {{ old('availability') ? 'checked' : '' }}>
                                                <label for="switch-1"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <label>Availability</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-file" id="add_product_cover">
                            <input
                                id="input_product_cover"
                                class="custom-file-input @error('image') is-invalid @enderror"
                                type="file" name="image">
                                @error('image')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            <label class="custom-file-label" for="input_product_cover">Choose Product Cover</label>
                        </div>

                        <img src="" id="product_cover_preview" class="img-thumbnail d-none" alt="">

                        <button class="btn btn-light d-none" id="change_image">Choose an other image</button>

                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Create</button>
        </div>
    </form>
@endsection

@section('scripts')

    @stack('categories-list-select2')

    <script>
        let product_cover_input = document.getElementById('input_product_cover'),
            product_cover_preview = document.getElementById('product_cover_preview'),
            change_product_cover = document.getElementById('change_product_cover'),
            add_product_cover = document.getElementById('add_product_cover'),
            change_image =  document.getElementById( 'change_image' );

        product_cover_input.addEventListener('change', function() {

            let file = this.files[0];

            if( file ){

                let reader = new FileReader();

                reader.onload = function() {
                    product_cover_preview.classList.remove('d-none');
                    product_cover_preview.classList.add('d-block');
                    product_cover_preview.setAttribute( 'src', this.result )
                };

                reader.readAsDataURL(file)

                change_image.classList.remove("d-none");
                add_product_cover.classList.add("d-none");
            }

        } );

        change_image.addEventListener( 'click', function(e){
            e.preventDefault();
            product_cover_input.click();
        });

    </script>

@endsection
