@extends('layouts.app')
@section('title') Welcome @stop
@section('content')
        @include('partials.slide')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-sm-3">
                <div class="card shadow mb-2">
                    <div class="card-header">Shopping Cart</div>
                    <div class="card-body">
                        <p>
                            <a href="{{route('shopping.cart')}}">
                                <span class="badge badge-success">
                                    <i class="fas fa-shopping-bag"></i> &nbsp;
                                    {{Session::has('cart')? Session::get('cart')->totalQty:"0"}}
                                </span> Items
                            </a>
                        </p>
                    </div>
                </div>
                <div class="card shadow">
                    <div class="card-header">Search</div>
                    <div class="card-body">
                        <form method="get" action="{{route('search.posts')}}">
                            <input type="search" name="q" class="form-control" required>
                        </form>
                    </div>
                </div>
                <div class="card small shadow">
                    <div class="card-header"> Categories </div>
                    <div class="card-body">
                        <table class="table table-hover table-borderless">

                            @foreach($cats as $c)
                                <tr>
                                    <td><a class="d-block" href="{{route('posts.by.category',['cat_id'=>$c->id])}}">{{$c->cat_name}}</a> </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>

            </div>
            <div class="col-sm-9">
                <div class="row">
                    @foreach($posts as $p)
                        <div class="col-sm-4" data-toggle="tooltip" data-placement="top" title="{{$p->description}}">
                            <div class="card mb-3">
                                <img src="{{route('image',['file_name'=>$p->image])}}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">{{$p->item_name}}</h5>
                                    <P CLASS="card-text">
                                        <span class="bade badge-secondary">{{$p->price}}Ks</span>
                                    </P>

                                    <p class="card-text">
                                        <small><i class="fas fa-tag"></i> {{$p->category->cat_name}}</small>
                                        &nbsp;
                                        <small><i class="fas fa-user-tag"></i> {{$p->user->name}}</small>
                                        &nbsp;
                                        <small><i class="fas fa-calendar-day"></i> {{date("D(d) m/Y",strtotime($p->created_at))}}</small>

                                    </p>
                                    <a href="{{route('add.to.cart',['id'=>$p->id])}}" class="btn btn-outline-primary btn-block"><i class="fas fa-shopping-cart"></i> Add to card</a>
                                </div>
                            </div>

                        </div>
                        @endforeach
                </div>
                {{$posts->links()}}

            </div>
        </div>
    </div>
    <div class="card mt-5 bg-secondary">
        <div class="card-body">
            <p class="text-center text-white-50">&copy;2019 my..co.1td,</p>
            <div class="dropdown-divider"></div>
            @foreach($cats as $c)
                <a href="{{route('posts.by.category',['cat_id'=>$c->id])}}" class="text-white-50">{{$c->cat_name}}</a>
                @endforeach
        </div>

    </div>

    @stop