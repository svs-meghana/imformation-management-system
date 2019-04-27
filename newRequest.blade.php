@extends('layout')
@section('content')
<div class="card bg-secondary  shadow rmbs " style='border:none !important;'>
<div class="card-header bg-white border-0">
          
<form action = "{{URL::to('/selectMails')}}" method="POST" enctype="multipart/form-data" role="form" >
<div class="form-group">
          <label class="form-control-label" for="req_content">Subject</label>
          <textarea class="form-control" name="req_content" id="req_content" rows="3" resize="none"></textarea>
      </div>
    <div class="form-group">
          <label class="form-control-label" for="req_content_body">Body</label>
          <textarea class="form-control" name="req_content_body" id="req_content_body" rows="3" resize="none"></textarea>
      </div>
      <div class="form-group">
          <label class="form-control-label" for="req_content">Required by</label>
          <textarea class="form-control" name="requester" id="requester" rows="3" resize="none"></textarea>
      </div>
      <div class="form-group">
          <label class="form-control-label" for="req_content_attachment">Attach File</label>
          <input type="file" class="btn btn-sm btn-primary" style="display:block;" name = "attachment" id= "attachment" />
      </div>
      <label class="form-control-label" for="req_content">Deadline</label>
     <div class="input-daterange datepicker row align-items-center">
      <div class="form-group">                                    
                  <div class="  row align-items-center">
                          <div class="col">
                              <div class="form-group">
                                  <div class="input-group input-group-alternative">
                                      <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                      </div>
                                      <input class="form-control datepicker" name="deadline" placeholder="Select date" type="datetime-local" >
                                  </div>
                              </div>
                          </div>
                  </div> 
                  </div>                          
      </div>
      
      <button type="submit" class="btn  btn-primary  btn-sm">Select Officers</button>
  </form>
</div>
</div>
@endsection