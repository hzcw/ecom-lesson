@extends('layouts.app')
@section('title')Users @stop
@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-sm-3">
                @include('partials.menu')

            </div>
            <div class="col-sm-9">
                <div><i class="fas fa-users text-primary"></i> Users</div>
                <div class="dropdown-divider"></div>
                <div class="row">
                </div>
                <div class="row">
                    <table class="table table-borderless table-hover">
                        <tr class="bg-secondary text-white">
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Join Date</th>
                        <th>Action</th>
                        </tr>
                        @foreach($users as $u)
                            <tr >
                                <td>{{$u->name}}</td>
                                <td>{{$u->email}}</td>
                                <td>
                                    @if($u->hasAnyRole(['Admin','Member']))
                                    {{$u->roles()->first()->name}}
                                        @else
                                        Role not assign.
                                    @endif
                                </td>
                                <td>{{$u->created_at->diffForHumans()}}</td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#r{{$u->id}}" class="btn btn-outline-info">
                                        <span data-toggle="tooltip" data-placement="top" title="Assign user Role">
                                            <i class="fas fa-user-cog"></i>
                                        </span>
                                    </a>
                                    <!--User Assign role modal -->
                                    <div id="r{{$u->id}}" class="modal fade" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-sm" role="document">
                                            <form method="post" action="{{route('assign.user.role')}}">
                                                <input type="hidden" name="user_id" value="{{$u->id}}">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Assign role for "{{$u->name}}"</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="role">Select Role</label>
                                                                <select name="role" id="role" class="custom-select">
                                                                    @foreach($roles as $r)
                                                                        <option>{{$r->name}}</option>
                                                                        @endforeach
                                                                </select>

                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!--End User Assign role modal -->
                                    <a data-toggle="modal" data-target="#u1{{$u->id}}" class="btn btn-outline-primary" href="#">
                                        <span data-toggle="tooltip" data-placement="top" title="Edit user information">
                                        <i class="fas fa-user-edit"></i>
                                        </span>
                                    </a>
                                    <!--modal for edit-->
                                    <div id="u1{{$u->id}}" class="modal fade" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-sm" role="document">
                                            <div class="modal-content">
                                                <form method="post" action="{{route('update.user')}}">
                                                    @csrf

                                                    <input type="hidden" name="user_id" value="{{$u->id}}">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit User Information</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>f
                                                    </div>
                                                    <div class="modal-body ">
                                                        <div class="form-group">
                                                            <label for="user_name">User Name</label>
                                                            <input type="text" name="user_name" id="user_name" class="form-control" value="{{$u->name}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">User Name</label>
                                                            <input type="text" name="email" id="email" class="form-control" value="{{$u->email}}">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-outline-primary">Save Change</button>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                    <!--End modal for edit-->

                                    <a href="#" data-toggle="modal" data-target="#u{{$u->id}}" class="btn btn-outline-danger"><i class="fas fa-user-times"></i> </a>
                                    <!--modal for delete-->
                                    <div id="u{{$u->id}}" class="modal fade" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-sm" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Modal title</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body text-center text-danger">
                                                    <i class="fas fa-exclamation-triangle fa-3x"></i>
                                                    <p>Are you sure??The id<b>"{{$u->id}}"</b>Will deleted permanently</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="{{route('user.drop',['id'=>$u->id])}}">Agree</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--End Modal for delete -->
                                </td>
                            </tr>
                            @endforeach

                    </table>

                </div>
            </div>
        </div>
    </div>
    @if(session('info'))
        <div class="alert alert-success myAlert">{{session('info')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

@stop
