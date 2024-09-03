@extends('layouts.main')
@section('content')
<div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
            @if(Session::has('success'))
                <div class="alert alert-success" style="color:white">{{Session::get('success')}}</div>
            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger" style="color:white">{{Session::get('error')}}</div>
            @endif
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Users table</h6>
              <a href="{{route('users.create')}}" class="btn btn-primary" style="float:right">Add User</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sr #</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Phone</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Joined Date</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($users)>0)
                    @foreach($users as $user)
                    <tr>
                    <td>{{$loop->iteration}}</td>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="{{asset('assets/img/team-2.jpg')}}" class="avatar avatar-sm me-3" alt="user1">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{{$user->name}}</h6>
                            <p class="text-xs text-secondary mb-0">{{$user->email}}</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{$user->phone}}</p>
                       
                      </td>
                      <td class="align-middle text-center text-sm">
                        @if($user->active==1)
                        <span class="badge badge-sm bg-gradient-success">Active</span>
                        @else
                        <span class="badge badge-sm bg-gradient-danger">Inactive</span>
                        @endif
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{$user->created_at->format('Y-m-d')}}</span>
                      </td>
                      <td class="align-middle">
                        <a href="{{route('users.edit',$user->id)}}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-original-title="Edit user">
                          Edit
                        </a>
                        <a href="{{route('users.delete',$user->id)}}"  class="btn btn-sm btn-danger" >
                          Delete
                        </a>
                        @if($user->active==1)
                        <a href="{{route('users.deactivate',$user->id)}}"  class="btn btn-sm btn-success" >
                          Deactivate
                        </a>
                        @else
                        <a href="{{route('users.activate',$user->id)}}"  class="btn btn-sm btn-success" >
                          Activate
                        </a>
                        @endif
                       
                      </td>
                    </tr>
                    <div class="modal fade" id="deleteUser{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                ...
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                            </div>
                        </div>
                        </div>
                   @endforeach
                   @else
                   <tr>
                    <td colspan="5" class="text-center">
                    <p>No records found</p>
                    </td>
                   </tr>
                  
                   @endif
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    
    </div>
  @endsection