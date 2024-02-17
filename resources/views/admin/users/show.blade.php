@extends('layouts.app')
@section('meta')
    <title>Preshama - Manage users</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/dt-global_style.css') }}">
    <link href="{{ asset('assets/css/apps/invoice-list.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page-action')
    <h3>Manage system users</h3>
@endsection
@section('main-content')
    <!--  BEGIN CONTENT PART  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            <div class="row layout-top-spacing" id="cancel-row">

                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        @include('includes.messages')
                        <div class="dt-buttons"><a class="dt-button btn btn-primary btn-sm"
                                href="{{ route('users.create') }}" tabindex="0" aria-controls="invoice-list"><span>Add
                                    New</span></a> </div>
                        <table id="zero-config" class="table dt-table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>First name</th>
                                    <th>Surname</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th class="no-content">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    @if ($user->user_id != Auth::user()->user_id)
                                        <tr>
                                            <td>{{ $user->first_name }}</td>
                                            <td>{{ $user->surname }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->user_type }}</td>
                                            <td>
                                                <a id="edit-{{ $user->user_id }}" href="#" data-toggle="modal"
                                                    data-target="#editUser"
                                                    onclick="editUser({{ json_encode($user) }});return false;">Edit</a>
                                                <form id="delete-form-{{ $user->user_id }}"
                                                    action="{{ route('users.destroy', $user->user_id) }}"
                                                    style="display: none;" method="post">
                                                    {{ @csrf_field() }}
                                                    {{ @method_field('DELETE') }}
                                                </form>
                                                <a data-toggle="tooltip"
                                                    onclick="
                                                       if(confirm('Are you sure you want to delete this user?'))
                                                       {event.preventDefault();
                                                       document.getElementById('delete-form-{{ $user->user_id }}').submit();
                                                       }
                                                       else{
                                                       event.preventDefault();
                                                       }
                                                       ">Delete</a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>First name</th>
                                    <th>Surname</th>
                                    <th>Email</th>
                                    <th>Role</th>
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
                                    action="{{ route('users.update.user', $user->user_id) }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="user_id" id="user_id">
                                    <div class="form-row mb-4">
                                        <div class="form-group col-md-6">
                                            <label for="firstname">First name</label>
                                            <input type="text" class="form-control" placeholder="First name"
                                                name="firstname" id="firstname" value="{{ old('firstname') }}"
                                                required="required">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="secondname">Second name</label>
                                            <input type="text" class="form-control" placeholder="Second name"
                                                name="secondname" id="secondname" value="{{ old('secondname') }}"
                                                required="required">
                                        </div>
                                    </div>
                                    <div class="form-row mb-4">
                                        <div class="form-group col-md-6">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" placeholder="name@example.com"
                                                name="email" id="email" value="{{ old('email') }}"
                                                required="required">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="role">Role</label>
                                            <select class="form-control" required="required" name="role" id="role">
                                                <option selected value="">Select role</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->user_role }}">{{ $role->user_role }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label for="password">Temporary password</label>
                                        <input type="password" class="form-control" placeholder="Temporary password"
                                            name="password" id="password" value="{{ old('password') }}"
                                            required="required">
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
    <script type="text/javascript">
        function editUser(user) {
            //alert(user.first_name);
            $("#user_id").val(user.user_id);
            $("#role").val(user.user_type);
            $('#firstname').val(user.first_name);
            $('#secondname').val(user.surname);
            $('#email').val(user.email);
        }
    </script>

    <script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>
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
