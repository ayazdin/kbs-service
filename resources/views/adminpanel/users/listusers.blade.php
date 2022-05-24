      <div class="col-lg-8">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Users</h3>
            <div class="card-tools">
              <a href="#" class="btn btn-tool btn-sm">
                <i class="fas fa-download"></i>
              </a>
              <a href="/admin/user/add" class="btn btn-tool btn-sm">
                <i class="fas fa-user-plus"></i>
              </a>
            </div>
          </div>
          <div class="card-body table-responsive p-0">
            <table class="table table-striped table-valign-middle">
              <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th></th>
              </tr>
              </thead>
              <tbody>
              <?php foreach($customers as $customer){?>
                  <tr>
                    <td>{{$customer->name}}</td>
                    <td>{{$customer->email}}</td>
                    <td>{{$customer->role_id}}</td>
                    <td class="text-right py-0 align-middle">
                      <div class="btn-group btn-group-sm">
                        <a href="/admin/user/edit/{{$customer->id}}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                        <a href="/admin/user/delete/{{$customer->id}}" class="btn btn-danger"><i class="fas fa-trash"></i></a>
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
