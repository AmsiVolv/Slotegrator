@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        {{'Welcome back, '. Auth::user()->name .'!'}} <span class="caret"></span>
                    <div class="col-12 mt-2 mb-2 text-center">
                        <form method="POST" name="awardForm" action="{{'game'}}">
                            @csrf
                            <button name="awardSubmit" class="btn btn-success" id="awardSubmit" type="submit">
                                Press me!
                            </button>
                        </form>
                    </div>
                    @if(isset($data)&&!empty($data))
                        <div class="col-12 mt-2 mb-2 text-left">
                            <h3>
                                All the prizes you won:
                            </h3>
                        @foreach($data as $item)
                            <div class="col-12 mt-2 mb-2 text-left">
                                {{$item['type']}}:<span>{{$item['quantity']}}</span>
                            </div>
                        @endforeach
                    @endif
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
