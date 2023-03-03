@extends('master')
@section('content')
    @if (session()->has('succes'))
        <div class="alert alert-success">
            {{ session()->get('succes') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card mt-20">
        <div class="card">
            <img class="card-img-top" src="..." alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's
                    content.</p>
                <form action={{ route('buy.product') }} method="POST">
                    @csrf
                    <label for="card_number">cartnumber:</label>
                    <input id="card_number" class="col-md-8" type="text" name="card_number">
                    <button class="btn btn-primary">buy product</button>
                </form>

            </div>
        </div>
    </div>

@endsection
