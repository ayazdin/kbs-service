<div class="card card-primary card-outline">
  <div class="card-header with-border">
    <h3 class="card-title">Featured Image</h3>
  </div>
  <!-- /.box-header -->
  <div class="card-body">
    <div class="form-group">
      <div class="col-lg-12 hidden-xs">
        <label for="image">Upload Feature Image</label>
        <div class="input-group">
          <div class="custom-file">
            <input type="file" class="custom-file-input" name="image[]">
            <label class="custom-file-label" for="image">Choose file</label>
          </div>
        </div>
        @if(!empty($product->images))
            <a class="example-image-link" href="{{ URL::to($product->images) }}" data-lightbox="featuredImage">
            <img id="holder" style="margin-top:15px;max-height:100px; width: 100%; object-fit: scale-down;" src="{{ URL::to($product->images) }}">
            </a>
        @endif
      </div>
      <div class="col-lg-12 visible-xs-block">
        <label for="imagecap">Capture Feature Image</label>
        <div class="input-group">
          <div class="custom-file">
            <input type="file" class="custom-file-input" name="imagecap[]" accept="image/*;capture=camera">
            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
          </div>
        </div>
        @if(!empty($post->image))
            <a class="example-image-link" href="{{ URL::to($post->image) }}" data-lightbox="featuredImage">
            <img id="holder" style="margin-top:15px;max-height:100px; width: 100%; object-fit: scale-down;" src="{{ URL::to($post->image) }}">
            </a>
        @endif
      </div>
    </div>
  </div>
  <!-- /.card-body -->
</div><!--card-->

<div class="card card-primary card-outline otherphotos">
  <div class="card-header with-border">
    <h3 class="card-title">Add Other Photos</h3>
  </div>
  <!-- /.box-header -->
  <div class="card-body">
    <div class="form-group">
        <label for="images">For Multiple Image uploads</label>
        <div class="input-group">
          <div class="custom-file">
            <input type="file" class="custom-file-input" name="images[]" multiple>
            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
          </div>
        </div>
    </div>
    @if(!empty($images))
    <div class="form-group">
      <div class="row">
        <?php foreach($images as $image){ $img = unserialize($image->images);?>
        <div class="col-sm-6">
          <a href="/<?php echo $img[3];?>" data-toggle="lightbox" data-gallery="gallery">
            <img src="/<?php echo $img[1];?>">
          </a>
          <div class="fa-delete-but">
            <a href="/admin/product/delete-image/{{$image->id}}" class="btn btn-info">
              <i class="fas fa-times-circle"></i>
            </a>
          </div>
        </div>
        <?php }?>
      </div>
    </div>

    @endif
  </div>
  <!-- /.card-body -->
</div><!--card-->
