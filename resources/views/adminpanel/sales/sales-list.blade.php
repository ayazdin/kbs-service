@inject('crt', 'App\Http\Controllers\CartController')
<?php /*$i=1; foreach($sales as $sale){ ?>
<div class="col-lg-6">
  <!-- title row -->
  <div class="row">
    <div class="col-12">
      <h4>
        <i class="fas fa-globe"></i> {{$sale->name}}
        <small class="float-right orderdate">Date: <?php echo date("d M, Y", strtotime($sale->created_at));?></small>
      </h4>
    </div>
    <!-- /.col -->
  </div>
</div>
<?php } */?>




<div class="col-lg-12">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Sales</h3>
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
          <th>Customer</th>
          <th>Item</th>
          <th>Date</th>
          <th>Status</th>
          <th></th>
        </tr>
        </thead>
        <tbody>
          @inject('crt', 'App\Http\Controllers\CartController')
        <?php
            $i=1;
            foreach($sales as $sale){ //$supplier="";
        ?>
            <tr id="{{$sale->orderid}}">
              <td><?php echo $i.".";?></td>
              <td>
                {{$sale->name}}<br>
                Phone: {{$sale->phone}}<br>
                Email: {{$sale->email}}
              </td>
              <td>
                {{$sale->title}} - {{$sale->sku}}<br>
                <?php
                  $option="";
                  $option = $crt->getOptionValues($sale->option);
                  if($option!="")
                    echo $option;
                ?>
                <b>Quantity</b>: {{$sale->quantity}}
              </td>
              <td><?php echo date("d M, Y", strtotime($sale->created_at));?></td>
              <td>{{$sale->status}}</td>
              <td class="text-right py-0 align-middle">
                <div class="btn-group btn-group-sm">
                  <a href="#" class="btn btn-info fetchitem" data-orderid="{{$sale->orderid}}" data-orderdate="<?php echo date("d M, Y", strtotime($sale->created_at));?>"><i class="fas fa-edit"></i></a>
                  <a href="#" data-orderid="{{$sale->orderid}}" class="btn btn-danger delorder"><i class="fas fa-trash"></i></a>
                </div>
              </td>
            </tr>
        <?php $i++; } ?>
        </tbody>
      </table>
    </div>
    <div class="card-footer">
      {{ $sales->links('adminpanel.blocks.paginators') }}
    </div>
  </div>
  <!-- /.card -->
</div>
@push('pagejs')
<script src="/admin/plugins/sweetalert2/sweetalert2.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  $(".fetchitem").on('click', function(){
      console.log($(this).data('orderid'));
      //$("#ordid").html('Order ID - '+$(this).data('orderid'));

      $.ajax({
         type:'GET',
         url:"/admin/orders/view-order/"+$(this).data('orderid'),
         success:function(data){
            //console.log(data);
            $("#orderdate").html('Date: '+$(this).data('orderdate'));
            $("#view-detail").html(data);
         }
      });
  });

  $(".delorder").on('click', function(e){
    e.preventDefault();
    const ipAPI = '/admin/orders/delete/'+$(this).data('orderid');
    orderid = $(this).data('orderid');
    //const swal = require('sweetalert2')


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
            $("#"+orderid).remove();
            Swal.fire(
              'Deleted!',
              'Your file has been deleted.',
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
          'Your file has been deleted.',
          'success'
        )
      }
    });


  });

});
</script>
@endpush
