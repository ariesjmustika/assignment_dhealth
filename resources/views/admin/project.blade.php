@extends('template.admin_t')

@section('content')
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header">
                      {{-- <h3 class="card-title">DataTable with minimal features & hover style</h3> --}}
                    </div>

                    <div class="card-body" style="padding-bottom: 0%">
                        <form  id="form-search">
                        <div class="input-group form-group">
                            <div class="col-4">
                                <label for="project_name">Project Name</label>
                            <input type="text" class="form-control" id="project_name_filter" placeholder="Enter Project Name" name="project_name">
                            </div>
                            <div class="col-2">
                                <label for="client_id">Client </label>
                                <select class="form-control client_id" name="client_id" id="client_id_filter">
                                    <option value="">All Client</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="project_status">Status</label>
                                <select class="form-control" name="project_status" id="project_status_filter">
                                    <option value="">All Status</option>
                                    <option value="OPEN">OPEN</option>
                                    <option value="DOING">DOING</option>
                                    <option  value="DONE">DONE</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <label ></label>
                                <button type="button" class="btn btn-warning form-control"  id="search-filter" style="margin-top: 4%;">
                                    <label hidden></label>
                                    <i class="fa fa-search " ></i> Search
                                </button>
                            </div>
                            <div class="col-2">
                                <label ></label>
                                <button type="button" class="btn btn-warning form-control"  id="clear-filter" style="margin-top: 4%;">
                                    <label hidden></label>
                                    <i class="fa fa-eraser"></i> Clear
                                </button>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="col-4">
                                <button type="button" class="btn btn-primary "  id="add-btn">
                                    <i class="fa fa-plus"> Add </i>
                                </button>
                                <button type="button" class="btn btn-danger "  id="delete-btn">
                                    <i class="fa fa-trash"> Delete</i>
                                </button>
                                {{-- <button type="button" class="btn btn-info "  id="refresh-btn">
                                    <i class="fa fa-refresh"> Refresh</i>
                                </button>
                                <button type="button" class="btn btn-secondary "  id="check-btn">
                                    <i class="fa fa-refresh"> Check</i>
                                </button> --}}
                            </div>
                        </div>
                    </form>

                    </div>

                    <!-- /.card-header -->
                    <div class="card-body" style="padding-top: 0%">
                      <table  class="table table-bordered table-hover" id="table-project">
                        <thead>
                        <tr>
                            <th><input type="checkbox" class="check-all"></th>
                            <th>Action</th>
                            <th>Project Name</th>
                            <th>Client</th>
                            <th>Project Start</th>
                            <th>Project End</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody id="table_data">
                      </table>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->


                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
          </section>
          <!-- /.content -->

        <!-- Modal Add - Update -->
        <div class="modal fade" id="modal-storeUpdate" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="title-modal">Add Project</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url ('api/project/create') }}" method="post" id="form-add">
                    {{-- @csrf --}}
                    <div class="modal-body">
                        <input type="text" id="project_id" name="project_id" hidden>
                        <div class="form-group">
                            <label for="project_name">Project Name</label>
                            <input type="text" class="form-control" id="project_name" placeholder="Enter Project Name" name="project_name">
                        </div>
                        <div class="form-group">
                            <label for="client_id">Client Name</label>
                            <select class="form-control client_id" name="client_id" id="client_id" >
                                <option value="">Select Client Name</option>
                            </select>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="project_start">Project Start</label>
                                <input type="date" class="form-control " id="project_start" name="project_start">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="project_end">Project End</label>
                                <input type="date" class="form-control " id="project_end" name="project_end" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="project_status">Project Status</label>
                            <select class="form-control" name="project_status" id="project_status">
                                <option value="">Select Status</option>
                                <option value="OPEN">OPEN</option>
                                <option value="DOING">DOING</option>
                                <option  value="DONE">DONE</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btn-modal">Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Delete Logout-->
        <div class="modal fade" id="modal-delete" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="title-modal-delete">Delete Project</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url ('api/project/destroy') }}" method="post" id="form-delete">
                    {{-- @csrf --}}
                    <div class="modal-body">
                        <p style="font-weight:bold;" id="modal-text">Are you sure want to delete Project <span id="deleted-list" style="color: red"></span> ?</p>
                        <input type="text" id="project_id_array" name="project_id" hidden>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger" id="btn-text">Delete</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
