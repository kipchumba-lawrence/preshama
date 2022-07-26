
@extends('layouts.app')
@section('meta')
    <title>Preshama - Manage users</title>
    <link href="{{ asset('assets/css/elements/miscellaneous.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/elements/breadcrumb.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('page-action')
    <h3>Add customer</h3>
@endsection
@section('main-content')
    <!--  BEGIN CONTENT PART  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            <div class="account-settings-container layout-top-spacing">

                <div class="account-content">
                    <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                @include('includes.messages')
                                <form id="work-experience" class="section work-experience" method="post" action="{{ route('customers.store') }}">
                                    {{csrf_field()}}
                                    <div class="info">
                                        <h5 class="">Fill in customer details</h5>
                                        <div class="row">
                                            <div class="col-md-12 text-right mb-5">
                                                <a href="{{ route('customers.index') }}" id="add-work-exp" class="btn btn-secondary">Back</a>
                                            </div>
                                            <div class="col-md-8 mx-auto">

                                                <div class="work-section">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="degree2">Customer Name/s</label>
                                                                <input type="text" class="form-control mb-4" id="degree2" placeholder="Add company name or customer names" value="{{ old('name') }}" required="required" name="name">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="degree3">Customer number</label>
                                                                        <input type="text" class="form-control mb-4" id="degree3" placeholder="Customer number" value="{{ old('customer_number') }}" name="customer_number" required="required">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="degree4">Customer code</label>
                                                                        <input type="text" class="form-control mb-4" id="degree4" placeholder="Customer code" value="{{ old('customer_code') }}" name="customer_code">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="degree3">Email address</label>
                                                                        <input type="email" class="form-control mb-4" id="degree3" placeholder="Email address" value="{{ old('email') }}" name="email">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="degree4">Mobile</label>
                                                                        <input type="tel" class="form-control mb-4" id="degree4" placeholder="Mobile number" value="{{ old('mobile') }}" name="mobile">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Credit limit and credit exposure</label>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <input type="number" class="form-control mb-4" id="degree4" placeholder="Credit limit" value="{{ old('credit_limit') }}" name="credit_limit">
                                                                            </div>

                                                                            <div class="col-md-6">
                                                                                <input type="number" class="form-control mb-4" id="degree4" placeholder="Credit exposure" value="{{ old('credit_exposure') }}" name="credit_exposure">
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Sales manager and route</label>

                                                                        <div class="row">
                                                                            <div class="col-md-6 mb-4">
                                                                                <select class="form-control" id="eiend-in1" name="salesmanager" required="required" >
                                                                                    <option value="">Select sales rep</option>
                                                                                    @foreach($sales_managers as $sales_manager)
                                                                                        <option value="{{ $sales_manager->user_id }}">{{ $sales_manager->first_name }} {{ $sales_manager->surname }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>

                                                                            <div class="col-md-6">
                                                                                <select class="form-control" id="eiend-in1" name="route" required="required" >
                                                                                    <option value="">Select route...</option>
                                                                                    @foreach($routes as $route)
                                                                                        <option value="{{ $route->route_id }}">{{ $route->route_name }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn btn-primary mt-3">Save details</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--  END CONTENT PART  -->
@endsection

