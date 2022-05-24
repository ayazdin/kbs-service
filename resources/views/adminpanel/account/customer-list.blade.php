<div class="col-lg-8">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Customer List</h3>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-striped table-valign-middle">
            <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Order</th>
              <th>Paid</th>
            </tr>
            </thead>
            <tbody>
              @inject('acc', 'App\Http\Controllers\AccountController')
            <?php $i=1; foreach($customers as $cus){ //$supplier=""; ?>
                <tr>
                  <td><?php echo $i.".";?></td>
                  <td><a href="/admin/accounts/customer/{{$cus->id}}">{{$cus->name}}</a></td>
                  <td>Rs. {{$cus->orderTotal}}</td>
                  <td>Rs. <?php echo $acc->getAmountTotal($cus->id, 'cus');?></td>
                </tr>
            <?php $i++; } ?>
            </tbody>
          </table>
        </div>
        <div class="card-footer">

        </div>
      </div>
      <!-- /.card -->
    </div>
    <!-- end of col -->
  </div>
  <!-- end of row -->

</div>
