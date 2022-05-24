<div class="col-lg-12">
  <div class="invoice p-3 mb-3" id="view-detail">
    <!-- title row -->
    <div class="row">
      <div class="col-12">
        <h4>
          <i class="fas fa-globe"></i> Inventory Management System
          <small class="float-right orderdate">Date: <?php echo date("d/m/Y");?></small>
        </h4>
      </div>
      <!-- /.col -->
    </div>

    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
          From <address>
          <strong>{{$supplier->name}}</strong><br>
          {{$supplier->location}}<br>
          Phone: {{$supplier->phone1}}<br>
          Email: {{$supplier->email}}
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <br>
        <b>Bill Number #007612</b><br>
        <b>Lot Number:</b> {{$lot}}<br>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col"></div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-12 table-responsive" id="view-detail">

        <table class="table table-striped">
          <thead>
          <tr>
            <th>Qty</th>
            <th>Product</th>
            <th>Subtotal</th>
            <th></th>
          </tr>
          </thead>
          <tbody>
            <?php
            $gtotal=0;
            foreach($items as $item)
            {
              $total = (float)$item->qty * (float)$item->cost;
              $gtotal = $gtotal+$total;
              echo '<tr id="'.$item->id.'">
                      <td><input type="text" class="quantity" data-pid="'.$item->id.'" data-price="'.$item->cost.'" size="4" value="'.$item->qty.'"></td>
                      <td>'.$item->title.'</td>
                      <td class="sub'.$item->id.'">Rs. '.$total.'</td>
                      <td><a href="#" data-pid="'.$item->id.'" class="btn btn-danger btn-sm delItem"><i class="fas fa-trash"></i></a></td>
                    </tr>';
            }
            ?>
          </tbody>
        </table>

      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-6"></div>
      <!-- /.col -->
      <div class="col-6">
        <p class="lead">Total Purchase Amount</p>

        <div class="table-responsive">
          <table class="table">
            <tbody>
            <tr>
              <th>Total:</th>
              <td id="gtotal">Rs. <?php echo $gtotal;?></td>
            </tr>
          </tbody></table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- <div class="row no-print">
      <div class="col-12">
        <a href="/admin/orders/change-status/{{$lot}}/done" class="btn btn-success float-right"><i class="fas fa-check"></i> Completed </a>
        <a href="/admin/orders/change-status/{{$lot}}/cancel" class="btn btn-danger float-right" style="margin-right: 5px;">
          <i class="fas fa-trash"></i> Cancel Order
        </a>
      </div>
    </div> -->

  </div>
</div>

@push('pagejs')
<script src="/admin/plugins/sweetalert2/sweetalert2.min.js"></script>
<script>
  $(document).on('change','input.quantity',function(e){
    var _qty = $(e.target).val();
    var _price = $(e.target).attr('data-price');
    var _cid = $(e.target).attr('data-pid');
    _total=_qty*_price;
    var _gtotal = 0;
    $("td.sub"+_cid).html("Rs. "+_total);
    $( "input.quantity" ).each(function( index ) {
      _gtotal += $(this).val()*$(this).attr('data-price');
      //console.log($(this).val()+'--'+$(this).attr('data-price'));
    });
    console.log(_gtotal);
    $("#gtotal").html("Rs. "+_gtotal);
    //return false;
    if(confirm("Are you sure you want change this quantity?")){
      var data = { 'pid':  $(e.target).attr('data-pid'), 'qty': $(e.target).val(), _token: '{{csrf_token()}}'};
      $.post( "/admin/purchase/change-quantity", data)
          .done(function( html ) {
            console.log(html);
              //$("#_prodList").html(html);
          });
    }
    else{
        return false;
    }
  });

$(document).ready(function () {
  $(".delItem").on('click', function(e){
    e.preventDefault();
    const ipAPI = '/admin/purchase/delete-item/'+$(this).data('pid');
    var pid = $(this).data('pid');
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
            $("#"+pid).remove();
            Swal.fire(
              'Deleted!',
              'One item deleted from your purchase list!!!',
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
