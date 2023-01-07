<!-- Learn front-end development at rocket speed! http://inarocket.com -->
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ajax form
    </title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <style>
        .table-loading-overlay {
            top: 0;
            left: 0;
            right: 0;
            z-index: 10;
            background:  #ffffff;
            opacity: 0.4;
        }

        .searchbar{
            float: left;
            padding: 6px;
            margin-top: 8px;
            margin-right: 16px;
            border: none;
            font-size: 17px;
        }
        .dropdown{
            float: right;
            padding: 6px;
            margin-top: 8px;
            margin-right: 16px;
            border: none;
            font-size: 17px;
        }
        .noData{
            text-align: center;
        }

    </style>
</head>
<body>
<div class="container mt-3">
    <div class="col">
        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add new +
        </button>
    </div>
    <h2>Ajax form with modal
    </h2>
    <input class="searchbar" id="search" type="text" placeholder="Search..">
    <select class="dropdown" id="dropdown">
        <option selected disabled value="">Select Status</option>
        <option value="1">Active</option>
        <option value="2">Pending</option>
        <option value="3">Subscribed</option>
        <option value="4">Unsubscribed</option>
    </select>
            <!-- double optin success message -->
    <div class="table-loading-overlay">
        @if (\Session::has('success'))
        <div class="alert alert-success" role="alert">
            <p>{!! \Session::get('success') !!}</p>
        </div>
        @endif
            <!-- double optin success message end -->

    <table class="table table-striped" id="formList">
        <thead>
        <tr>
            <th>Firstname
            </th>
            <th>Lastname
            </th>
            <th>Email
            </th>
            <th>Action
            </th>
        </tr>
        </thead>
        <tbody id="renderData">


        </tbody>
    </table>

    </div>
</div>
<!-- Button trigger modal -->
<!-- Modal -->
<!-- Button trigger modal -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" bac>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Insert field
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>

            <div class="modal-body">
                <div class="alert alert-success" role="alert" id="successMsg" style="display: none" >
                    <p id="sucessMessage"></p>
                </div>
                <form id="SubmitForm">
                    <!-- Name input -->
                    <div class="mb-3">
                        <label class="form-label" for="fname">Name
                        </label>
                        <input class="form-control" id="fname" type="text" placeholder="Name"
                               data-sb-validations="required"/>
                        <span class="text-danger" id="fnameErrorMsg"></span><br>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="lname">Last name
                        </label>
                        <input class="form-control" id="lname" type="text" placeholder="Name"
                               data-sb-validations="required"/>
                        <span class="text-danger" id="lnameErrorMsg"></span><br>
                    </div>
                    <!-- Email address input -->
                    <div class="mb-3">
                        <label class="form-label" for="email">Email Address
                        </label>
                        <input class="form-control" id="email" type="email" placeholder="Email Address"
                               data-sb-validations="required, email"/>
                        <span class="text-danger" id="emailErrorMsg"></span><br>
                    </div>
                    <div class="mb-3">
                        <input type="file" id="myFile" name="filename">

                        <span class="text-danger" id="myFileErrorMsg"></span><br>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                </button>
                <input type="submit" class="btn btn-primary" value="Save changes">
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" bac>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Insert field
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>

            <div class="modal-body">
                <div class="alert alert-success" role="alert" id="successMsg" style="display: none" >
                    <p id="sucessMessage"></p>
                </div>
                <form id="updateForm">
                    <!-- Name input -->
                    <div class="mb-3">
                        <label class="form-label" for="fname">Name
                        </label>
                        <input class="form-control" id="firstname" type="text" placeholder="Name"
                               data-sb-validations="required"/>
                        <span class="text-danger" id="firstnameErrorMsg"></span><br>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="lastname">Last name
                        </label>
                        <input class="form-control" id="lastname" type="text" placeholder="Name"
                               data-sb-validations="required"/>
                        <span class="text-danger" id="lastnameErrorMsg"></span><br>
                    </div>
                    <!-- Email address input -->
                    <div class="mb-3">
                        <label class="form-label" for="email">Email Address
                        </label>
                        <input class="form-control" disabled id="ajemail" type="email" placeholder="Email Address"
                               data-sb-validations="required, email"/>
                        <span class="text-danger" id="ajemailErrorMsg"></span><br>

                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                </button>
                <input type=hidden id="id">
                <input type="submit" class="btn btn-primary" value="Save changes">
                </form>
            </div>

        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalview" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" bac>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View data
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>

            <div class="modal-body">
                <div>
                    <h6>Basic info</h6>
                    <p id="basic"></p>
                </div>
            <hr>
            <div>
            <h6>History</h6>
                <p id="history"></p>
            </div>

            <hr>
            <div>
                <h6>Salary</h6>
                <p id="salary" ></p>
            </div>
                <hr>
            <div>
                <p id="nodata" ></p>
            </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                </button>
                </form>
            </div>

        </div>
    </div>
