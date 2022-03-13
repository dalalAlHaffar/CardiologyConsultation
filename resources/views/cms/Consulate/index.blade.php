@extends('cms.layouts.app')
@section('title', 'Consulates')

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12 mx-auto">
            <div class="card">
                <div class="card-body">
                    <div class="row pb-5">
                        <label class="col-md-2 col-form-label" style="color : rgba(1, 41, 112, 0.6); font-weight: 600; margin-top : 40px">Status</label>
                        <div class="col-md-3" style="margin-top : 40px">
                            <select class="form-select" name="status" id="FilterStatus">
                                <option value="notAnswered" selected>NotAnswered</option>
                                <option value="answered">Answered</option>
                                <option value="All">ALL</option>
                            </select>
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
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Medical History</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>User Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="modal fade" id="basicModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="card-title " style="padding: 0px">Consultation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="answerForm" method="POST">
                    <div class="modal-body" id="answer">
                        <div class="row">
                            <label style="color: rgba(1, 41, 112, 0.6)" class="col-sm-3 col-form-label">Name:</label>
                            <div class="col-sm-9 mt-2">
                                <span id="name">VDVDDV</span>
                            </div>
                            <label  style="color: rgba(1, 41, 112, 0.6)" class="col-sm-3 col-form-label">Email:</label>
                            <div class="col-sm-9 mt-2">
                                <span id="email">VDVDDV</span>
                            </div>
                            <label  style="color: rgba(1, 41, 112, 0.6)" class="col-sm-3 col-form-label">Phone:</label>
                            <div class="col-sm-9 mt-2">
                                <span id="phone">VDVDDV</span>
                            </div>
                            <label  style="color: rgba(1, 41, 112, 0.6)" class="col-sm-3 col-form-label">Age:</label>
                            <div class="col-sm-9 mt-2">
                                <span id="age">VDVDDV</span>
                            </div>
                            <label  style="color: rgba(1, 41, 112, 0.6)" class="col-sm-3 col-form-label">Gender:</label>
                            <div class="col-sm-9 mt-2">
                                <span id="gender">VDVDDV</span>
                            </div>
                            <label  style="color: rgba(1, 41, 112, 0.6)" class="col-sm-3 col-form-label">Title:</label>
                            <div class="col-sm-9 mt-2">
                                <span id="title">VDVDDV</span>
                            </div>
                            <label  style="color: rgba(1, 41, 112, 0.6)"  class="col-sm-3 col-form-label"> History:</label>
                            <div class="col-sm-9 mt-2">
                                <span id="history">VDVDDV</span>
                            </div>
                            <label  style="color: rgba(1, 41, 112, 0.6)" class="col-sm-3 col-form-label">Description:</label>
                            <div class="col-sm-9 mt-2">
                                <div id="description">VDVDDV</div>
                            </div>
                            @csrf
                            @method('PUT')
                            <x-input>
                                <x-slot name="label">Answer: </x-slot>
                                <x-slot name="type">textarea</x-slot>
                                <x-slot name="name">answer</x-slot>
                                <x-slot name="id">yourAnswer</x-slot>
                                <x-slot name="forLogin">no</x-slot>
                            </x-input>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-sm btn-primary">Submit</button>

                    </div>
                </form>

            </div>
        </div>
    </div><!-- End Basic Modal-->

</section>


@endsection

