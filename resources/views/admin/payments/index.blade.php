@extends('layouts.new_main')
@section('content')
<div class="dashbord-inner">
                            <!-- Section 1 -->
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
                                                            <option selected>1</option>
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
                                                            <option selected>
                                                                <span>Sort by :</span>
                                                                <span class="filter-text">Newest</span>
                                                            </option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                        </select>
                                                    </span>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="sec1-style">
                                    <div class="table-span table-responsive">
                                        <table class="table table-comm">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Company Name</th>
                                                    <th scope="col">Plan Name</th>
                                                    <th scope="col">Payments</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Purchased date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($payments as $payment)
                                                <tr>
                                                    <td>
                                                        <div class="table-conTab">
                                                            <span>{{$payment->user->name ?? ''}}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span>{{$payment->planName->name ?? ''}}</span>
                                                    </td>
                                                    <td><span>${{$payment->amount}}</span></td>
                                                    <td><span>{{$payment->status}}</span></td>
                                                    <td>
                                                        <span>{{$payment->created_at->format('Y-m-d')}}</span>
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
                                                                    <path d="M640-80 240-480l400-400 71 71-329 329 329 329-71 71Z" />
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
                                                                    <path d="m321-80-71-71 329-329-329-329 71-71 400 400L321-80Z" />
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