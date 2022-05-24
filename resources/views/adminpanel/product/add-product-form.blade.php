<div class="col-lg-8">
  <div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title">Add Product</h3>
      <div class="card-tools">
        <a href="/admin/product/add" class="btn btn-tool btn-sm">
          <i class="fas fa-user-plus"></i>
        </a>
      </div>
    </div>
    <div class="card-body table-responsive p-0">

        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="pid" name="pid" value="<?php if(!empty($product)) echo $product->id;?>">
        <div class="card-body">
          <div class="form-group">
            <label for="fullname">Product name</label>
            <input type="text" class="form-control" name="productname" id="productname" placeholder="Enter product name" value="<?php if(!empty($product)) echo $product->title;?>">
          </div>
          <div class="form-group">
            <label for="fullname">Slug</label>
            <input type="text" class="form-control" name="slug" id="slug" placeholder="Slug" value="<?php if(!empty($product)) echo $product->slug;?>">
          </div>
          <div class="form-group">
            <label for="fullname">Content</label>
            <textarea class="form-control tinymce" rows="3" name="description" id="description"><?php echo (!empty($product->description))? $product->description : ''; ?></textarea>
          </div>
        </div>
        <!-- /.card-body -->

    </div>
  </div>
  <!-- /.card -->
  @include('adminpanel.product.product-image')
  <?php //include('adminpanel.product.product-option')?>
</div>

@push('pagejs')
<script src="/admin/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="/admin/plugins/tinymce/tinymce.min.js"></script>
<script type="text/javascript">

$(document).ready(function () {
  var editor_config = {
      path_absolute : "{{ URL::to('/') }}/",
      selector: ".tinymce",
      height: 300,
      plugins: [
          "advlist autolink lists link image charmap print preview hr anchor pagebreak",
          "searchreplace wordcount visualblocks visualchars code fullscreen",
          "insertdatetime media nonbreaking save table contextmenu directionality",
          "emoticons template paste textcolor colorpicker textpattern"
      ],
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
      relative_urls: false,
      file_browser_callback : function(field_name, url, type, win) {
          var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
          var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;
          var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
          if (type == 'image') {
              cmsURL = cmsURL + "&type=Images";
          } else {
              cmsURL = cmsURL + "&type=Files";
          }
          tinyMCE.activeEditor.windowManager.open({
              file : cmsURL,
              title : 'Filemanager',
              width : x * 0.8,
              height : y * 0.8,
              resizable : "yes",
              close_previous : "no"
          });
      }
  };
  tinymce.init(editor_config);

  $('.form-group #productname').keyup(function(){
      var articleTitle= $('.form-group #productname').val();
      var slug = articleTitle.toLowerCase().replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-')
      $('.form-group #slug').val(slug);
  });
});
</script>
@endpush
