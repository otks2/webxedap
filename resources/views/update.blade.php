@extends('layout')
@section('content')
<style>
    .container {
      max-width: 450px;
    }
    .push-top {
      margin-top: 50px;
    }
</style>
<div class="card push-top">
  <div class="card-header">
    Edit & Update
  </div>
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
      <form method="post" action="{{ route('books.update', $books->id) }}" >
          <div class="form-group">
              @csrf
              @method('PATCH')
              <label for="title">Product Name</label>
              <input type="text" class="form-control" name="product_name" value="{{ $books->product_name }}"/>
          </div>
          <div class="form-group">
              <label for="product_description">Description</label>
              <input type="text" class="form-control" name="product_description" value="{{ $books->product_description }}"/>
          </div>
          <div class="form-group">
              <label for="product_author">Author</label>
              <input type="text" class="form-control" name="product_author" value="{{ $books->product_description }}"/>
          </div>

          <div class="form-group">
              <label for="product_price">Price</label>
              <input type="text" class="form-control" name="product_price" value="{{ $books->product_price }}"/>
          </div>

          <button type="submit" class="btn btn-block btn-danger">Update</button>
      </form>
  </div>
</div>
@endsection
