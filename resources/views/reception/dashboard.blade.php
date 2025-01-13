@extends('reception.layout')
@section('title','Dashboard | Reception')
@extends('reception.header')
@section('content')

<div class="d-flex flex-column align-items-center mt-1">
  <div class="w-100 text-left">
    <h6>Welcome</h6>
  </div>
  <div class="text-center">
    <img src="{{ asset('images/logo-transparent.png') }}" 
      style="width: 100px; transform: scale(1.8);" alt="logo">
  </div>
</div>


    

    <style>
        .row-striped:nth-of-type(odd){
  background-color: #efefef;
  border-left: 4px #000000 solid;
  
}
img {
  display: block;
  margin: 0 auto;
}

.row-striped:nth-of-type(even){
  background-color: #ffffff;
  border-left: 4px #efefef solid;
}

.row-striped {
    padding: 15px 0;
}
    </style>

	<div class="container-fluid">
        
        <div class="row">
            <div class="col-md-8 col-lg-9 p-3">
                <div class="row gy-3">
                    {{-- Appointments --}}
                    <div class="col-md-6 col-lg-6">
                      <div class="card shadow-sm border-0">
                          <div class="card-body">
                              <h6 class="text-uppercase text-muted mb-4">Appointment Overview</h6>
                              <div class="d-flex justify-content-between align-items-center kontainer">

                                @if ($dashboard)
                                
                                  <div class="text-center">
                                    <span class="mb-1 text-primary fs-1">40</span>
                                      <p class="font-weight-bold">Total</p>
                                  </div>
                                  <div class="text-center">
                                    <span class="mb-1 text-success fs-1">40</span>
                                      <p class="font-weight-bold">On-going</p>
                                      
                                  </div>
                                  <div class="text-center">
                                    <span class="mb-1 text-warning fs-1">40</span>
                                      <p class="font-weight-bold">Pending</p>
                                      
                                  </div>
                                  <div class="text-center">
                                    <span class="mb-1 text-danger fs-1">40</span>
                                      <p class="font-weight-bold">Rejected</p>
                                      
                                  </div>
                                      
                                @else
                                <div
                                class="alert alert-danger w-100"
                                role="alert"
                              >
                                <strong>Error</strong> Fetching Details
                              </div>
                                @endif
                              </div>
                          </div>
                      </div>
                  </div>
                  

                  <div class="col-md-6 col-lg-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="text-uppercase text-muted mb-4">Payment Overview</h6>
                            <div class="d-flex justify-content-between align-items-center kontainer px-4">
                              @if ($dashboard)
                      
                                <div class="text-center">
                                  <span class="mb-1 text-success fs-1">40</span>
                                    <p class="font-weight-bold">Accepted</p>
                                    
                                </div>
                                <div class="text-center">
                                  <span class="mb-1 text-warning fs-1">40</span>
                                    <p class="font-weight-bold">Pending</p>
                                    
                                </div>
                                <div class="text-center">
                                  <span class="mb-1 text-danger fs-1">40</span>
                                    <p class="font-weight-bold">Rejected</p>
                                  
                                </div>
                                @else

                                <div
                                  class="alert alert-danger w-100"
                                  role="alert"
                                >
                                  <strong>Error</strong> Fetching Details
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            


        </div>
        <div class="row mt-4">
            <div class="col-md-12 col-lg-12">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="d-flex justify-content-between">
                    <h5>Today's Appointments</h5>
                    <a href="#">View all</a>
                  </div>
                  </div>
                  <div style="height: 400px; overflow-y: auto; overflow-x:hidden;">
                  @if($dashboard)
                  @foreach ($dashboard->appointments as $item)
                  <div class="row row-striped"> 
                    <div class="col-10"> 
                        <h5 class="text-uppercase"><strong>{{$item->appointment_title ?? 'Not Specified'}}</strong></h5> 
                        <ul class="list-inline"> 
                            <li class="list-inline-item"><i class="bi bi-calendar" aria-hidden="true"></i> {{Carbon\Carbon::parse($item->appointment_date)->format('l');}}</li> 
                            <li class="list-inline-item"><i class="bi bi-clock" aria-hidden="true"></i> {{$item->start_time}} - {{$item->end_time}}</li> 
                            <li class="list-inline-item"><i class="bi bi-activity" aria-hidden="true"></i> {{ucwords($item->status)}}</li> 
                        </ul> 
                        <div class="row">
                          <div class="d-flex justify-content-between align-content-center">
                            <h6>Actions</h6>
                            <div>
                            <button class="btn btn-dark">Start</button>
                            <button class="btn btn-dark">Reschedule</button>
                            <button class="btn btn-dark">cancel</button>
                          </div>
                          </div>
                        </div>
                    </div> 
                </div>
                @endforeach
                @else
                <div>
                  <div class="alert alert-danger">Error fetching Appointments</div>
                </div>
                @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
          <style>
            .row-striped:nth-of-type(odd){
              background-color: #efefef;
              border-left: 4px #000000 solid;
            }

            .row-striped:nth-of-type(even){
              background-color: #ffffff;
              border-left: 4px #efefef solid;
            }

            .row-striped {
                padding: 15px 0;
            }
          </style>

                </div>
           

            <!-- Sidebar -->
            <div class="col-md-5 col-lg-3 p-3">
                <div class="row">
                        <div class="d-flex justify-content-center">
                          <div class="calendar">
                            <div class="header">
                              <div class="month">July 2021</div>
                              <div class="btns">
                                <!-- today -->
                                <div class="btn today">
                                  <i class="fas fa-calendar-day"></i>
                                </div>
                                <!-- previous month -->
                                <div class="btn prev">
                                  <i class="fas fa-chevron-left"></i>
                                </div>
                                <!-- next month -->
                                <div class="btn next">
                                  <i class="fas fa-chevron-right"></i>
                                </div>
                              </div>
                            </div>
                            <div class="weekdays">
                              <div class="day">Sun</div>
                              <div class="day">Mon</div>
                              <div class="day">Tue</div>
                              <div class="day">Wed</div>
                              <div class="day">Thu</div>
                              <div class="day">Fri</div>
                              <div class="day">Sat</div>
                            </div>
                            <div class="days">
                              <!-- render days with js -->
                            </div>
                          </div>
                        <script src="{{asset('js/dashboard_calendar.js')}}"></script>
                            <style>
                              :root {
                                --primary-color: #f90a39;
                                --text-color: #FFFFFF;
                                --bg-color: #000000;
                              }
                              .calendar {
                                width: 100%;
                                max-width: 600px;
                                background: var(--bg-color);
                                padding: 30px 20px;
                                border-radius: 10px;
                              }
                              .calendar .header {
                                display: flex;
                                justify-content: space-between;
                                align-items: center;
                                margin-bottom: 20px;
                                padding-bottom: 20px;
                                border-bottom: 2px solid #ccc;
                              }
                              .calendar .header .month {
                                display: flex;
                                align-items: center;
                                font-size: 25px;
                                font-weight: 600;
                                color: var(--text-color);
                              }
                              .calendar .header .btns {
                                display: flex;
                                gap: 10px;
                              }
                              .calendar .header .btns .btn {
                                width: 50px;
                                height: 40px;
                                background: var(--primary-color);
                                display: flex;
                                justify-content: center;
                                align-items: center;
                                border-radius: 5px;
                                color: #fff;
                                font-size: 16px;
                                cursor: pointer;
                                transition: all 0.3s;
                              }
                              .calendar .header .btns .btn:hover {
                                background: #db0933;
                                transform: scale(1.05);
                              }
                              .calendar .weekdays {
                                display: flex;
                                gap: 10px;
                                color: var(--text-color);
                                margin-bottom: 10px;
                              }
                              .calendar .weekdays .day {
                                width: calc(100% / 7 - 10px);
                                text-align: center;
                                font-size: 16px;
                                font-weight: 600;
                              }
                              .calendar .days {
                                display: flex;
                                flex-wrap: wrap;
                                gap: 10px;
                              }
                              .calendar .days .day {
                                width: calc(100% / 7 - 10px);
                                height: 50px;
                                background: #000000;
                                display: flex;
                                justify-content: center;
                                align-items: center;
                                border-radius: 5px;
                                font-size: 16px;
                                font-weight: 400;
                                color: var(--text-color);
                                transition: all 0.3s;
                                user-select: none;
                              }
                              .calendar .days .day:not(.next):not(.prev):hover {
                                color: #fff;
                                background: var(--primary-color);
                                transform: scale(1.05);
                              }
                              .calendar .days .day.next,
                              .calendar .days .day.prev {
                                color: #ccc;
                              }
                              .calendar .days .day.today {
                                color: #fff;
                                background: var(--primary-color);
                                font-size: 16px;
                                font-weight: 700;
                              }
                            </style>
                          
                        </div>
                      
                </div>
                <div class="row mt-4">
                  <div class="card">
                    <div class="card-body">
                      <h6>Available Doctors</h6>

                      <ul class="list-group">
                        @forelse ($dashboard->activeUsers as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                              <div>
                                <span class="text-success">•</span>
                               {{ ($item->fullname->last_name ?? '').' '.($item->fullname->first_name ?? '') }}
                              </div>
                            </li>
                        @empty
                            <div>Error fetching Doctor Details</div>
                        @endforelse
                      </ul>
                    </div>
                  </div>
                </div>
            </div>
    </div>
        </div>   
    
@endsection