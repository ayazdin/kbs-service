<div class="col-lg-12">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Products</h3>
      <div class="card-tools">
        <a href="/admin/products/add" class="btn btn-tool btn-sm">
          <i class="fas fa-cart-arrow-down"></i>
        </a>
        <a href="#" class="btn btn-tool btn-sm">
          <i class="fas fa-download"></i>
        </a>
        <a href="/admin/products/add" class="btn btn-tool btn-sm">
          <i class="fas fa-user-plus"></i>
        </a>
      </div>
    </div>
    <div class="card-body table-responsive p-0">
      <table class="table table-striped table-valign-middle">
        <thead>
        <tr>
          <th>SKU</th>
          <th>Title</th>
          <!-- <th>Supplier</th> -->
          <th>Stock</th>
          <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($products as $product){ //$supplier=""; ?>
        @inject('sc', 'App\Http\Controllers\SupplierController')
        <?php //$supplier = $sc->supplierById($product->supplierid);?>
            <tr>
              <td>{{$product->sku}}</td>
              <td>{{$product->title}}</td>
              <td><?php if($product->sold==0) echo 'IN'; else echo '<span class="">OUT</span>';?></td>
              <td class="text-right py-0 align-middle">
                <div class="btn-group btn-group-sm">
                  <a href="/admin/product/copy/{{$product->id}}" class="btn btn-secondary" title="Copy Product"><i class="fas fa-copy"></i></a>
                  <button type="button" id="addInventory" class="btn bg-olive" data-toggle="modal" data-target="#add-inventory" data-prodid="{{$product->id}}">
                    <i class="fas fa-shopping-cart"></i>
                  </button>
                  <a href="/admin/product/list-purchase/{{$product->id}}" class="btn btn-success" title="List purchase order"><i class="fas fa-shopping-cart"></i></a>
                  <!-- <a href="/admin/product/copy/{{$product->id}}" class="btn btn-warning" title="Purchase Order"><i class="fas fa-shopping-cart"></i></a> -->
                  <a href="/admin/product/edit/{{$product->id}}" class="btn btn-info" title="Edit Product"><i class="fas fa-edit"></i></a>
                  <a href="/admin/product/delete/{{$product->id}}" class="btn btn-danger" title="Delete Product"><i class="fas fa-trash"></i></a>
                </div>
              </td>
            </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  <!-- /.card -->
</div>

<div class="modal fade" id="add-inventory">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Purchase Order</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form name="formInventory" id="formInventory" action="/admin/product/store-inventory" method="post">
      <div class="modal-body">
        <?php //echo $inventories;?>
        <div id="_prodList"></div>
        {{csrf_field()}}
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="storeInventory">Save changes</button>
      </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@push('pagejs')
<script>
$('#storeInventory').on('click', function(){
  var form = $('#formInventory');
  var formAction = $("#formInventory").attr('action');
  //console.log(formAction);
  //return false;
  $.ajax({
         type: "POST",
         url: formAction,
         data: form.serialize(), // serializes the form's elements.
         success: function(data)
         {
             alert(data); // show response from the php script.
         }
  });
});
</script>
@endpush
