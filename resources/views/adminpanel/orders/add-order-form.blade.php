@push('cssfile')
<!-- Select2 -->
<link rel="stylesheet" href="/admin/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<style>
.pad-lft-0 {padding: 3px 0 3px 0px;}
.pad-lft {padding: 5px 0 5px 20px;}
.category-list {max-height: 250px;overflow-y: scroll;}
.mar-0 {margin: 0;}
.btn-info,
.btn-danger {color: #fff!important;}
.opt-val {float: left;width: 40%;}
.fa-add-but {float: left;margin-left: 10px;}
hr {margin-top: 20px;margin-bottom: 20px;border: 0;border-top: 2px solid #666;}
.hight-40 {height: 40px;}
.otherphotos img{width:60px; float: left; margin-bottom:10px; margin-right:10px;}
.otherphotos .fa-delete-but{margin: 10px;}
.otherphotos .btn-info {color: #fff!important;}
a.btn-danger{color: #fff!important;}
.qty {width: 60px;}
</style>
@endpush

<div class="col-lg-12">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Items</h3>
    </div>
    <input type="hidden" name="nextProd" value="1">
    <?php
      $i=0;$options="";
      foreach($products as $product) {
        $options .= '<option value="'.$product->id.'">'.$product->title.'</option>';
      }
    ?>
    <div class="card-body table-responsive" id="orderform">
      <div class="form-group">
        <div class="row">
          <div class="col-sm-6">
            <select class="select2" name="product[]" data-placeholder="Select Product" style="width: 100%;">
              <?php echo $options;?>
            </select>
          </div>
          <div class="col-sm-2">
            <input type="text" class="form-control" name="quantity[]" placeholder="Qty" value="0">
          </div>
          <div class="col-sm-4">
            <div class="fa-add-but">
              <a class="btn btn-info addItem" data-icount="<?php echo $i+1;?>">
                <i class="fas fa-plus-circle"></i>
              </a>
            </div>
            <?php if($i>0) {?>
            <div class="fa-add-but">
              <a class="btn btn-info delItem"  onclick="deleteValue(<?php echo $key;?>)">
                <i class="fas fa-minus-circle"></i>
              </a>
            </div>
          <?php } ?>
          </div>
        </div>
      </div>

    </div>
    <div class="card-footer">
      <button type="submit" class="btn btn-success">Add Order</button>
    </div>
  </div>
  <!-- /.card -->
</div>
@push('pagejs')
<!-- Select2 -->
<script src="/admin/plugins/select2/js/select2.full.min.js"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2();
  });

  $('#orderform').on('click', '.addItem', function(){
    iCount = $(this).data('icount');
    //console.log(iCount);
    nextValue = iCount+1;
    options = '<?php echo $options;?>';

    $('#orderform').append('<div class="form-group">'+
    '<div class="row">'+
        '<div class="col-sm-6">'+
          '<select class="select2" name="product[]" data-placeholder="Select Product" style="width: 100%;">'+options+'</select>'+
        '</div>'+
        '<div class="col-sm-2">'+
          '<input type="text" class="form-control" name="quantity[]" placeholder="Qty" value="0">'+
        '</div>'+
        '<div class="col-sm-4">'+
          '<div class="fa-add-but">'+
            '<a class="btn btn-info addItem" data-icount="'+nextValue+'">'+
              '<i class="fas fa-plus-circle"></i>'+
            '</a>'+
          '</div>'+
          '<div class="fa-add-but">'+
            '<a class="btn btn-info delItem"  onclick="deleteValue()">'+
              '<i class="fas fa-minus-circle"></i>'+
            '</a>'+
          '</div>'+
        '</div>'+
      '</div>'+
    '</div>');

    $('.select2').select2();

  });
</script>
@endpush
