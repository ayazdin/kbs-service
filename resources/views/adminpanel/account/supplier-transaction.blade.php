<div class="col-lg-12">
  <div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title">Add Transaction</h3>
      <div class="card-tools">
        <!-- <a href="/admin/product/add" class="btn btn-tool btn-sm">
          <i class="fas fa-user-plus"></i>
        </a> -->
        <!-- <a class="btn btn-sm btn-info addPurchaseItem">Add item</a> -->
      </div>
    </div>
    <div class="card-body table-responsive p-0">
        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
        <div class="card-body" id="addItem">
          <div class="form-group">
            <label for="fullname">Select Supplier</label>
            <select class="form-control" name="supplier" id="supplier">
              <option value="">Select Supplier</option>';
              <?php
                if(!empty($suppliers)) {
                  foreach($suppliers as $supplier) {
                    echo '<option value="'.$supplier->id.'">'.$supplier->name.'</option>';
                  }
                }
              ?>
            </select>
          </div>
          <hr>
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <label for="fullname">Product name</label>
                <input type="text" class="form-control selproduct" name="productname[]" placeholder="Enter product name" value="">
              </div>
              <div class="col-md-2">
                <label for="quantity">Quantity</label>
                <input type="text" class="form-control" name="quantity[]" placeholder="Enter product quantity" value="">
              </div>
              <div class="col-md-2">
                <label for="cost">Cost per unit</label>
                <input type="text" class="form-control" name="cost[]" placeholder="Enter product cost" value="">
              </div>
              <div class="col-md-2">

              </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <input type="submit" class="btn btn-success submitItems" value="Submit">
          <a class="btn btn-info addPurchaseItem">Add item</a>
        </div>
    </div>
  </div>
  <!-- /.card -->
</div>

@push('pagejs')
<script type="text/javascript">
$(document).ready(function () {

});
</script>
@endpush
