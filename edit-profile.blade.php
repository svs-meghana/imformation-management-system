@extends('layout')
@section('head')
<?php
    
    //echo $x;
    $data=DB::select("select * from cen_admin");
    //print_r($data);
   // print_r($data1);
   $data1=DB::select('select * from division');
?>
@endsection
@section('content')
<body  style='overflow:hidden;'>
<div class="bg-white  row justify-content-center ">
          <div class="card bg-secondary  shadow rmbs " style='border:none !important;'>
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0 display-4">My account</h3>
                </div>
               
              </div>
            </div>
            <div class="card-body">
              <form>
                <h6 class="heading-small text-muted mb-4">User information</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-username">Username</label>
                        <input type="text" id="input-username" class="form-control form-control-alternative" placeholder="Username" value="<?php echo $data[0]->{'name'}?> "readonly>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-email">Email address</label>
                        <input type="email" id="input-email" class="form-control form-control-alternative" placeholder="jesse@example.com" value="<?php echo $data[0]->{'email'}?> "readonly>
                      </div>
                    </div>
                  </div>
                  @foreach($data1 as $d1)
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-first-name">Division id</label>
                        <input type="text" id="input-first-name" class="form-control form-control-alternative" placeholder="First name" value="<?php  echo $d1->{'div_id'}?>"readonly>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-last-name">Division name</label>
                        <input type="text" id="input-last-name" class="form-control form-control-alternative" placeholder="Last name" value="<?php echo $d1->{'dname'}?> "readonly>
                      </div>
                    </div>
                  </div>
                
                @endforeach
               
                <div class="text-center">
                      <a href="{{URL::to('/home')}}" class="btn btn-primary my-3">Return</a>
                </div>
                </div>
              </form>
            </div>
          </div>
        </div>
@endsection