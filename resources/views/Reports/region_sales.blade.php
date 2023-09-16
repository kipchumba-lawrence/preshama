@extends('layouts.app')
@section('meta')
    <title>Preshama - Reports</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/dt-global_style.css') }}">
    <link href="{{ asset('assets/css/apps/invoice-list.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page-action')
    <h3>Sales Reports</h3>
@endsection
@section('main-content')

    <!--  BEGIN CONTENT PART  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing" id="cancel-row">
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        @include('includes.messages')
                        <h4>Orders Per Region</h4>
                        @if (isset($rep))
                            @foreach ($rep as $sale_rep)
                                <h2>{{ $sale_rep->first_name }} {{ $sale_rep->last_name }} </h2>
                            @endforeach
                        @endif
                        <span>
                            <h6>Total Orders: {{ $orders->count() }}</h6>
                        </span>
                        <span>Regional Sales</span>
                        <div class="d-flex justify-content-end">
                            <form action="" method="POST">
                                @csrf
                                <select class="form-control" name="region" onchange="this.form.submit()"
                                    id="">
                                    <option value="null">Select Region</option>
                                    {{-- Brings the total list of orders --}}
                                    <option value="West">West</option>
                                    <option value="East">East</option>
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
                                        <th>Order id</th>
                                        <th>Customer</th>
                                        <th>C.M</th>
                                        <th>C.M Date approved</th>
                                        <th>O.M Date approved</th>
                                        <th>Collection mode</th>
                                        <th>Tracking number</th>
                                        <th>Order date</th>
                                        <th>Total cost</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>
                                                <div class="n-chk">
                                                    <label class="new-control new-checkbox checkbox-primary">
                                                        <input type="checkbox" class="new-control-input order"
                                                            name="orders[]" id="{{ $order->order_id }}"
                                                            value="{{ $order->order_id }}">
                                                    </label>
                                                </div>
                                            </td>
                                            <td><a href="#"><span
                                                        class="inv-number">{{ $order->order_id }}</span></a></td>
                                            <td>
                                                <small>{{ $order->customer_name }}
                                                    ({{ $order->customer_no }})
                                                </small>
                                            </td>
                                            <td>
                                                <small>{{ $order->credit_manager }} </small>
                                            </td>
                                            <td>
                                                <small>{{ date('d-M-Y', strtotime($order->credit_manager_approval_date)) }}
                                                </small>
                                            </td>
                                            <td>
                                                <small>{{ date('d-M-Y', strtotime($order->operations_manager_approval_date)) }}
                                                </small>
                                            </td>
                                            <td>
                                                <small>{{ $order->collection_mode }}</small>
                                            </td>
                                            <td><span class="inv-email">{{ $order->tracking_no }}</span></td>
                                            <td><span class="inv-date"><svg xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" class="feather feather-calendar">
                                                        <rect x="3" y="4" width="18" height="18"
                                                            rx="2" ry="2"></rect>
                                                        <line x1="16" y1="2" x2="16" y2="6">
                                                        </line>
                                                        <line x1="8" y1="2" x2="8" y2="6">
                                                        </line>
                                                        <line x1="3" y1="10" x2="21" y2="10">
                                                        </line>
                                                    </svg> {{ date('d-M-Y', strtotime($order->order_date)) }}</span></td>
                                            <td><span class="inv-amount">{{ $order->total_cost }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </form>
                        <div class="text-right px-2 py-2">
                        <a href="{{ route('export.orders') }}"><button class="btn btn-primary">Download Report</button></a>
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
