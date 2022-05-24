<div class="card card-primary card-outline prod-opt">
    <div class="card-header">
      <h3 class="card-title">Product option</h3>
    </div>
    <div class="card-body table-responsive p-0">
      <div class="form-group">
        <label for="option1name" class="col-sm-12 control-label lft-align">Name</label>
        <div class="col-md-12">
          <input type="text" class="form-control" name="optName[]" placeholder="Option Name">
        </div>
      </div>

      <div class="form-group">
        <div class="row mar-0">
          <div class="col-lg-8">
            <input type="text" class="form-control opt-val mar-rht-10" name="optValue1[]" placeholder="value">
          </div>
          <div class="col-lg-4">
            <a data-optioncount="1" data-valuecount="1" class="btn btn-info addOptValue">
              <i class="fas fa-plus-circle"></i>
            </a>
          </div>
        </div>
      </div>

      <div class="form-group">
        <div class="row mar-0">
          <div class="col-lg-8">
            <input type="text" class="form-control opt-val mar-rht-10" name="optValue1[]" placeholder="value">
          </div>
          <div class="col-lg-4">
            <div class="btn-group btn-group-md">
              <a data-optioncount="1" data-valuecount="1" class="btn btn-info addOptValue">
                <i class="fas fa-plus-circle"></i>
              </a>
              <a data-optioncount="1" data-valuecount="1" class="btn btn-danger delOptValue">
                <i class="fas fa-minus-circle"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
      <!-- END of card-body-->
    </div>
    <!-- END of card-footer-->
    <div class="card-footer">
      <button class="btn btn-success btnAddOption" id="optCount" data-optioncount="2">Add Option</button>
      <button class="btn btn-success" id="addPrice">Add Quantity</button>
    </div>
    <!-- END of card-footer-->
</div>
