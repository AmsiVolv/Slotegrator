@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card alert-success">
                @if(isset($prize)&&!empty($prize))
                    <div class="col-12 border-success">
                        <p>Congratulation, you win {{$prize}}: <spam>{{$amount}}</spam> </p>
                    </div>
                    @if($prize === 'points')
                            <form name="converPoint" method="post" action="">
                                @csrf
                                <button class="btn-secondary btn">Convert point!</button>
                            </form>
                    @endif
                    @if($prize === 'thing')
                            <form name="rejectButtn" id="rejectButtn" method="POST" action="{{'reject'}}">
                                @csrf
                                <button class="btn-secondary btn">Reject items!</button>
                            </form>
                    @endif
                @endif
                </div>
                <button class="btn-secondary btn"><a class="text-decoration-none" href="{{'home'}}">Home!</a></button>
            </div>
         </div>
    </div>
@endsection
