<!-- <div class="col-lg-8">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title" id="ordid">Order Detail</h3>
    </div>
    <div class="card-body table-responsive p-0" id="view-detail">
      <h3>No Order Selected ...</h3>
    </div>
  </div>
</div> -->


<div class="col-lg-8">
  <div class="invoice p-3 mb-3" id="view-detail">
    <h3>Order Detail</h3>
    <div><p>No Order Selected ...</p></div>
  </div>
</div>

@push('pagejs')
<script>
//$(document).ready(function () {
  $(document).on('change','input.quantity',function(e){
  //$(".quantity").on('change', function(e){
    console.log($(e.target).attr('data-cartid'));
    //return false;
    var _qty = $(e.target).val();
    var _price = $(e.target).attr('data-price');
    var _cid = $(e.target).attr('data-cartid');
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
      var data = { 'cartid':  $(e.target).attr('data-cartid'), 'qty': $(e.target).val(), _token: '{{csrf_token()}}'};
      $.post( "/admin/orders/change-quantity", data)
          .done(function( html ) {
            console.log(html);
              //$("#_prodList").html(html);
          });
    }
    else{
        return false;
    }

  });
//});
</script>
@endpush
