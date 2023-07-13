@extends('layouts.app')
@section('meta')
    <title>Preshama - Reports</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/dt-global_style.css') }}">
    <link href="{{ asset('assets/css/apps/invoice-list.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page-action')
    <h3>Allocation Reports</h3>
@endsection
@section('main-content')
    <!--  BEGIN CONTENT PART  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            <div class="row layout-top-spacing" id="cancel-row">

                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        @include('includes.messages')
                        <h4>Allocations Per Sales Representative</h4>
                        @if (isset($active_sales))
                            @foreach ($active_sales as $sales_representative)
                                <h2>{{ $sales_representative->first_name }} {{ $sales_representative->surname }} </h2>
                            @endforeach
                        @endif
                        <span>
                            <h6>Total Allocations: {{ $allocations->count() }}</h6>
                        </span>
                        <div class="d-flex justify-content-end">
                            <form action="" method="POST">
                                @csrf
                                <select class="form-control" name="sales_person" onchange="this.form.submit()"
                                    id="">
                                    <option value="null">Allocations Sales Person</option>
                                    Brings the total list of orders
                                    @foreach ($sales_rep as $rep)
                                        <option value="{{ $rep->user_id }}">{{ $rep->first_name }} {{ $rep->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                        <form action="" method="post">
                            {{ csrf_field() }}
                            <table id="zero-config" class="table table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" class="new-control-input selectall">
                                        </th>
                                        <th>Sales Person</th>
                                        <th>Material Name</th>
                                        <th>Allocation Date</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($allocations as $allocation)
                                        <tr>
                                            <td>
                                                <div class="n-chk">
                                                    <label class="new-control new-checkbox checkbox-primary">
                                                        <input type="checkbox" class="new-control-input order"
                                                            name="orders[]" id="{{ $allocation->allocation_id }}"
                                                            value="{{ $allocation->allocation_id }}">
                                                    </label>
                                                </div>
                                            </td>
                                            <td><a href="#"><span
                                                        class="inv-number">{{ $allocation->first_name }}</span></a></td>
                                            <td>
                                                <small>{{ $allocation->material_name }}</small>
                                            </td>
                                            <td>
                                                <small>{{ $allocation->allocation_date }} </small>
                                            </td>
                                            <td>
                                                <small>{{ $allocation->amount }}
                                                </small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </form>
                        <div class="text-right px-2 py-2">
                            <a href="{{ route('export.sales.allocations') }}"><button class="btn btn-primary">Download
                                    Report</button></a>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
    <!--  END CONTENT PART  -->
@endsection
@section('footerSection')
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
