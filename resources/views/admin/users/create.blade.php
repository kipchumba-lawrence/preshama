@extends('layouts.app')
@section('meta')
    <title>Preshama - Manage users</title>
    <link href="{{ asset('assets/css/elements/miscellaneous.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/elements/breadcrumb.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/apps/invoice-list.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('page-action')
    <h3>Create system users</h3>
@endsection
@section('main-content')
    <!--  BEGIN CONTENT PART  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            <div class="row layout-top-spacing" id="cancel-row">

                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <div class="breadcrumb-four">
                            <ul class="breadcrumb" style="margin-bottom: 20px;">
                                <li><a href="{{ route('home') }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a>
                                <li class="active"><a href="{{ route('home') }}"><span>Users</span></a></li>
                                <li><a href="javscript:void(0);"><span>Create user</span></a></li>
                            </ul>
                        </div>
                        <h5>Fill in all fields</h5>
                        @include('includes.messages')
                        <form method="post" action="{{ route('users.store') }}">
                            {{csrf_field()}}
                            <div class="form-row mb-4">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">First name</label>
                                    <input type="text" class="form-control" id="inputEmail4" placeholder="First name" name="firstname" value="{{ old('firstname') }}" required="required">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">Second name</label>
                                    <input type="text" class="form-control" id="inputPassword4" placeholder="Second name" name="secondname" value="{{ old('secondname') }}" required="required">
                                </div>
                            </div>
                            <div class="form-row mb-4">
                                <div class="form-group col-md-6">
                                    <label for="inputAddress">Email</label>
                                    <input type="email" class="form-control" id="inputAddress" placeholder="name@example.com" name="email" value="{{ old('email') }}" required="required">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputState">Role</label>
                                    <select id="inputState" class="form-control" required="required" name="role">
                                        <option selected value="">Select role</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->user_role }}">{{ $role->user_role }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="inputAddress2">Temporary password</label>
                                <input type="text" class="form-control" id="inputAddress2" placeholder="Temporary password" name="password" value="{{ old('password') }}" required="required">
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Save user</button>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <!--  END CONTENT PART  -->
@endsection