@section('scripts')
<script>
    var PromoCodeTable = initAjaxDataTable("{{ route('cms.consulates.data') }}", [
        'id', 'title', 'description', 'medical_history', 'created_at','status'
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
            console.log(datum);
            $(row).children('td').remove()
            status = datum.status == 'Answered' ? 'bg-success' : 'bg-danger';

            str1 = datum.description.substr(0, 100);
            str2 = datum.description.substr(100);
            paramd = "dots-" + datum.id;
            paramm = "more-" + datum.id;
            paramb = "myBtn-" + datum.id;

            if (str2.length > 0) {
                str1 += '<span id="' + paramd + '"> ... </span>';
                str1 += '<span style="display: none;" id="' + paramm + '">';
                str1 += str2;
                str1 += '</span>'
                str1 += '<br><a style="cursor:pointer; color:#4154f1" onclick="toggleread(\'dots-' + datum.id + '\',\'more-' + datum.id + '\', \'myBtn-' + datum.id + '\')" id="' + paramb + '" style="color:blue"> Read more</a>';
            }

            medical_history1 = datum.medical_history.substr(0, 75);
            medical_history2 = datum.medical_history.substr(75);
            Mparamd = "m-dots-" + datum.id;
            Mparamm = "m-more-" + datum.id;
            Mparamb = "m-myBtn-" + datum.id;

            if (medical_history2.length > 0) {
                medical_history1 += '<span id="' + Mparamd + '"> ... </span>';
                medical_history1 += '<span style="display: none;" id="' + Mparamm + '">';
                medical_history1 += medical_history2;
                medical_history1 += '</span>'
                medical_history1 += '<br><a style="cursor:pointer; color:#4154f1" onclick="toggleread(\'m-dots-' + datum.id + '\',\'m-more-' + datum.id + '\', \'m-myBtn-' + datum.id + '\')" id="' + Mparamb + '" style="color:blue"> Read more</a>';
            }
            /* append number of rows */
            $(row).append("<td> " + datum.id + " </td>")
            $(row).append("<td> " + datum.title + " </td>")
            $(row).append("<td> " + str1 + " </td>")
            $(row).append("<td> " + medical_history1 + " </td>")
            $(row).append("<td> " + datum.created_at + " </td>")
            $(row).append("<td> " + '<span class="badge ' + status + '">' + datum.status + '</span>' + " </td>")
            $(row).append("<td> " + datum.user.name + " </td>")

            /* append name columns */
            editUrl = "{{ url('/') }}" + "/cms/consulate/" + datum.id + "/edit"
            $(row).append(
                "<td>" +
                '<a class="open-Answer" data-bs-toggle="modal" data-id="' + datum.id + '" data-bs-target="#basicModal" href="#"><i class="ri-question-answer-fill"></i></a>' +
                "</td>")


        }

    }, function(data) {
        $('#admin_promocode_table_filter').html('')
        data.search_query = $('input[name="search_query"]').val();
        data.status = $('select[name="status"]').val();
    });

    $('input[name="search_query"]').keyup(function(evt) {
        reloadData();
    });
    $('select[name="status"]').change(function(evt) {
        reloadData();
    });

    function reloadData() {
        PromoCodeTable.ajax.reload();
    }
</script>
<script>
    $(document).on("click", ".open-Answer", function() {
        var id = $(this).data('id');
        p = document.getElementById('answer');
        $.ajax({
            url: "{{ url('/') }}" + "/cms/consolute/" + id + "/edit",
            type: 'GET',
            success: function(data) {
                document.getElementById('answerForm').action = "{{url('/')}}" + "/cms/consolute/" + data.result.id; //Will set it

                p = document.getElementById('name');
                p.textContent = data.result.user.name;

                p = document.getElementById('email');
                p.textContent = data.result.user.email;


                p = document.getElementById('age');
                p.textContent = data.result.user.age;


                p = document.getElementById('gender');
                p.textContent = data.result.user.gender;

                p = document.getElementById('phone');
                p.textContent = data.result.user.phone;

                p = document.getElementById('title');
                p.textContent = data.result.title;

                p = document.getElementById('description');
                p.innerHTML = data.result.description;

                p = document.getElementById('history');
                p.textContent = data.result.medical_history;
                if (data.result.answer != null) {
                    p = document.getElementById('yourAnswer');
                    p.value = data.result.answer;
                }
            }
        });
    });
</script>
<script>
    function toggleread(dotsd, mored, btnd) {
        console.log(dotsd, mored, btnd);
        var dots = document.getElementById(dotsd);
        var moreText = document.getElementById(mored);
        var btnText = document.getElementById(btnd);

        if (dots.style.display === "none") {
            dots.style.display = "inline";
            btnText.innerHTML = "Read more";
            moreText.style.display = "none";
        } else {
            dots.style.display = "none";
            btnText.innerHTML = "Read less";
            moreText.style.display = "inline";
        }
    }
</script>
@endSection