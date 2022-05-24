<div class="card card-primary card-outline prod-opt">
    <div class="card-header with-border">
      <h3 class="card-title">Product Options</h3>
    </div>
    <div class="card-body" id="option-list">
      <?php
      $inventories="";
      //print_r($options);
      if(!empty($options))
      {
          $optionCount=1;
          $optionNumber='1';
          $valueCount=1;
          $optionNum=count($options);
          $opCols=[];
          foreach($options as $opt)
          {
            //print_r($opt);
            $valOption = $opt['options'];
            //$priceOption = $opt['prices'];
            $valCount = count($valOption);
            if($valCount==0)
              $valCount=1;
            if($optionCount==$optionNum and $optionCount==1)
              $optionNumber = $optionNumber;
            elseif($optionCount==$optionNum and $optionCount>1)
              $optionNumber = $optionNumber.$optionCount;
            elseif($optionCount==1)
              $optionNumber = $optionNumber.",";
            else
              $optionNumber .= $optionCount.",";
            //for the option price section
            $fld = preg_replace('/[^A-Z0-9]+/i', '', strtolower($opt['name']));
            $optemp = array($opt['name'], $fld);
      ?>
      <div class="option-box optList<?php echo $optionCount;?>">
        <input type="hidden" name="valueCount<?php echo $optionCount;?>"
                            id="valueCount<?php echo $optionCount;?>"
                            value="<?php echo $valCount+1;?>">
        <div class="form-group">
          <label for="option1name" class="col-sm-12 control-label lft-align">Name</label>
          <div class="col-sm-12">
            <input type="text" class="form-control" name="optName[]" placeholder="Option Name"
                  value="<?php echo $opt['name'];?>" onblur="saveField(this, <?php echo $opt['id'];?>)">
          </div>
        </div>
        <?php
          $i=0;
          //for($i=0; $i<$valCount;$i++)
          foreach($valOption as $key=>$value)
          {
        ?>
        <div class="form-group option<?php echo $optionCount;?>value<?php echo $i+1;?>">
          <label class="col-sm-12 control-label lft-align">Value</label>
          <div class="col-sm-12 hight-40">
            <input type="text" class="form-control opt-val mar-rht-10"
                                name="optValue<?php echo $optionCount;?>[]" placeholder="value"
                                value="<?php echo $value;?>" onblur="saveValue(this, <?php echo $key;?>)">
            <div class="fa-add-but">
              <a data-optioncount="<?php echo $optionCount;?>" data-valuecount="<?php echo $i+1;?>" class="btn btn-info addOptValue">
                <i class="fas fa-plus-circle"></i>
              </a>
            </div>
            <?php if($i>0) {?>
            <div class="fa-add-but">
              <a data-optioncount="<?php echo $optionCount;?>" data-valuecount="<?php echo $i+1;?>"
                            class="btn btn-info delOptValue"  onclick="deleteValue(<?php echo $key;?>)">
                <i class="fas fa-minus-circle"></i>
              </a>
            </div>
          <?php } ?>
          </div>
        </div>
        <!-- END of form-group-->
      <?php $i++;} ?>
      </div>
      <?php if($optionCount>1){?>
      <div class="del-button-row delOptionButton<?php echo $optionCount;?>">
        <button class="btn btn-danger btnDelOption" data-deloption="<?php echo $optionCount;?>" data-fieldid="<?php echo $opt['id'];?>">Delete Option</button>
      </div>
    <?php }?>
      <hr>
      <?php
          $optionCount++;}

      echo '<input type="hidden" name="optionNumber" id="optionNumber" value="'.$optionNumber.'">';
      }else {
        $optionCount=2;
      ?>
      <div class="option-box optList1">
        <input type="hidden" name="optionNumber" id="optionNumber" value="1">
        <input type="hidden" name="valueCount1" id="valueCount1" value="2">
        <div class="form-group">
          <label for="option1name" class="col-sm-12 control-label lft-align">Name</label>
          <div class="col-sm-12">
            <input type="text" class="form-control" name="optName[]" placeholder="Option Name">
          </div>
        </div>
        <div class="form-group option1value1">
          <label class="col-sm-12 control-label lft-align">Value</label>
          <div class="col-sm-12 hight-40">
            <input type="text" class="form-control opt-val" name="optValue1[]" placeholder="value">
            <div class="fa-add-but">
              <a data-optioncount="1" data-valuecount="1" class="btn btn-info addOptValue">
                <i class="fas fa-plus-circle"></i>
              </a>
            </div>
          </div>
        </div>
        <!-- END of form-group-->
      </div>
      <hr>
      <!-- END of option-box-->
    <?php }?>
    </div>
    <!-- END of box-body-->
    <div class="card-footer">
      <button class="btn btn-success btnAddOption" id="optCount" data-optioncount=<?php echo $optionCount;?>>Add Option</button>
      <button type="button" id="addInventory" class="btn btn-default" data-toggle="modal" data-target="#add-inventory">
        Add Inventory
      </button>
      <!-- <a class="btn btn-danger" >Add Inventory</a> -->
    </div>
    <!-- END of box-footer-->
</div>

<div class="modal fade" id="add-inventory">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Add Inventory</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="formInventory" id="formInventory" action="/admin/product/store-inventory" method="post">
        <?php echo $inventories;?>

        {{csrf_field()}}
      </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="storeInventory">Save changes</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php
  if(!empty($priceOptions))
    $priceSelCount = count($priceOptions);
  else
    $priceSelCount=0;
?>

@push('pagejs')
<script>
  $(function () {
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });
  });
function saveField(_obj, nameid)
{
  //console.log(_obj.value+'---'+nameid);
  var data = { 'fieldid':  nameid, 'fieldname' : _obj.value, _token: '{{csrf_token()}}'};
  $.post( "/admin/product/updatefield", data)
      .done(function( data ) {
          console.log( "Field Updated: " + data );
      });
}

function saveValue(_obj, valid)
{
  //console.log(_obj.value+'---'+valid);
  var data = { 'valid':  valid, 'valname' : _obj.value, _token: '{{csrf_token()}}'};
  $.post( "/admin/product/updatevalue", data)
      .done(function( data ) {
          console.log( "Value Updated: " + data );
      });
}

function deleteValue(valid)
{
  var data = { 'valid':  valid, _token: '{{csrf_token()}}'};
  $.post( "/admin/product/deletevalue", data)
      .done(function( data ) {
          console.log( "Value Deleted: " + data );
      });
}
$('#storeInventory').on('click', function(){
  var form = $('#formInventory');
  var formAction = $("#formInventory").attr('action');
  console.log(formAction);
  //return false;
  $.ajax({
         type: "POST",
         url: formAction,
         data: form.serialize(), // serializes the form's elements.
         success: function(data)
         {
             alert(data); // show response from the php script.
         }
  });
});
var _next = 0;
$('#addPrice').on('click', function(e){
  e.preventDefault();
  _next = $("#addPriceSelection").attr('data-nextsel');
  addPricingBlock();
});

$("#addPriceSelection").on('click', function(e){
  e.preventDefault();
  _next = $(this).attr('data-nextsel');
  //console.log("next11: "+_next);
  addPricingBlock();
  $(".price-list").append('<div class="sep'+_next+'"><hr></div>');
});
$('.price-list').on('click', '.delPriceField', function(){
  var _rowid = $(this).data('price-field');
  $(".priceField"+_rowid).remove();
  $(".sep"+_rowid).remove();
  _selCount = parseInt($("#priceSelCount").val());
  $("#priceSelCount").val(_selCount-1);
  //console.log(_rowid)
});
function addPricingBlock()
{
  var _optString = "";
  var _optValues = [];
  var _optSel = "";
  var _options = $("input[name='optName[]']")
          .map(function(){return $(this).val();}).get();
//console.log("OPtion check: "+_options);
  var _optNumber = $("#optionNumber").val();
  //console.log("OPtion Number: "+_optNumber);
  var _optArr = _optNumber.split(",");
  for(var i=0; i<_optArr.length;i++)
  {
    _optString='<option value="">Select</option>';
    var _optSet = $("input[name='optValue"+_optArr[i]+"[]']")
            .map(function(){return $(this).val();}).get();
    for(var j=0; j<_optSet.length;j++)
    {
      _optString += '<option value="'+_optSet[j]+'">'+_optSet[j]+'</option>';
    }
    _optValues[i]=_optString;
    _fieldNameStr = _options[i].toLowerCase();
    var _fieldName = _fieldNameStr.replace(/[^A-Z0-9]+/ig, "_");
    _optSel += '<div class="col-sm-4">'+
                '<label class="control-label lft-align">'+_options[i]+'</label>'+
                '<select class="form-control" name="'+_fieldName+'_sel[]">'+_optValues[i]+
                '</select>'+
              '</div>';

  }

    _output = '<div class="row form-group priceField'+_next+'">'+_optSel+
      '<div class="col-sm-4 hight-40">'+
        '<label class="control-label lft-align">Quantity</label><br>'+
        '<input type="text" class="form-control pfld" name="selPrice[]">'+
        '<a data-price-field="'+_next+'" class="btn btn-info delPriceField">'+
            '<i class="fas fa-minus-circle"></i>'+
          '</a>'+
      '</div>'+
    '</div>';
  $(".price-list").append(_output);
  var _psc = parseInt($("#priceSelCount").val())+1;
  $("#priceSelCount").val(_psc);
  //_next = ;
  //console.log("nextsel: "+_next);
  $("#addPriceSelection").attr('data-nextsel', parseInt(_next)+1);
}


var optCount = $("#optCount").data('optioncount');
var valCount = 2;
$('.btnAddOption').on('click', function(){
  //console.log(optCount);//return false;

  $('#option-list').append('<div class="option-box optList'+optCount+'">'+
    '<input type="hidden" name="valueCount'+optCount+'" id="valueCount'+optCount+'" value="2">'+
    '<div class="form-group">'+
      '<label for="optName" class="col-sm-12 control-label lft-align">Name</label>'+
      '<div class="col-sm-12">'+
        '<input type="text" class="form-control" name="optName[]" placeholder="Option Name">'+
      '</div>'+
    '</div>'+
    '<div class="form-group option'+optCount+'value1">'+
      '<label class="col-sm-12 control-label lft-align">Value</label>'+
      '<div class="col-sm-12 hight-40">'+
        '<input type="text" class="form-control opt-val mar-rht-10" name="optValue'+optCount+'[]" placeholder="value">'+
        /*'<input type="text" class="form-control opt-val" name="optPrice'+optCount+'[]" placeholder="price">'+*/
        '<div class="fa-add-but">'+
          '<a data-optioncount="'+optCount+'" class="btn btn-info addOptValue">'+
            '<i class="fas fa-plus-circle"></i>'+
          '</a>'+
        '</div>'+
      '</div>'+
    '</div>'+
  '</div>'+
  '<div class="del-button-row delOptionButton'+optCount+'">'+
    '<button class="btn btn-danger btnDelOption" data-deloption="'+optCount+'">Delete Option</button>'+
  '</div>'+
  '<div class="hr'+optCount+'"><hr></div>');
  optionStr = $("#optionNumber").val();
  $("#optionNumber").attr('value', optionStr+","+optCount);

  optCount++;
  return false;
});


$('#option-list').on('click', '.addOptValue', function(){
  optionCount = $(this).data('optioncount');
  valueCount = parseInt($('#valueCount'+optionCount).val());
  nextValue = valueCount+1;
  $('.optList'+optionCount).append('<div class="form-group option'+optionCount+'value'+valueCount+'">'+
    '<label class="col-sm-12 control-label lft-align">Value</label>'+
    '<div class="col-sm-12 hight-40">'+
      '<input type="text" class="form-control opt-val mar-rht-10" name="optValue'+optionCount+'[]" placeholder="value">'+
      /*'<input type="text" class="form-control opt-val" name="optPrice'+optionCount+'[]" placeholder="price">'+*/
      '<div class="fa-add-but">'+
        '<a data-optionCount="'+optionCount+'" data-valueCount="'+valueCount+'" class="btn btn-info addOptValue">'+
          '<i class="fas fa-plus-circle"></i>'+
        '</a>'+
      '</div>'+
      '<div class="fa-add-but">'+
        '<a data-optioncount="'+optionCount+'" data-valuecount="'+valueCount+'" class="btn btn-info delOptValue">'+
          '<i class="fas fa-minus-circle"></i>'+
        '</a>'+
      '</div>'+
    '</div>'+
  '</div>');
  $('#valueCount'+optionCount).attr('value', nextValue);

  return false;
});

$('#option-list').on('click', '.delOptValue', function(){
  delOptCount = $(this).data('optioncount');
  delValCount = $(this).data('valuecount');
  $(".option"+delOptCount+"value"+delValCount).remove();
  return false;
});

$('#option-list').on('click', '.btnDelOption', function(){
  if($(this).data('fieldid')!="")
  {
    var data = { 'fid':  JSON.stringify($(this).data('fieldid')), _token: '{{csrf_token()}}'};
    $.post( "/admin/product/deletefield", data)
        .done(function( data ) {
            console.log( data );
        });
  }
  delOption = $(this).data('deloption');
  $('.optList'+delOption).remove();
  $('.delOptionButton'+delOption).remove();
  $('.hr'+delOption).remove();

  itemArray = new Array();
  delOptionStr = $("#optionNumber").val();
  itemArray = delOptionStr.split(',');
  var itemIndex = $.inArray(delOption.toString(), itemArray);
  if (itemIndex != -1) {
      itemArray.splice(itemIndex, 1);
  }
  itemStr = itemArray.join(',');
  $("#optionNumber").attr('value', itemStr);

  return false;
});

$('#saveOption').on('click', function(){
  var opts = $('#optionNumber').val();
  optArr = opts.split(",");
  var optname= new Array();
  $("input[name='optName[]']").each(function(){
      optname.push($(this).val());
  });
  var optValueArr = new Array();
  for(var i=0;i<optArr.length;i++)
  {
    var opvalarr = new Array();
    $("input[name='optValue"+optArr[i]+"[]']").each(function(){
        opvalarr.push($(this).val());
    });
    optValueArr.push(opvalarr);
  }
  var data = { 'optNumber':  JSON.stringify(optArr), 'optName' : JSON.stringify(optname), 'optValue': JSON.stringify(optValueArr)};
  //console.log(data);

  $.post( "/admin/register/fields", data)
      .done(function( data ) {
          alert( "Data Loaded: " + data );
      });
});
</script>
<!-- Ekko Lightbox -->
<script src="/admin/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
@endpush
