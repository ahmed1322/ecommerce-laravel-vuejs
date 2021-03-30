<div class="col-lg-12">

    <div class="row">

        <div class="col-lg-12">
            <label for="categories">select Categories</label>
        </div>

        <div class="col-lg-12">

            <select class="select2 form-control form-control-lg @error('categories') is-invalid @enderror"
                    id='categories' name="categories[]" multiple="multiple">
                <option value="" selected disabled>select Cateogries</option>
                @foreach ( $categories as  $category)
                    <option value="{{ $category->id }}"

                        {{ old( 'categories' ) == null && isset( $product ) && in_array( $category->id, $product->categoriesIDS() )  ? 'selected' : '' }}

                        {{ old( 'categories' ) && in_array( $category->id , old( 'categories' ) ) ? 'selected' : '' }}
                        >{{ $category->name }}</option>
                @endforeach
            </select>

            @error('categories')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror

        </div>



    </div>

</div>

@push('categories-list-select2')
    <script src="{{ asset('js/dashboard/select2.min.js') }}"></script>
    <script>
        $('.select2').select2();
    </script>
@endpush

