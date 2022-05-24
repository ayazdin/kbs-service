<div class="col-lg-12">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Purchases</h3>
      <div class="card-tools">
        <!--<a href="#" class="btn btn-tool btn-sm">
          <i class="fas fa-download"></i>
        </a>
        <a href="/admin/orders/add" class="btn btn-tool btn-sm">
          <i class="fas fa-user-plus"></i>
        </a>-->
      </div>
    </div>
    <div class="card-body table-responsive p-0">
      <table class="table table-striped table-valign-middle">
        <thead>
        <tr>
          <th>#</th>
          <th>Date</th>
          <th>Lot</th>
          <th>Supplier</th>
          <th>Total</th>
          <th></th>
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
@push('pagejs')
<script src="/admin/plugins/sweetalert2/sweetalert2.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  $(".delorder").on('click', function(e){
    e.preventDefault();
    const ipAPI = '/admin/purchase/delete/'+$(this).data('lot');
    var lotnumber = $(this).data('lot');
    //console.log(ipAPI);return false;
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
      preConfirm: () => {
        return fetch(ipAPI)
          .then(response => {
            if (!response.ok) {
              throw new Error(response.statusText)
            }
            //console.log("here");
            $("#"+lotnumber).remove();
            Swal.fire(
              'Deleted!',
              'Purchase order with lot number '+lotnumber+' has been deleted!!!',
              'success'
            )
            //return response.json()
          })
          .catch(error => {
            Swal.showValidationMessage(
              `Request failed: ${error}`
            )
          })
      }
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire(
          'Deleted!',
          'Purchase order with lot number '+lotnumber+' has been deleted!!!',
          'success'
        )
      }
    });


  });

});
</script>
@endpush
