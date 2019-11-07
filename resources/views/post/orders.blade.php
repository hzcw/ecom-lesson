@extends('layouts.app')
@section('title') Orders @stop
@section('content')

    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-2"><i class="fas fa-border-none"></i> Orders</div>
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
                    <div class="row">
                        <div class="col-sm-8">
                            <h2 class="mb-0">
                                <button class="btn btn-link @if($od->status)  text-success @endif" type="button" data-toggle="collapse" data-target="#c{{$od->id}}" aria-expanded="true" aria-controls="collapseOne">
                                    <i class="fas fa-caret-down"></i>  Order ID: {{$od->id}}
                                </button>
                            </h2>
                        </div>
                        <div class="col-sm-2 offset-sm-2">
                            <span class="text-success text-sm-right"> @if($od->status) Delivered @endif</span>
                        </div>
                    </div>
                </div>

                <div id="c{{$od->id}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4" style="border-right: 2px solid darkblue">
                                <p>{!! DNS1D::getBarcodeHTML($od->id, "CODABAR"); !!}</p>
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
                                    <tr>

                                        <td colspan="4" class="text-right">
                                            @if($od->status==1)
                                            <button class="btn btn-outline-primary">Deliver Already</button>



                                        @else


                                            <a href="{{route('deliver',['id'=>$od->id])}}" class="btn btn-outline-primary">Waiting for deliver</a>



                                        @endif
                                        </td>
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
@stop