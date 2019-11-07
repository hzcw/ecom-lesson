@extends('layouts.app')

@section('content')
    @if(Auth::User()->hasAnyRole(['Admin']))
        <div class="container-fluid">
            <i class="fas fa-tachometer-alt mt-5"></i> Dashboard
                <div class="dropdown-divider"></div>
            <div class="row">
                <div class="col-sm-8">
                    <div class="card shadow bg-primary mb-2">
                        <div class="card-body">
                            <span class="text-white"><i class="fas fa-tags"></i> Posts</span>
                            <span class="float-right btn btn-outline-light rounded-circle">{{count($posts)}}</span>
                        </div>
                        <div class="card-footer">
                            <a class="btn btn-block btn-link text-white" href="{{route('posts')}}"> More >></a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card shadow bg-warning mb-2">
                        <div class="card-body">
                            <span class="text-white"><i class="fas fa-list"></i> Categories</span>
                            <span class="float-right btn btn-outline-light rounded-circle">{{count($cats)}}</span>
                        </div>
                        <div class="card-footer">
                            <a class="btn btn-block btn-link text-white" href="{{route('post.categories')}}"> More >></a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card shadow bg-secondary mb-2">
                        <div class="card-body">
                            <span class="text-white"><i class="fas fa-jedi-order"></i> Orders</span>
                            <span class="float-right btn btn-outline-light rounded-circle">{{count($orders)}}</span>
                        </div>
                        <div class="card-footer">
                            <a class="btn btn-block btn-link text-white" href="{{route('orders')}}"> More >></a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="card shadow bg-info">
                        <div class="card-body">
                            <span class="text-white"><i class="fas fa-users"></i> Users</span>
                            <span class="float-right btn btn-outline-light rounded-circle">{{count($users)}}</span>
                        </div>
                        <div class="card-footer">
                            <a class="btn btn-block btn-link text-white" href="{{route('users')}}"> More >></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container mt-5">
            <div class="row">
                <div class="col-sm-2"><i class="fas fa-border-none"></i> My Orders</div>
                <div class="col-sm-4">
                    <form method="get" id="form_filter_by_date" action="{{route('filer_by_date')}}">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Filer By Date</div>
                                </div>
                                <input type="date" id="filter_by_date" name="filter_by_date" class="form-control">

                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-4">
                    <form method="get" id="form_filer_by_month" action="{{route('filer_by_month')}}">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Filer By Month</div>
                                </div>
                                <select name="filter_by_month" id="filer_by_month" class="form-control">
                                    <option value="">Select Month</option>
                                    <option value="2019-01">Jan 2019 </option>
                                    <option value="2019-02">Feb 2019 </option>
                                    <option value="2019-11">Nov 2019</option>

                                </select>

                            </div>
                        </div>
                    </form>
                </div>

            </div>
            <div class="dropdown-divider"></div>
            <div class="accordion" id="accordionExample">
                @foreach($orders as $od)
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h2 class="mb-0">
                                <button class="btn btn-link " type="button" data-toggle="collapse" data-target="#c{{$od->id}}" aria-expanded="true" aria-controls="collapseOne">
                                    <i class="fas fa-caret-down"></i>  Order ID: {{$od->id}}
                                </button>
                            </h2>
                        </div>

                        <div id="c{{$od->id}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4" style="border-right: 2px solid darkblue">
                                        <p>
                                            <i class="fas fa-user"></i> Name: {{$od->user->name}}
                                        </p>
                                        <p>
                                            <i class="fas fa-envelope"></i> Email: {{$od->user->email}}
                                        </p>
                                        <p>
                                            <i class="fas fa-phone"></i> Phone: {{$od->phone}}
                                        </p>
                                        <p>
                                            <i class="fas fa-map-marker"></i> Address: {{$od->address}}
                                        </p>
                                        <p>
                                            <i class="fas fa-clock"></i> Date: {{$od->created_at->diffForHumans()}}
                                        </p>

                                    </div>
                                    <div class="col-sm-8">
                                        <table class="table table-hover table-borderless">
                                            <tr>
                                                <th>Item Name</th>
                                                <th>Price</th>
                                                <th>Qty</th>
                                                <th>Amount</th>
                                            </tr>
                                            <?php $totalAmount=0 ?>
                                            @foreach($od->orderItem as $i)
                                                <?php $totalAmount += $i->amount ?>
                                                <tr>
                                                    <td>{{$i->item_name}}</td>
                                                    <td>{{$i->price}}</td>
                                                    <td>{{$i->qty}}</td>
                                                    <td>{{$i->amount}}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="3" class="text-right">Total Amount</td>
                                                <td>{{$totalAmount}}</td>
                                            </tr>

                                        </table>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                @endforeach

            </div>

        </div>

    @endif
@endsection
