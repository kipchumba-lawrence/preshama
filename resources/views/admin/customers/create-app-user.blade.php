

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
                                        <h5 class="">Fill Sales Rep details</h5>
                                        <div class="row">
                                            
                                            <div class="col-md-8 mx-auto">

                                                <div class="work-section">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <input type="hidden" name="user_type" value="SALES_REP">
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="degree3">First name</label>
                                                                        <input type="text" class="form-control mb-4" id="degree3" placeholder="First name" value="{{ old('firstname') }}" name="fname" required="required">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="degree4">Last name</label>
                                                                        <input type="text" class="form-control mb-4" id="degree4" placeholder="Surname" value="{{ old('lastname') }}" name="lname" required="required">
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
                                                                        <input type="tel" class="form-control mb-4" id="degree4" placeholder="Mobile number" value="{{ old('mobile') }}" name="mobileno">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                        <label for="degree4">Pin</label>
                                                        <input type="password" class="form-control mb-4" id="degree4" placeholder="Pin" name="pin" required="required" maxlength="5">
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

