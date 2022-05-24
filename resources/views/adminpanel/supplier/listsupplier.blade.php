<div class="col-lg-9">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Suppliers</h3>
      <div class="card-tools">
        <a href="#" class="btn btn-tool btn-sm">
          <i class="fas fa-download"></i>
        </a>
        <a href="/admin/supplier/add" class="btn btn-tool btn-sm">
          <i class="fas fa-user-plus"></i>
        </a>
      </div>
    </div>
    <div class="card-body table-responsive p-0">
      <table class="table table-striped table-valign-middle">
        <thead>
        <tr>
          <th>Name</th>
          <th>Representative</th>
          <th>Email</th>
          <th>Location</th>
          <th>Phone</th>
          <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($suppliers as $supplier){?>
            <tr>
              <td>
                {{$supplier->name}}
              </td>
              <td>{{$supplier->rpname}}</td>
              <td>{{$supplier->email}}</td>
              <td>{{$supplier->location}}</td>
              <td>
                {{$supplier->phone1}}
                <?php if($supplier->phone2!="")echo '<br>'.$supplier->phone2;?>
              </td>
              <td class="text-right py-0 align-middle">
                <div class="btn-group btn-group-sm">
                  <a href="/admin/supplier/edit/{{$supplier->id}}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                  <a href="/admin/supplier/delete/{{$supplier->id}}" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                </div>
              </td>
            </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  <!-- /.card -->
</div>
