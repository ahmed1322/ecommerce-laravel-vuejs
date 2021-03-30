<nav class="navbar navbar-expand-lg navbar-dark bg-dark rounded">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a  class="nav-link dropdown-toggle"
                    data-toggle="dropdown"
                    href="#"
                    role="button"
                    aria-haspopup="true"
                    aria-expanded="false">Bulk Actions</a>
                <div class="dropdown-menu text-center" style="min-width: 280px;">
                    <div class="d-block mb-2" id="trash_restore_btn" type="submit">Restore Trashed</div>
                    <hr class="dropdown-divider">
                    <div class="d-block mb-2" id="trash_btn" type="submit">Trash Sellected</div>
                    <hr class="dropdown-divider">
                    <div id="delete_btn" class="text-danger d-block mb-2" type="submit">Delete Sellected Permanently</button>
                </div>
            </li>
        </ul>
    </div>
</nav>

@push('products-actions-bar')
<script>

    const bulk_form = document.getElementById('bulk_form');
    const bulk_check_all = document.getElementById('bulk_check_all');
    const checkboxs = [...document.querySelectorAll( 'input[name="products_bluk[]"]' )];

    // Trash action
    bulkAction( document.getElementById('trash_btn'), "{{ route( 'seller.products.trash.bulk' ) }}", 'Nothing Selected to Trash' )
    // Restore trashed action
    bulkAction( document.getElementById('trash_restore_btn'), "{{ route( 'seller.products.trash.restore' ) }}", 'Nothing Selected to Restore' )
    // Delete action
    bulkAction( document.getElementById('delete_btn'), "{{ route( 'seller.products.destroy.all' ) }}", 'Nothing Selected to Delete' )

    // Bulk action function
    function bulkAction( ele, route, alert_msg ){

        ele.addEventListener( 'click', e => {
            e.preventDefault();
            if( ! hasSelectedProducts()){
                alert( alert_msg );
                return;
            }
            bulk_form.setAttribute( 'action', route );
            bulk_form.submit();
        });

    }

    // toggle checkbox
    bulk_check_all.addEventListener( 'click', () => {

        let bulk_ckeckbox_state = bulk_check_all.checked;

        if( bulk_ckeckbox_state ){
            checkboxs.forEach( checkbox => {
                checkbox.checked = true
            });
        }else if( bulk_ckeckbox_state === false ){
            checkboxs.forEach( checkbox => {
                checkbox.checked = false
            });
        }
    });

    // Check if there is at least one element has checked
    function hasSelectedProducts(){
        let selected = checkboxs.filter( checkbox => checkbox.checked )
        return selected.length ? true : false;
    }

    // Delete element dataset.eleId
    const ele_delete_btn = [ ...document.querySelectorAll( '[data-ele-delete-url]' ) ];
    const delete_form = document.getElementById( 'delete_form' );

    ele_delete_btn.forEach( btn => {
        btn.addEventListener( 'click', function(e) {
            e.preventDefault();
            delete_form.setAttribute( 'action', btn.dataset.eleDeleteUrl );
            delete_form.submit();
        })
    } )

</script>

@endpush
