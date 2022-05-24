<div class="col-lg-8">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Purchase List</h3>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-striped table-valign-middle">
            <thead>
            <tr>
              <th>#</th>
              <th>Date</th>
              <th>Order ID</th>
              <th>Total</th>
            </tr>
            </thead>
            <tbody>
              @inject('pro', 'App\Http\Controllers\ProductController')
            <?php $i=1; foreach($purchase as $pur){ //$supplier=""; ?>
                <tr id="{{$pur->lotnumber}}">
                  <td><?php echo $i.".";?></td>
                  <td><?php echo date("d M, Y", strtotime($pur->created_at));?></td>
                  <td>{{$pur->lotnumber}}</td>
                  <td>{{$pur->name}}</td>
                  <td><?php echo "Rs. ".$pro->getTotalByLot($pur->lotnumber);?></td>
                  <td class="text-right py-0 align-middle">
                    <div class="btn-group btn-group-sm">
                      <a href="/admin/purchase/purchase-detail/{{$pur->lotnumber}}" class="btn btn-info fetchitem"><i class="fas fa-edit"></i></a>
                      <a href="#" data-lot="{{$pur->lotnumber}}" class="btn btn-danger delorder"><i class="fas fa-trash"></i></a>
                    </div>
                  </td>
                </tr>
            <?php $i++; } ?>
            </tbody>
          </table>
        </div>
        <div class="card-footer">
          {{ $purchase->links('adminpanel.blocks.paginators') }}
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
          <h3 class="card-title">Customer List</h3>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-striped table-valign-middle">
            <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Purchase</th>
              <th>Cash</th>
              <th>Dew</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
        <div class="card-footer">
          {{ $customers->links('adminpanel.blocks.paginators') }}
        </div>
      </div>
      <!-- /.card -->
    </div>
    <!-- end of col -->
  </div>
  <!-- end of row -->
</div>
