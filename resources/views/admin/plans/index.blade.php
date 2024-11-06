@extends('layouts.new_main')
@section('content')
<div class="dashbord-inner">
@if(Session::has('success'))
                <div class="alert alert-success" style="color:white">{{Session::get('success')}}</div>
            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger" style="color:white">{{Session::get('error')}}</div>
            @endif
<div class="manage-comp mb-4">
  <div class="Filters-main mb-3 mb-md-4">
      <div class="sec1-style">
          <div class="tabele_filter">
              <div class="tabFilt_left">
                  <!-- Show Filter -->
                  <div class="sd-filter">
                      <span class="filter-text">Show</span>
                      <span class="d-sel">
                          <select class="form-select" aria-label="Default select example">
                              <option selected="">1</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                          </select>
                      </span>
                  </div>
                  <!-- Sort By Filter -->
                  <div class="sd2-filter">
                      <span class="filter-text">Entries</span>
                      <span class="d-sel">
                          <select class="form-select" aria-label="Default select example">
                              <option selected="">Sort by : Newest</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                          </select>
                      </span>
                  </div>
              </div>
              <div class="filter-btn">
                  <a class="blueLine_btn" href="{{route('plans.create')}}">Add Plan +</a>
              </div>
          </div>
      </div>
  </div>

  <div class="sec1-style">
      <div class="table-span table-responsive">
          <table class="table table-comm">
              <thead>
                  <tr>
                      <th scope="col">
                          <span>
                              <input id="remember-me" name="remember-me" type="checkbox" />
                          </span>
                      </th>
                      <th scope="col">Plan Name</th>
                      <th scope="col">Price</th>
                      <th scope="col">Recurring</th>
                      <th scope="col">Action</th>
                  </tr>
              </thead>
              <tbody>
              @foreach($plans as $plan)
                  <tr>
                      <td>
                          <span>
                              <input id="remember-me" name="remember-me" type="checkbox" />
                          </span>
                      </td>
                      <td>
                          <span>{{$plan->name}}</span>
                      </td>
                      <td>
                          <p>${{$plan->price}}</p>
                      </td>
                      <td>
                          <span>{{$plan->recurring==1 ?'Yes' : 'No'}}</span>
                      </td>
                      <td>
                          <div class="tabAction-list">
                              <span class="tabEdit-icon">
                                  <a href="{{route('plans.edit',$plan->id)}}">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                          <path
                                              d="M15.75 0.000749946C15.1755 0.000749946 14.613 0.2235 14.1795 0.657L6.75 8.06325L6.58575 8.2275L6.53925 8.46225L6.02325 11.0872L5.78925 12.1883L6.891 11.9543L9.516 11.4383L9.75 11.3918L9.91425 11.2275L17.3205 3.798C17.6309 3.4868 17.8422 3.09066 17.9278 2.65953C18.0135 2.2284 17.9695 1.78157 17.8015 1.37538C17.6336 0.96919 17.3491 0.621817 16.984 0.377053C16.6189 0.132289 16.1895 0.00184189 15.75 0.000749946ZM15.75 1.45425C15.9255 1.45425 16.0988 1.54425 16.266 1.7115C16.5998 2.046 16.5998 2.409 16.266 2.74275L9 10.0095L7.71075 10.2675L7.96875 8.97825L15.2348 1.71225C15.4013 1.54575 15.5745 1.45425 15.75 1.45425ZM0 2.9775V17.9775H15V8.0865L13.5 9.5865V16.4775H1.5V4.4775H8.391L9.891 2.9775H0Z"
                                              fill="#092E75"
                                          ></path>
                                      </svg>
                                  </a>
                              </span>
                              <span class="tabDel-icon">
                                  <a class="hover" href="{{route('plans.delete',$plan->id)}}">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                                          <path
                                              d="M8 3.5H12C12 2.96957 11.7893 2.46086 11.4142 2.08579C11.0391 1.71071 10.5304 1.5 10 1.5C9.46957 1.5 8.96086 1.71071 8.58579 2.08579C8.21071 2.46086 8 2.96957 8 3.5ZM6.5 3.5C6.5 3.04037 6.59053 2.58525 6.76642 2.16061C6.94231 1.73597 7.20012 1.35013 7.52513 1.02513C7.85013 0.700121 8.23597 0.442313 8.66061 0.266422C9.08525 0.0905302 9.54037 0 10 0C10.4596 0 10.9148 0.0905302 11.3394 0.266422C11.764 0.442313 12.1499 0.700121 12.4749 1.02513C12.7999 1.35013 13.0577 1.73597 13.2336 2.16061C13.4095 2.58525 13.5 3.04037 13.5 3.5H19.25C19.4489 3.5 19.6397 3.57902 19.7803 3.71967C19.921 3.86032 20 4.05109 20 4.25C20 4.44891 19.921 4.63968 19.7803 4.78033C19.6397 4.92098 19.4489 5 19.25 5H17.93L16.76 17.111C16.6702 18.039 16.238 18.9002 15.5477 19.5268C14.8573 20.1534 13.9583 20.5004 13.026 20.5H6.974C6.04186 20.5001 5.1431 20.153 4.45295 19.5265C3.7628 18.8999 3.33073 18.0388 3.241 17.111L2.07 5H0.75C0.551088 5 0.360322 4.92098 0.21967 4.78033C0.0790175 4.63968 0 4.44891 0 4.25C0 4.05109 0.0790175 3.86032 0.21967 3.71967C0.360322 3.57902 0.551088 3.5 0.75 3.5H6.5ZM8.5 8.25C8.5 8.05109 8.42098 7.86032 8.28033 7.71967C8.13968 7.57902 7.94891 7.5 7.75 7.5C7.55109 7.5 7.36032 7.57902 7.21967 7.71967C7.07902 7.86032 7 8.05109 7 8.25V15.75C7 15.9489 7.07902 16.1397 7.21967 16.2803C7.36032 16.421 7.55109 16.5 7.75 16.5C7.94891 16.5 8.13968 16.421 8.28033 16.2803C8.42098 16.1397 8.5 15.9489 8.5 15.75V8.25ZM12.25 7.5C12.4489 7.5 12.6397 7.57902 12.7803 7.71967C12.921 7.86032 13 8.05109 13 8.25V15.75C13 15.9489 12.921 16.1397 12.7803 16.2803C12.6397 16.421 12.4489 16.5 12.25 16.5C12.0511 16.5 11.8603 16.421 11.7197 16.2803C11.579 16.1397 11.5 15.9489 11.5 15.75V8.25C11.5 8.05109 11.579 7.86032 11.7197 7.71967C11.8603 7.57902 12.0511 7.5 12.25 7.5ZM4.734 16.967C4.78794 17.5236 5.04724 18.0403 5.46137 18.4161C5.87549 18.792 6.41475 19.0001 6.974 19H13.026C13.5853 19.0001 14.1245 18.792 14.5386 18.4161C14.9528 18.0403 15.2121 17.5236 15.266 16.967L16.424 5H3.576L4.734 16.967Z"
                                              fill="#B60F0F"
                                          ></path>
                                      </svg>
                                  </a>
                              </span>
                          </div>
                      </td>
                  </tr>
                  @endforeach
              </tbody>
          </table>
      </div>
      <!-- Pegination Area -->
      <div class="peg-main">
          <div>
              <p class="peg-text gray1">Showing data 1 to 8 of 100 entries</p>
          </div>
          <div>
              <nav aria-label="Page navigation example">
                  <ul class="pagination">
                      <li class="page-item">
                          <a class="page-link" href="#" aria-label="Previous">
                              <span aria-hidden="true">
                                  <svg xmlns="http://www.w3.org/2000/svg" height="16px" viewBox="0 -960 960 960" width="16px" fill="#979797">
                                      <path d="M640-80 240-480l400-400 71 71-329 329 329 329-71 71Z"></path>
                                  </svg>
                              </span>
                          </a>
                      </li>
                      <li class="page-item"><a class="page-link gray1" href="#">1</a></li>
                      <li class="page-item"><a class="page-link gray1" href="#">2</a></li>
                      <li class="page-item"><a class="page-link gray1" href="#">...</a></li>
                      <li class="page-item"><a class="page-link gray1" href="#">30</a></li>
                      <li class="page-item">
                          <a class="page-link" href="#" aria-label="Next">
                              <span aria-hidden="true">
                                  <svg xmlns="http://www.w3.org/2000/svg" height="16px" viewBox="0 -960 960 960" width="16px" fill="#979797">
                                      <path d="m321-80-71-71 329-329-329-329 71-71 400 400L321-80Z"></path>
                                  </svg>
                              </span>
                          </a>
                      </li>
                  </ul>
              </nav>
          </div>
      </div>
  </div>
</div>
</div>
  @endsection