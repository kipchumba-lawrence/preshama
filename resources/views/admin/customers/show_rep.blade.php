@extends('layouts.app')
@section('meta')
    <title>Preshama - Manage app users</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/dt-global_style.css') }}">
    <link href="{{ asset('assets/css/apps/invoice-list.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page-action')
    <h3>Manage app users</h3>
@endsection
@section('main-content')
    <!--  BEGIN CONTENT PART  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing" id="cancel-row">

                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <h3>Sales Reps</h3>
                    <div class="widget-content widget-content-area br-6">
                        @include('includes.messages')
                        <div class="dt-buttons">
                            <a class="dt-button btn btn-primary btn-sm" href="{{ route('customers.create') }}"
                                tabindex="0" aria-controls="invoice-list"><span>Add
                                    New</span>

                            </a>
                            <a class="mx-2 dt-button btn btn-primary btn-sm"
                                href="{{ route('customers.update_customer_credit') }}" tabindex="0"
                                aria-controls="invoice-list"><span>Refresh credit Scores</span>

                            </a>
                        </div>
                        <table id="zero-config" class="table dt-table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>First name</th>
                                    <th>Surname</th>
                                    <th>Username</th>
                                    <th>User Type</th>
                                    <th class="no-content">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    @if ($user->user_id != Auth::user()->user_id)
                                        <tr>
                                            <td>{{ $user->first_name }}</td>
                                            <td>{{ $user->surname }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->user_type }}</td>
                                            <td>

                                                <a id="edit-{{ $user->user_id }}" href="#" data-toggle="modal"
                                                    data-target="#editUser"
                                                    onclick="editUser({{ json_encode($user) }});return false;">Edit</a> |


                                                <form id="delete-form-{{ $user->user_id }}"
                                                    action="{{ route('customers.destroy', $user->user_id) }}"
                                                    style="display: none;" method="post">
                                                    {{ @csrf_field() }}
                                                    {{ @method_field('DELETE') }}
                                                </form>
                                                <a data-toggle="tooltip" href="#"
                                                    onclick="
                                                       if(confirm('Are you sure you want to disable this user?'))
                                                       {event.preventDefault();
                                                       document.getElementById('delete-form-{{ $user->user_id }}').submit();
                                                       }
                                                       else{
                                                       event.preventDefault();
                                                       }
                                                       ">Disable</a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>First name</th>
                                    <th>Surname</th>
                                    <th>Username</th>
                                    <th>User Type</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <!--  END CONTENT PART  -->

    <div id="editUser" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div class="card-title mb-3">Edit User</div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <form role="form" method="post"
                                    action="{{ route('customers.update.appUser', $user->user_id) }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="app_user_id" id="app_user_id">
                                    <div class="row">
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="user_type">User role</label>
                                            <select class="form-control" id="user_type" name="user_type"
                                                required="required">
                                                <option value="">Select role</option>
                                                <option value="SALES_REP">SALES REP</option>
                                                <option value="USER">USER</option>
                                            </select>
                                            @error('user_type')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 form-group mb-3">
                                            <label for="fname">First name</label>
                                            <input type="text" class="form-control" placeholder="First name"
                                                id="fname" name="fname" value="{{ old('fname') }}">
                                            @error('firstname')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 form-group mb-3">
                                            <label for="lname">Last name</label>
                                            <input type="text" class="form-control" placeholder="Surname" id="lname"
                                                name="lname" value="{{ old('lname') }}">
                                            @error('lname')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 form-group mb-3">
                                            <label for="email">Email address</label>
                                            <input type="email" class="form-control" placeholder="Email" id="email"
                                                name="email" value="{{ old('email') }}">
                                            @error('email')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 form-group mb-3">
                                            <label for="mobileno">Mobile</label>
                                            <input type="tel" class="form-control" placeholder="Mobile Number"
                                                id="mobileno" name="mobileno" value="{{ old('mobileno') }}">
                                            @error('mobileno')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 form-group mb-3">
                                            <label for="customerno">Customer number</label>
                                            <input type="text" class="form-control" id="customerno" name="customerno"
                                                placeholder="Customer Number" value="{{ old('customerno') }}">
                                            @error('customerno')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 form-group mb-3">
                                            <label for="pin">Pin</label>
                                            <input type="password" class="form-control" placeholder="Pin" id="pin"
                                                name="pin" value="{{ old('pin') }}">
                                            @error('pin')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>

                                    </br>

                                    <button type="submit" class="btn btn-block btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('footerSection')
    <script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>

    <script type="text/javascript">
        function editUser(user) {
            $("#app_user_id").val(user.user_id);
            $("#user_type").val(user.user_type);
            $('#fname').val(user.first_name);
            $('#lname').val(user.surname);
            $('#email').val(user.email);
            $('#mobileno').val(user.mobileno);
            $('#customerno').val(user.customer_no);
            $('#pin').val(user.pin);
        }
    </script>

    <script>
        $('#zero-config').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 7
        });
    </script>
@endsection
