@extends('layout')
@section('content')
<div class="card bg-secondary  shadow rmbs " style="border:none !important;">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0 display-4">Select Concerned Officers </h3>
                </div>
               
              </div>
            </div>



            <div class="card-body">
              
            

<form action="{{URL::to('/addEmps')}}" method="post" enctype="multipart/form-data">
    
        
                
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-username">Request id:</label>
                        <input type="text" name="req_id" value="{{$req_info['req_id']}}" readonly class="form-control form-control-alternative">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-email-subject">Subject</label>
                        <input type="text" name="subject" value="{{$req_info['subject']}}" readonly class="form-control form-control-alternative" >
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-email-body">Body</label>
                        <input type="text" name="body" value="{{$req_info['body']}}" readonly class="form-control form-control-alternative" >
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="requester">Requested By</label>
                        <input type="text" name="requester" value="{{$req_info['requester']}}" readonly class="form-control form-control-alternative" >
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="attachment">Attachment</label>
                        <input type="text" name="attachment" value="{{$req_info['attachment']}}" readonly class="form-control form-control-alternative" >
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-first-name">deadline:</label>
                        <input type="text" name="deadline" value="{{$req_info['deadline']}}" readonly class="form-control form-control-alternative" >
                      </div>
                    </div>
                  </div>
                </div>
       
                <hr class="my-2">
                <!-- Description -->
                <h6 class="heading-small text-muted mb-4">Select Employee To Get Data</h6>
                
                <div class="pl-lg-4">
                  <div class="form-group focused">
                  <?php $c=0; ?>
    @foreach($div_emps as $e)
        <h6 class="heading-small text-muted "> {{$div_names[$c]}} </h6>
           @foreach($e as $emp)
           <div class="custom-control custom-control-alternative custom-checkbox">
                  <input class="custom-control-input" id=" customCheckLogin{{$emp[0]}}"  name="{{$div_names[$c]}}[]" value="{{$emp[0]}}" type="checkbox">
                  <label class="custom-control-label" for=" customCheckLogin{{$emp[0]}}">
                    <span class="text-muted">{{$emp[0]}} {{$emp[1]}}</span>
                  </label>
                </div>
            @endforeach
            <span class="md-4"></span>
        <?php $c++; ?>
    @endforeach
          </div>
                </div>
                <div class="text-center">

                <input type="submit" value="Forward" class="btn btn-primary my-3">
                </div>
              </form>
            </div>
</form>
</div>
</div>
@endsection