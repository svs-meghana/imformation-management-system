@extends('layout')
@section('head')
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<title> HOME </title>

@endsection
@section('content')

  </div>
  <div class="main-content">
        <!-- Top navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
          <div class="container-fluid">
              <!-- Brand -->
              <a class="display-3 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="#">Information Management
                  System</a>
            
              <!-- User -->
              <ul class="navbar-nav align-items-center d-none d-md-flex">
                  <li class="nav-item dropdown">
                      <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                          aria-expanded="false">
                          <div class="media align-items-center">
                              
                              <div class="media-body ml-2 d-none d-lg-block">
                                  <span class="mb-0 text-lg font-weight-bold">My Account</span>
                              </div>
                          </div>
                      </a>
                      <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                          <div class=" dropdown-header noti-title">
                              <h6 class="text-overflow m-0">Welcome!</h6>
                          </div>
                          <a href="{{URL::to('/profile')}}" class="dropdown-item">
                              <i class="ni ni-single-02"></i>
                              <span>My profile</span>
                          
                          </a>
                          <div class="dropdown-divider"></div>
                          <a href="{{URL::to('/logout')}}" class="dropdown-item">
                              <i class="ni ni-user-run"></i>
                              <span>Logout</span>
                          </a>
                      </div>
                  </li>
              </ul>
          </div>
      </nav>
      <!-- Header -->
      <div class="header bg-primary pb-6 pt-4 pt-md-8">
          <div class="container-fluid">
              <div class="header-body">
                  <!-- Card stats -->
                  <div class="row">
  
  
  
  
                  </div>
              </div>
          </div>
      </div>
      <!-- Page content -->
      <div class="container-fluid mt--7 p-lg-5">
          <div class="row">
              <div class="col-xl-8 mb-5 mb-xl-0">
                  <div class="card bg-white shadow">
                                  <div class="card-header  bg-transparent">
                            <div class="row align-content-center">
                                <div class="col ">
                                 <!--<h1 class="navbar-brand  text-primary text-center">Make Request </h1>-->
                                </div>
                            </div>
                        </div>
                      <div class="card-body">
                          <div class="" >
                              <div class="card-body">
                                  <div class="tab-content" id="myTabContent">
                                  
                                      <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel"
                                          aria-labelledby="tabs-icons-text-1-tab">
                                          @if(isset($home_data))
                                            <p class='h4'>{{$home_data}}</p>
                                          @endif
                                          <table>
                                          @if(isset($view_files))
                                            <h1 class='h2'> VIEW FILES </h1>
                                            <td colspan='4' class='row'><hr></td>
                                            <tr class="row ">
                                                <td class='col-3'>req_id</td>
                                                <td class='col-3'> mail </td>
                                                <td class='col-3'> seen</td>
                                                <td class='col-3'> content </td>
                                            </tr>
                                            <td colspan='4' class='row'><hr></td>
                                            @foreach($view_files as $d)
                                            <tr class="row">
                                                <td class='col-3'> {{$d->req_id}} </td>
                                                <td class='col-3'> {{$d->to_mail}} </td>
                                                <td class='col-3'> {{$d->has_seen}} </td>
                                                <td class='col-3'> {{$d->rep_content}} </td>
                                                
                                            </tr>
                                            <td colspan='4' class='row'><hr></td>
                                            @endforeach
                                            <form action="{{URL::to('/download_files')}}" method='post'>
                                                <input type='hidden' name='req_id1' value='{{$d->req_id}}'>
                                                <td rowspan='3' ><input type='submit' class="btn btn-sm btn-primary" value='click here to download'></tr>
                                                </form>
                                          @endif
                                            
                                            @if( isset($completed)) 
                                            <title> RESPONSES </title>               
                                            <h1 class="navbar-brand  text-primary text-center"> Completed Requests</h1>
                                            <table class="my-3">
                                            @foreach($completed as $d)
                                                <tr class="row">
                                                <td class="col-3"> {{$d->req_id}} </td>
                                                <td class="col-3">{{$d->req_by}}</td>
                                                <td class="col-3"> {{$d->description}} </td>
                                                <!--<td><a href="{{URL::to('/view_files')}}">click here to view</a></td>-->
                                                <form action="{{URL::to('/view_files')}}" method='post'>
                                                    <input type='hidden' name='req_id' value='{{$d->req_id}}'>
                                                    <td class="col-3"><input type='submit' class="btn btn-sm btn-primary" value='click here to view'></td>
                                                </form>
                                                </tr> 
                                                <td colspan='4' class='row' ><hr></td>
                                            @endforeach
                                            </table >
                                            <h1 class="navbar-brand  text-primary text-center"> Incomplete Requests</h1>
                                            <table class="my-3">
                                            @foreach($incompleted as $d)
                                                <tr class="row">
                                                <td class="col-3"> {{$d->req_id}} </td>
                                                <td class="col-3">{{$d->req_by}}</td>
                                                <td class="col-3"> {{$d->description}} </td>
                                                <!--<td><a href="{{URL::to('/view_files')}}">click here to view</a></td>-->
                                                <form action="{{URL::to('/view_files')}}" method='post'>
                                                <input type='hidden' name='req_id' value='{{$d->req_id}}'>
                                               <td class="col-3"> <input type='submit' class="btn btn-sm btn-primary" value='click here to view'> </td>
                                                </form>
                                                
                                            </tr>
                                            <td colspan='5' class='row'><hr></td>
                                            @endforeach

                                            </table>
                                        @endif
                                        </table>
                                      </div>

                                        @if(isset($reqs))
                                        <title> HISTORY </title>
                                            <table>
                                                <tr class="row">
                                                    <th class="col-2"> Request_id </th>
                                                    <th class="col-3"> Requested_by </th>
                                                    <th class="col-3"> Description </th>
                                                    <th class="col-2"> Deadline </th>
                                                    <th class="col-2"> Completed </th>
                                                </tr>
                                                <td colspan='4'><hr></td>
                                                @if(!empty($reqs))
                                                    @foreach($reqs as $req)
                                                        <tr class="row">
                                                            <td class="col-2"> {{$req['req_id']}} </td>
                                                            <td class="col-3"> {{$req['req_by']}} </td>
                                                            <td class="col-3"> {{$req['description']}} </td>
                                                            <td class="col-2"> {{$req['deadline']}} </td>
                                                            <td class="col-2"> {{$req['completed']}} </td>
                                                        </tr>
                                                        <td colspan='4'><hr></td>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td> - </td>
                                                        <td> - </td>
                                                        <td> - </td>
                                                        <td> - </td>
                                                        <td> - </td>
                                                    </tr>
                                                @endif
                                            </table>
                                        @endif

                                        @if(isset($statistics))
                                        
                                        <div class="row">
                                           
                                           
                                        <div class="col-lg-4">
                                            <button type="button" class="btn btn-warning">
                                            <span>Received Responses</span>
                                            <span class="badge badge-white h5 text-danger">{{$statistics['Responses_Received']}}</span>
                                            </button>
                                            </div>
                                            <div class="col-lg-4">
                                            <button type="button" class="btn btn-warning">
                                            <span>Incomplete Requests</span>
                                            <span class="badge badge-white">{{$statistics['Completed_Requests']}}</span>
                                            </button>
                                            </div>
                                            
                                            <div class="col-lg-4">
                                            <button type="button" class="btn btn-warning">
                                            <span>Completed requests</span>
                                            <span class="badge badge-white">{{$statistics['Pending_Requests']}}</span>
                                            </button>
                                            </div>
                                           
                                           
                                            
                                            
                                            </div><hr class="my-4 bg-white">
                                            <div class="row">
                                           
                                           
                                           
                                            <div class="col-lg-4">
                                            <button type="button" class="btn btn-default">
                                            <span>Expected Responses</span>
                                            <span class="badge badge-white">{{$statistics['Total_Responses']}}</span>
                                            </button>
                                            </div>
                                            
                                            
                                           
                                            <div class="col-lg-4">
                                            <button type="button" class="btn btn-default">
                                            <span>Total Requests</span>
                                            <span class="badge badge-white">{{$statistics['Total_Requests']}}</span>
                                            </button>
                                            </div>
                                           
                                            <div class="col-lg-4">
                                            <button type="button" class="btn btn-default">
                                            <span>Total Requests</span>
                                            <span class="badge badge-white">{{$statistics['Total_Requests']}}</span>
                                            </button>
                                            </div>
                                           
                                            </div>
                                        @endif
                                        </table>
                                            

                                      <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel"
                                          aria-labelledby="tabs-icons-text-2-tab">
                                        
                                      </div>
                                      <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel"
                                          aria-labelledby="tabs-icons-text-3-tab">
                                          <h1 class="navbar-brand  text-primary text-center"> Responses </h1>
                                          
                                      </div>
  
                                      <div class="tab-pane fade" id="tabs-icons-text-4" role="tabpanel"
                                          aria-labelledby="tabs-icons-text-4-tab">
                                            <h1 class="navbar-brand  text-primary text-center"> Requested Queries </h1>
                                            
                                      </div>
  
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-xl-4">
                    <div class="card shadow">
                        <div class="card-header  bg-transparent">
                            <div class="row align-content-center">
                                <div class="col ">
                                 <h1 class="navbar-brand  text-primary text-center">Welcome </h1>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
    
                           
                            <div class="justify-content-center ">
                                <div class="nav-wrapper">
                                    <ul class="nav nav-pills nav-fill flex-column " id="tabs-icons-text" role="tablist">
                                    <li class="nav-item">
                                            <a id="tabs-icons-text-2-tab" data-toggle="tab"
                                                href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-3"
                                                aria-selected="false"><a href="{{URL::to('/home')}}" class="nav-link mb-sm-3 rmbs "><i
                                                    class="ni ni-calendar-grid-58 mr-2" onclick="fetch_inrequest"></i>Home</a>
                                        </li>   
                                    <li class="nav-item">
                                            <a id="tabs-icons-text-2-tab" data-toggle="tab"
                                                href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-3"
                                                aria-selected="false"><a href="{{URL::to('/statistics')}}" class="nav-link mb-sm-3 rmbs "><i
                                                    class="ni ni-calendar-grid-58 mr-2" onclick="fetch_inrequest"></i>Statistics</a>
                                        </li>   
                                    <li class="nav-item">
                                            <a  id="tabs-icons-text-1-tab"
                                                data-toggle="tab" href="#tabs-icons-text-1" role="tab"
                                                aria-controls="tabs-icons-text-1" aria-selected="true"><a href="{{URL::to('/newRequest')}}" class="nav-link mb-sm-3 rmbs "><i
                                                    class="ni ni-ruler-pencil mr-2"></i>New Request</a>
                                        </li>
                                        
                                        
                                         <li class="nav-item">
                                            <a  id="tabs-icons-text-3-tab" data-toggle="tab"
                                                href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-2"
                                                aria-selected="false"><a href="{{URL::to('/responses')}}" class="nav-link mb-sm-3 rmbs "><i class="ni ni-bell-55 mr-2"></i>Response</a></a>
                                        </li>
                                        <li class="nav-item">
                                        <a  id="tabs-icons-text-4-tab" data-toggle="tab"
                                                 role="tab" aria-controls="tabs-icons-text-3"
                                                aria-selected="false"><a href="{{URL::to('/history')}}" class="nav-link mb-sm-3 rmbs" 
                                                 >
                                        <i class="ni ni-calendar-grid-58 mr-2"></i>History</a></a>
                                        </li>
                                        <li class="nav-item">
                                        <a  id="tabs-icons-text-4-tab" data-toggle="tab"
                                                 role="tab" aria-controls="tabs-icons-text-3"
                                                aria-selected="false"><a href="{{URL::to('/refresh')}}" class="nav-link mb-sm-3 rmbs" 
                                                 >
                                        <i class="ni ni-calendar-grid-58 mr-2"></i>Refresh</a></a>
                                        </li>
                                        <li class="nav-item d-none">
                                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab"
                                                href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2"
                                                aria-selected="false"><i class="ni ni-bell-55 mr-2"></i>Profile</a>
                                        </li>
    
                                    </ul>
                                </div>
    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
    
    
          </div>



          