</div>



<!-- jquery file for ajax -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>


<script type="text/javascript">
    var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
    getData();

    $('#search').on('keypress keyup',function(e){
        let searchKeyword = e.target.value;
        if(searchKeyword != ''){
            getData(searchKeyword,'');
        }else{
            getData();
        }

    })

    $('#dropdown').on('change',function(e){
        let changeKeyword = e.target.value;
        if(changeKeyword != ''){
            getData('', changeKeyword);
        }else{
            getData();
        }

    })

    function deleteEntry(id){
        let yes = confirm('Are you sure to delete?')

        if(yes) {
            $.ajax( {
                // url from the route
                url: "/spa/delete",
                type: "DELETE",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id,
                },
                success: function (response) {
                    $( '#successMsg' ).show();
                    $( '#sucessMessage' ).append( response.success );
                    getData();

                },
                error: function (response) {
                    console.log( response );
                },
            } );
        }

    }
    function editEntry(id){

        $.ajax( {
            // url from the route
            url: "/spa/edit/"+id,
            type: "GET",
            data: {
            },
            success: function (response) {
                // console.log(response);
                $("#updateModal").modal("show");
                $('#firstname').val(response.fname);
                $('#lastname').val(response.lname);
                $('#ajemail').val(response.email);
                $('#id').val(response.id);
            },
            error: function (response) {
                console.log( response );
            },
        } );

    }

    function viewDetails(id){

        $.ajax( {
            // url from the route
            url: "/spa/modalview/"+id,
            type: "GET",
            data: {
            },
            success: function (response) {
                console.log(response);
                $("#modalview").modal("show");
                if(jQuery.isEmptyObject( response )) {
                    console.log('if block')
                    $( '#basic' ).empty();
                    $( '#history' ).empty();
                    $( '#salary' ).empty();
                    $( '#nodata' ).append('No data found');

                }else {
                    console.log('else block')
                    $( '#basic' ).append( response.fname );
                    $( '#history' ).append( response.joining_date );
                    $( '#salary' ).append( response.basic_salary );
                    $( '#nodata' ).empty();

                }

            },
            error: function (response) {
                console.log( response );
            },
        } );

    }
    // let editMode = false;

    function getData(searchKeyword = '', changeKeyword = '' )
    {
        $.ajax( {
            // url from the route
            url: "/spa/list?search="+searchKeyword+"&change="+changeKeyword,
            type: "GET",
            data: {
            },
            success: function (response) {

                let data = response;
                var list_data = '';

                if(response.length >0) {


                    $.each( data, function (index, value) {
                        /*console.log(value);*/
                        list_data += '<tr>';
                        list_data += '<td>' + value.fname + '</td>';
                        list_data += '<td>' + value.lname + '</td>';
                        list_data += '<td>' + value.email + '</td>';
                        list_data += '<td><a href="javascript:viewDetails(' + value.id + ')">View</a> | <a href="javascript:editEntry(' + value.id + ')">Edit</a> | <a href="javascript:deleteEntry(' + value.id + ')">Delete</a></td>';
                        list_data += '</tr>';
                    } );

                }else {
                    list_data +='<tr> <td class="noData" colspan="4">No data found</td> </tr>';
                }
                $("#renderData").empty();
                $('.table-loading-overlay').css("opacity", "1");
                $("#renderData").append(list_data);


            },
            error: function (response) {
                console.log( response );
            },
        } );
    }

    $( '#SubmitForm' ).on( 'submit', function (e) {
        e.preventDefault();

        var files = $('#myFile')[0].files;

        var fd = new FormData();

        fd.append('fname', $( '#fname' ).val());
        fd.append('lname', $( '#lname' ).val());
        fd.append('email', $( '#email' ).val());
        fd.append('file',  files[0]);
        fd.append('_token',CSRF_TOKEN);

        // let fname = veriable // $('#fname') = from form id
        let form_fname = $( '#fname' ).val();
        let form_lname = $( '#lname' ).val();
        let form_email = $( '#email' ).val();
        let form_myFile = $( '#myFile' ).val();


        // remove error messages from the specific field where data is present
        $( '#fnameErrorMsg' ).text( '' );
        $( '#lnameErrorMsg' ).text( '' );
        $( '#emailErrorMsg' ).text( '' );
        $( '#myFileErrorMsg' ).text( '' );

        $.ajax( {
            // url from the route
            url: "/spa/store",
            type: "POST",
            data: fd,
            contentType: false,
            processData: false,
            dataType: 'json',

            success: function (response) {
                $( '#successMsg' ).show();
                $( '#sucessMessage' ).append( response.success );

                // remove error messages after successfully inserted
                $( '#fnameErrorMsg' ).text( '' );
                $( '#lnameErrorMsg' ).text( '' );
                $( '#emailErrorMsg' ).text( '' );
                $( '#myFileErrorMsg' ).text( '' );

                setTimeout(function() {
                    $('#exampleModal').modal('hide');
                    $( '#successMsg' ).hide();
                    $( '#sucessMessage' ).append('');
                }, 2000);
                getData();


            },
            error: function (response) {
                console.log( response );
                // $("#exampleModal").modal('hide');
                $( '#fnameErrorMsg' ).text( response.responseJSON.errors.fname );
                $( '#lnameErrorMsg' ).text( response.responseJSON.errors.lname );
                $( '#emailErrorMsg' ).text( response.responseJSON.errors.email );
                $( '#myFileErrorMsg' ).text( response.responseJSON.errors.myFile );

            },
        } );
    } );

    $( '#updateForm' ).on( 'submit', function (e) {
        editMode = true;
        e.preventDefault();
        // let fname = veriable // $('#fname') = from form id
        let form_fname = $( '#firstname' ).val();
        let form_lname = $( '#lastname' ).val();
        let form_email = $( '#ajemail' ).val();
        let form_id = $( '#id' ).val();


        // remove error messages from the specific field where data is present
        $( '#firstnameErrorMsg' ).text( '' );
        $( '#lastnameErrorMsg' ).text( '' );
        $( '#ajemailErrorMsg' ).text( '' );

        $.ajax( {
            // url from the route
            url: "/spa/update",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                firstname: form_fname,
                lastname: form_lname,
                ajemail: form_email,
                id: form_id,

            },
            success: function (response) {
                $( '#successMsg' ).show();
                $( '#sucessMessage' ).append( response.success );

                // remove error messages after successfully inserted
                $( '#firstnameErrorMsg' ).text( '' );
                $( '#lastnameErrorMsg' ).text( '' );
                $( '#ajemailErrorMsg' ).text( '' );
                $('#updateModal').modal('hide');
                getData();

            },
            error: function (response) {
                console.log( response );
                $( '#firstnameErrorMsg' ).text( response.responseJSON.errors.firstname );
                $( '#lastnameErrorMsg' ).text( response.responseJSON.errors.lastname );
                $( '#ajemailErrorMsg' ).text( response.responseJSON.errors.ajemail );

            },
        } );
    } );


</script>


<!-- Option 2: Separate Popper and Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"
        integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous">
</script>
</body>
</html>
