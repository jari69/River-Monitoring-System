@extends('layouts.app') 
@section('content')
<br/>
<a href="{{ route('rivers.index')}}"class="btn btn-danger">Cancel</a>
<div class="row">
    <div class="col-sm-8 offset-sm-2">
        <h1 class="display-3">Update a river</h1>
        
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <br /> 
        @endif
        
        <form method="post" action="{{ route('rivers.update', $rivers->id) }}">
            @method('PATCH') 
            @csrf
            <div class="form-group">
          
                <label for="name">River Name:</label>
                <input type="text" class="form-control" name="name" value="{{ $rivers->name }}"/>
            </div>

            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" class="form-control" name="location" value="{{ $rivers->location }}"/>
            </div>

            <div class="form-group">
                <label for="location">Api Key:</label>
                <input type="text" class="form-control" name="key" value={{ $rivers->key }} />
            </div>

            <div class="form-group">
                <label for="location">Channel:</label>
                <input type="text" class="form-control" name="channel" value={{ $rivers->channel }} />
            </div>

            <div class="form-group">
                <label for="location">Width (m):</label>
                <input type="text" class="form-control" name="width" value={{ $rivers->width }} />
            </div>

            <div class="form-group">
                <label for="height">Height (m):</label>
                <input type="text" class="form-control" name="height" value={{ $rivers->height }} />
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection