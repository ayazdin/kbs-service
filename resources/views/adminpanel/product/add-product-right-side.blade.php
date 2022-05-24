<div class="col-lg-4">
  <div class="card card-primary card-outline">
    <div class="card-header with-border">
      <h3 class="card-title">SKU</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <div class="form-group">
        <input type="text" class="form-control" name="sku" id="sku" placeholder="SKU" value="{!!  !empty($product) ? $product->sku : '' !!}">
      </div>
    </div>
  </div>
  <!-- /.card -->

  <div class="card card-primary card-outline">
    <div class="card-header with-border">
      <h3 class="card-title">Options</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <div class="form-group">
        <label for="cp">Cost Price(NPR)</label>
        <input type="text" class="form-control" name="cp" id="cp" placeholder="Cost Price" value="<?php echo !empty($product)?$product->cp:0;?>">
      </div>
      <div class="form-group">
        <label for="wp">Wholesale Price(NPR)</label>
        <input type="text" class="form-control" name="wp" id="wp" placeholder="Wholesale Price" value="<?php echo !empty($product)?$product->wp:0;?>">
      </div>
      <!--<div class="form-group">
        <label for="op">Offer Price(NPR)</label>
        <input type="text" class="form-control" name="op" id="op" placeholder="Offer Price" value="<?php //echo !empty($product)?$product->op:0;?>">
      </div>-->
      <div class="form-group">
        <label for="sp">Selling Price(NPR)</label>
        <input type="text" class="form-control" name="sp" id="sp" placeholder="Selling Price" value="<?php echo !empty($product)?$product->sp:0;?>">
      </div>
      <div class="form-group">
        <label for="quantity">Quantity</label>
        <input type="text" class="form-control" name="quantity" id="quantity" placeholder="Quantity" value="<?php echo !empty($product) ? $product->quantity : 0;?>">
      </div>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->

  <?php /* <div class="card card-primary card-outline">
    <div class="card-header with-border">
      <h3 class="card-title">Supplier</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <div class="form-group">
        <select class="form-control" name="supplier" id="supplier">
          <option value="">Select</option>
          <?php if(!empty($suppliers)) { foreach($suppliers as $supplier) { ?>
            <option value="{{$supplier->id}}" <?php if(!empty($product) and $product->supplierid==$supplier->id) echo "selected"; ?>>{{$supplier->name}}</option>
          <?php  }} ?>
        </select>
      </div>
    </div>
  </div>
  <!-- /.card -->
  */ ?>

  <div class="card card-primary card-outline">
    <div class="card-header with-border">
      <h3 class="card-title">Publish</h3>
    </div>
    <?php
      $pu="checked";$un=""; $dr="";
      if(!empty($product)) {
        if($product->status=="publish") $pu="checked";
        if($product->status=="unpublish") $un="checked";
        if($product->status=="draft") $dr="checked";
      }
    ?>
    <!-- /.card-header -->
    <div class="card-body">
      <div class="radio">
        <input type="radio" name="rdoPublish" id="rdoPublish" value="publish" <?php echo $pu; ?>>
        <label>Publish</label>
      </div>
      <div class="radio">
        <input type="radio" name="rdoPublish" id="rdoUnpublish" value="unpublish" <?php echo $un;?>>
        <label>Pending Review</label>
      </div>
      <div class="radio">
        <input type="radio" name="rdoPublish" id="rdoDraft" value="draft" <?php echo $dr;?>>
        <label>Draft</label>
      </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <button type="submit" class="btn btn-success">Update</button>
    </div>
  </div>
  <!-- /.card -->


  <div class="card card-primary card-outline">
    <div class="card-header with-border">
      <h3 class="card-title">Category</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <div class="category-list">
        <?php echo $cateTree;?>
      </div>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->

</div>
