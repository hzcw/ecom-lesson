@extends('layouts.app')
@section('title')Edit Post @stop
@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-sm-3">
                @include('partials.menu')

            </div>
            <div class="col-sm-9">
                <div><i class="fas fa-edit"></i> Edit Post</div>
                <div class="dropdown-divider"></div>
                <div class="row">
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <form enctype="multipart/form-data" method="post" action="{{route('update.post')}}">
                            <input type="hidden" name="id" value="{{$posts->id}}">
                            @csrf
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" name="image" id="image" class="form-control-file @if($errors->has('image')) is-invalid @endif">
                                @if($errors->has('image'))<span class="invalid-feedback">{{$errors->first('image')}}</span> @endif
                            </div>
                            <div class="form-group">
                                <label for="item_name">Item Name</label>
                                <input value="{{$posts->item_name}}" type="text" name="item_name" id="item_name" class="form-control @if($errors->has('item_name')) is-invalid @endif">
                                @if($errors->has('item_name'))<span class="invalid-feedback">{{$errors->first('item_name')}}</span> @endif

                            </div>
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input value="{{$posts->price}}" type="text" name="price" id="price" class="form-control @if($errors->has('price')) is-invalid @endif">
                                @if($errors->has('price'))<span class="invalid-feedback">{{$errors->first('price')}}</span> @endif

                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea  name="description" id="description" class="form-control @if($errors->has('description')) is-invalid @endif">{{$posts->description}}</textarea>
                                @if($errors->has('description'))<span class="invalid-feedback">{{$errors->first('description')}}</span> @endif

                            </div>
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select  name="category" id="category" class="custom-select @if($errors->has('category')) is-invalid @endif" name="category" >
                                    @foreach($cats as $c)
                                        <option @if($posts->category_id==$c->id) selected @endif value="{{$c->id}}">{{$c->cat_name}}</option>
                                        @endforeach

                                </select>
                                @if($errors->has('category'))<span class="invalid-feedback">{{$errors->first('category')}}</span> @endif

                            </div>
                            <div class="form-group">
                                <a href="{{route('posts')}}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-outline-primary btn-lg">Save</button>
                            </div>
                        </form>
                    </div>
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
