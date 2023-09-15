@extends('layouts.app')
@section('meta')
    <title>Preshama - materials </title>
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/dt-global_style.css')}}">

    {{--    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/theme-checkbox-radio.css')}}">--}}
@endsection
@section('page-action')
    <h3>Procurement Officer -perform allocations ({{ $materials->count() }})</h3>
@endsection
@section('main-content')
    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">

                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        @include('includes.messages')
                        <form action="{{ route('procurementOfficerAllocate') }}" method="post">
                            {{csrf_field()}}
                            <div class="form-inline" style="padding-left: 18px;">
                                <select name="user"  class="form-control form-control-sm" required="required">
                                    <option value="">Select sales man</option>
                                    @foreach($salesmen as $salesman)
                                        <option value="{{ $salesman->user_id }}">
                                            {{ $salesman->first_name }} {{ $salesman->surname }}
                                        </option>
                                        @endforeach
                                </select>
                                <button class="dt-button btn btn-primary " style="margin-left:10px;" tabindex="0" aria-controls="invoice-list" type="submit"><span>Allocate</span></button>
                            </div>
                            <table id="zero-config" class="table table-hover" style="width:100%">
                                <thead>
                                <tr>
                                    <th>
{{--                                        <input type="checkbox" class="new-control-input selectall">--}}
                                    </th>
                                   
                                    <th>Amount</th>
                                    <th>M. id</th>
                                    <th>Material</th>
                                    <th>Number</th>
                                    <th>Company code</th>
                                    <th>Uom</th>
                                    <th>Standard price</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($materials as $material)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="material" name="materials[]" data-id="{{ $material->material_id }}" value="{{ $material->material_id }}">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm amount" name="amounts[]" data-id="{{ $material->material_id }}" id="material-{{ $material->material_id }}" placeholder="amount" disabled>
                                        </td>
                                         <td>
                                            {{ $material->material_id }}
                                        </td>
                                        <td><a href="#"><span class="inv-number">{{ $material->material_name }}</span></a></td>
                                        <td>
                                            {{ $material->material_no }}
                                        </td>
                                        <td>
                                            {{ $material->company_code }}
                                        </td>
                                        <td>
                                            {{ $material->uom }}
                                        </td>
                                        <td><span class="inv-amount">{{ $material->standard_price }}</span></td>
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--  END CONTENT AREA  -->
@endsection
@section('footerSection')
    <script src="{{ asset('plugins/table/datatable/datatables.js')}}"></script>
    <script>
        // Enable quantity field if product is selected
        $("input[name='amount']").prop('disabled', true);

        $(".material").on('click', function() {
            // Get reference to the text field in the same row with the name "quantity"
            let id = $(this).attr('data-id');
            var $next = $(this).closest('tr').find('#material-'+id);

            // Enable the text field if the checkbox is checked, disable it if it is unchecked
            $next.prop('disabled', ! $(this).is(':checked'));
            $next.prop('required',  $(this).is(':checked'));
            $next.val(null, ! $(this).is(':checked'));
        });

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
