@extends('youth/layouts/app')
@section('meta')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="case listing">
    <meta name="author" content="CODEI SYSTEMS">

    <title>MARVOCO | youth registration form</title>

@endsection
@section('main-content')

    <main>

        <div class="row justify-content-center">
            <div class="col-lg-8" style="margin-top:100px;">
                <div id="message-contact"></div>

                @include('includes.messages')
                <a href="#" class="btn_support">Fill in this registration form to submit details !Note you can only register</a>
                <div id="message-support"></div>
                <form method="post" action="{{ route('save') }}" enctype="multipart/form-data" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group required">
                            <label for="title">Names<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="title" name="names" placeholder="Enter full names" required="required" value="{{ old('names') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group required">
                            <label for="title">Gender<span class="text-danger">*</span></label>
                                        <select name="gender" id="gender" class="form-control" required="required">
                                            <option value="">Select gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                            </div>
                        </div>
                    </div>
                    <!-- /row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group required">
                            <label for="subtitle">Identification number<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="subtitle" name="identification" placeholder="Enter identification or passport" required="required" value="{{ old('identification') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group required">
                            <label for="subtitle">Date of birth<span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="subtitle" name="dob" placeholder="Enter date of birth" required="required" value="{{ old('dob') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group required">
                            <label for="subtitle">Mobile<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="subtitle" name="mobile" placeholder="Enter mobile number" required="required" value="{{ old('mobile') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="subtitle">Email<span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="subtitle" name="email" placeholder="Enter email" required="required" value="{{ old('email') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="title">Ward<span class="text-danger">*</span></label>
                                        <select name="ward" id="ward" class="form-control" required="required">
                                            <option value="">Select ward</option>
                                            @foreach($wards as $ward)
                                                <option value="{{ $ward->name }}">{{ $ward->name }}</option>
                                                @endforeach
                                        </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="subtitle">Physical address<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="subtitle" name="physical_address" placeholder="Enter physical address" required="required" value="{{ old('physical_address') }}">
                            </div>
                        </div>
                    </div>
                    <!-- /row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="drug">Health condition</label>
                                        <textarea name="health" id="health" cols="30" rows="3"
                                                  class="form-control" placeholder="Please type in any health issues that have been faced">
                                            {{ old('health') }}
                                        </textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="drug">Drug abuse history</label>
                                        <textarea name="drugs" id="drugs" cols="30" rows="3"
                                                  class="form-control" placeholder="List of drugs used and if still using">
                                            {{ old('drugs') }}
                                        </textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group required">
                            <label for="subtitle">Next of kin names<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="subtitle" name="next_of_kin_names" placeholder="Enter full names of next of kin" required="required" value="{{ old('next_of_kin_names') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group required">
                            <label for="subtitle">Next of kin relationship<span class="text-danger">*</span></label>
                                        <select name="next_of_kin_relationship" id="next_of_kin_relationship"
                                                class="form-control" required="required">
                                            <option value="">Select relation</option>
                                            <option value="Mother">Mother</option>
                                            <option value="Father">Father</option>
                                            <option value="Wife">Wife</option>
                                            <option value="Husband">Husband</option>
                                            <option value="Brother">Brother</option>
                                            <option value="Sister">Sister</option>
                                            <option value="Son">Son</option>
                                            <option value="Daughter">Daughter</option>
                                            <option value="Cousin">Cousin</option>
                                            <option value="Nephew">Nephew</option>
                                            <option value="Niece">Niece</option>
                                            <option value="Uncle">Uncle</option>
                                            <option value="Aunt">Aunt</option>
                                            <option value="Grandmother">Grandmother</option>
                                            <option value="Grandfather">Grandfather</option>
                                            <option value="Granddaughter">Granddaughter</option>
                                            <option value="Grandson">Grandson</option>
                                            <option value="Friend">Friend</option>
                                            <option value="House help">House help</option>
                                        </select>
                            </div>
                        </div>
                    </div>
                    

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="subtitle">Next of kin contacts<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="subtitle" name="next_of_kin_contacts" placeholder="Enter mobile or email of next of kin" required="required" value="{{ old('next_of_kin_contacts') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="subtitle">Upload resume (pdf)<span class="text-danger">*</span></label>
                            <div class="fileupload"><input type="file" class="form-control"  name="resume" accept="application/pdf" required="required"></div>
                             
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group add_top_30 text-center">
                        <input type="submit" value="Submit" class="btn_1 rounded" id="submit-contact">
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
    
@endsection


