@extends('layout')
@section('content')
<style>
  .push-top {
    margin-top: 50px;
  }
  .hidden-form {
      display: None;
  }
</style>
<script
    src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"></script>
<div class="push-top">
    <div>
        <div class="float-left">
        <form class="" action="{{ route('search') }}" method="GET">
            <input type="text" name="search">
            <button type="submit">Search</button>
        </form>
        </div>
        <div class="float-right">
            <a href="{{ route('books.create')}}" class="btn btn-primary btn-lg">Create</a>
        </div>
    </div>
        @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div><br />
  @endif
  <table class="table push-top">
    <thead>
        <tr class="table-warning">
          <td>ID</td>
          <td>Product Name</td>
          <td>Description</td>
          <td>Author</td>
          <td>Price</td>
          <td>Image</td>
          <td>created_at</td>
          <td>updated_at</td>
          <td class="text-center">Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach($books as $item)
        <tr data-id="{{$item->id}}">
            <td>{{$item->id}}</td>
            <td>{{$item->product_name}}</td>
            <td>{{$item->product_description}}</td>
            <td>{{$item->product_author}}</td>
            <td>{{$item->product_price}}</td>
            <td><img src="{{ asset('storage/images/' . $item->product_image_url) }}" alt="Product Image" width="240px" height="200px"></td>
            <td>{{$item->created_at}}</td>
            <td>{{$item->updated_at}}</td>
            <td class="text-center">
                <a href="{{ route('books.edit', $item->id)}}" class="btn btn-primary btn-sm">Update</a>

                <form action="{{ route('books.destroy', $item->id)}}" method="post" style="display: inline-block">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
    <div class="col-6">
        <div class="card-body">
        </div>

        <div class="hidden-form">
        </div>
    </div>
<div>
@endsection
