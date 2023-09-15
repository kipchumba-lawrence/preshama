@extends('layouts.app')
@section('meta')
    <title>Preshama - materials </title>
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/dt-global_style.css')}}">

    {{--    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/theme-checkbox-radio.css')}}">--}}
@endsection
@section('page-action')
    <h3>Procurement Officer - Allocated orders ({{ $materials->count() }})</h3>
@endsection
@section('main-content')
    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">

                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        @include('includes.messages')

                            <table id="zero-config" class="table table-hover" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Allocation date</th>
                                    <th>Material</th>
                                    <th>Material Number</th>
                                    <th>Assigned to</th>
                                    <th>Amount</th>
                                    <th>Company code</th>
                                    <th>Uom</th>
                                    <th>Standard price</th>
                                    <th class="no-content">Actions</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($materials as $material)
                                    <tr>
                                        <td>
                                            {{ $material->allocation_date }}
                                        </td>
                                        <td><a href="#"><span class="inv-number">{{ $material->material_name }}</span></a></td>
                                        <td>
                                            {{ $material->material_no }}
                                        </td>
                                        <td>
                                            {{ $material->firstname }} {{ $material->surname }}
                                        </td>
                                        <td>
                                            {{ $material->amount }}
                                        </td>
                                        <td>
                                            {{ $material->company_code }}
                                        </td>
                                        <td>
                                            {{ $material->uom }}
                                        </td>
                                        <td><span class="inv-amount">{{ $material->standard_price }}</span></td>
                                        <td>
                                            <form id="delete-form-{{ $material->allocation_id }}" action="{{ route('deleteAllocation',$material->allocation_id) }}" style="display: none;" method="post">
                                                {{@csrf_field()}}
                                                {{@method_field('delete')}}
                                            </form>
                                            <a data-toggle="tooltip"
                                               onclick="
                                                   if(confirm('Are you sure you want to delete this allocation?'))
                                                   {event.preventDefault();
                                                   document.getElementById('delete-form-{{ $material->allocation_id }}').submit();
                                                   }
                                                   else{
                                                   event.preventDefault();
                                                   }
                                                   "
                                            ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle table-cancel"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></a></td>
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

        // $('.selectall').click(function() {
        //     if ($(this).is(':checked')) {
        //         $('.material').attr('checked', true);
        //     } else {
        //         $('.material').attr('checked', false);
        //     }
        // });
        $('document').ready(function (){
            $('.material').on('click', function () {
                let id = $(this).attr('data-id');
                let enabled = $(this).is(":checked")
                $('.amount[data-id="' + id + '"]').attr('disabled', !enabled);
                $('.amount[data-id="' + id + '"]').attr('required',enabled);
                $('.amount[data-id="' + id + '"]').val(null);

            });

            $('.selectall').on('click', function () {

                let enabled = $(this).is(":checked")

                $('.amount').attr('disabled', !enabled);

                $('.amount').val(null);
                if(enabled){
                    $('.material').attr('checked', true);
                    $('.amount').attr('required',enabled);
                }
                else{
                    $('.material').attr('checked', false);
                }
            });
        });
    </script>
    {{--    <script src="{{ asset('assets/js/apps/invoice-list.js')}}"></script>--}}
@endsection
