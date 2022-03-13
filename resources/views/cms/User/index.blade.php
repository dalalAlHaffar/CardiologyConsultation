@extends('cms.layouts.app')
@section('title', 'Users')

@section('content')
<section class="section">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="row pb-5">
                        <div class="col-md-6" style="margin-top : 40px">
                            <a href="{{url('cms/user/create')}}" ><i class="bx bxs-add-to-queue" ></i><span style="font-weight:600; font-size:medium">Add User</span></a>
                        </div>
                            <div class="col-md-6">
                                <input type="text" style="margin-top: 40px;" class="form-control" placeholder="Type Any Thing To search on .." name="search_query">
                            </div>
                        </div>
                        <div class="table-responsive dataTables_wrapper container-fluid dt-bootstrap4">
                            <table id="admin_promocode_table" class="table table-striped table-bordered no-wrap dataTable table-hover" style="width:100%">
                                <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Date</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
       
    </div>
    </section>

@endsection

@section('scripts')
<script>
        var PromoCodeTable = initAjaxDataTable("{{ route('cms.users.data') }}", [
             'id','name','email','role','created_at'
        ], "admin_promocode_table", function(event) {

            $("#checkAll").click(function() {
                $('input.delete-class:checkbox').not(this).prop('checked', this.checked);
            });

            let data = event.json.data;
            if (data.length == 0) {
                return;
            }

            let TRs = $('#admin_promocode_table')[0].rows;

            for (let i = 1; i < TRs.length; i++) {
                let row = TRs[i];
                let datum = data[i - 1];
            
                image = datum.image != null ? "<img style='width:100px;height:100px' src='" +"{{url('storage/user/')}}/" + datum.image +"'/>": "" ;
                $(row).children('td').remove()
                /* append number of rows */
                $(row).append("<td> " +datum.id+" </td>")
                $(row).append("<td> " + datum.name + " </td>")
                $(row).append("<td> " + datum.email + " </td>")
                $(row).append("<td> " + datum.role + " </td>")
                $(row).append("<td> " + datum.created_at + " </td>")
                $(row).append("<td> " + image + " </td>")
                /* append name columns */
                editUrl = "{{ url('/') }}" + "/cms/user/" + datum.id + "/edit"
                deleteUrl = "{{ url('/') }}" + "/cms/user/" + datum.id
                deleteAction ='fireSwal("'+deleteUrl+'")';
                $(row).append(
                "<td>"+
                "<a href='"+editUrl+"' data-bs-toggle='tooltip' data-bs-placement='top' title='Edit'   ><i class='ri-edit-2-fill font-15 mr-2'></i></a>"  +
                "<a href='#' onclick='"+deleteAction+"'  data-bs-toggle='tooltip' data-bs-placement='top' title='Delete'><i class='ri-delete-bin-2-fill font-15 mr-2' style='color:#ff00007a'></i></a>" +
                "</td>")


            }

        }, function(data) {
            $('#admin_promocode_table_filter').html('')
            data.search_query = $('input[name="search_query"]').val();
        });

        $('input[name="search_query"]').keyup(function(evt) {
            reloadData();
        });

        function reloadData() {
            PromoCodeTable.ajax.reload();
        }
    </script>
  
    @endSection


