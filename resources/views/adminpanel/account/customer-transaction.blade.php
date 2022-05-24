<div class="col-lg-4">
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
    <form name="addTransaction" method="post" action="/admin/accounts/customer-trans">
      <div class="card-body table-responsive p-0">
          <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
          <div class="card-body">
            <div class="form-group">
              <label for="fullname">Select Customer</label>
              <select class="form-control" name="customer" id="customer">
                <option value="">Select Customer</option>';
                <?php
                  if(!empty($users)) {
                    foreach($users as $user) {
                      if(!empty($id) and $user->id==$id)
                        echo '<option value="'.$user->id.'" selected>'.$user->name.'</option>';
                      else
                        echo '<option value="'.$user->id.'">'.$user->name.'</option>';
                    }
                  }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="fullname">Transaction Title</label>
              <input type="text" class="form-control" name="particular" placeholder="Enter transaction title" value="">
            </div>
            <div class="form-group">
              <label for="fullname">Amount</label>
              <input type="text" class="form-control" name="amount" placeholder="Enter amount paid" value="">
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <input type="submit" class="btn btn-success" value="Submit">
          </div>
      </div>
    </form>
  </div>
  <!-- /.card -->
</div>

@push('pagejs')
<script type="text/javascript">
$(document).ready(function () {

});
</script>
@endpush
