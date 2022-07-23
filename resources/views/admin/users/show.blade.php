@extends('layouts.app')
    @section('meta')
        <title>Preshama - Manage users</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/dt-global_style.css')}}">
        <link href="{{ asset('assets/css/apps/invoice-list.css')}}" rel="stylesheet" type="text/css" />
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
                            <div class="dt-buttons"><a class="dt-button btn btn-primary btn-sm"  href="{{ route('users.create') }}" tabindex="0" aria-controls="invoice-list"><span>Add New</span></a> </div>
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
                                @foreach($users as $user)
                                    @if($user->id != Auth::user()->id)
                                        <tr>
                                            <td>{{ $user->first_name }}</td>
                                            <td>{{ $user->surname }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->user_type }}</td>
                                            <td>
                                                <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy',$user->id) }}" style="display: none;" method="post">
                                                    {{@csrf_field()}}
                                                    {{@method_field('DELETE')}}
                                                </form>
                                                <a data-toggle="tooltip"
                                                   onclick="
                                                       if(confirm('Are you sure you want to delete this user?'))
                                                       {event.preventDefault();
                                                       document.getElementById('delete-form-{{ $user->id }}').submit();
                                                       }
                                                       else{
                                                       event.preventDefault();
                                                       }
                                                       "
                                                ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle table-cancel"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></a></td>
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
    @endsection
    @section('footerSection')
        <script src="{{ asset('plugins/table/datatable/datatables.js')}}"></script>
        <script>
            $('#zero-config').DataTable({
                "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                    "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                "oLanguage": {
                    "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
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
