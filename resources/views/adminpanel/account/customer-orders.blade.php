<div class="col-lg-8">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Customer Orders</h3>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-striped table-valign-middle">
            <thead>
            <tr>
              <th>#</th>
              <th>Date</th>
              <th>Status</th>
              <th>Total</th>
            </tr>
            </thead>
            <tbody>
              @inject('acc', 'App\Http\Controllers\AccountController')
            <?php $i=1; foreach($orders as $ord){ //$supplier=""; ?>
                <tr>
                  <td><?php echo $i.".";?></td>
                  <td><?php echo date("d M, Y", strtotime($ord->created_at));?></td>
                  <td>{{$ord->status}}</td>
                  <td><?php echo $acc->getTotalByOrder($ord->orderid);?></td>
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

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Transaction List</h3>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-striped table-valign-middle">
            <thead>
            <tr>
              <th>#</th>
              <th>Date</th>
              <th>Particular</th>
              <th>Amount</th>
            </tr>
            </thead>
            <tbody>
              @inject('acc', 'App\Http\Controllers\AccountController')
            <?php $i=1; foreach($accounts as $ac){ //$supplier=""; ?>
                <tr>
                  <td><?php echo $i.".";?></td>
                  <td><?php echo date("d M, Y", strtotime($ac->created_at));?></td>
                  <td>{{$ac->particular}}</td>
                  <td>Rs. {{$ac->amount}}</td>
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
