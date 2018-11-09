@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">Course {{$course->name}}</div>

                    <div class="card-body">
                        <p class="register"><button  data-toggle="modal" data-target="#registerModal" class="btn-primary btn">Registrieren</button></p>
                        <p class="description">
                            {!! $category->description !!}
                        </p>
                        <p class="register"><button  data-toggle="modal" data-target="#registerModal" class="btn-primary btn">Registrieren</button></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="registerModal" tabindex="0" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registration form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @guest
                    <form action="{{route('registerForm')}}" id="register-form" method="post">
                @else
                    <form action="{{route('registerFormClient')}}" id="register-client-form" method="post">
                @endguest


                <div class="modal-body">

                        @csrf
                        <div class="form-group">
                            <label for="whenStart">When do you want to start?</label>
                            <select class="form-control"  aria-describedby="whenStartHelp" name="whenStart">
                                @foreach($similars as $similar)
                                    @if($similar->price !== null && $similar->available)
                                    <option data-price="{{$similar->price}}" value="{{$similar->id}}">@dateFormat($similar->start_date)</option>
                                    @endif
                                @endforeach

                            </select>
                            <small id="whenStartHelp" class="form-text text-muted">Price for you: <b>{{ $similars[0]->price }}</b> €
                                <button type="button" class="btn btn-information" data-container="body" data-toggle="popover" data-placement="bottom" data-content="Text about different prices">
                                    ?
                                </button></small>
                        </div>
                        @guest
                        <div class="form-group">
                            <label for="firstName">First name</label>
                            <input type="text" required class="form-control" name="firstName" placeholder="Enter first name">
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last name</label>
                            <input type="text" required class="form-control" name="lastName" placeholder="Enter last name">
                        </div>
                        <div class="form-group">
                            <label for="Phone">Phone</label>
                            <input type="tel" required class="form-control" name="phone" placeholder="Enter phone">
                        </div>
                        <div class="form-group">
                            <label for="birthDay">Birth day</label>
                            <input type="text" required class="form-control datepicker" name="birthDay"  placeholder="Enter birth day">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" required class="form-control" name="email" aria-describedby="emailHelp" placeholder="Enter email">
                            <small id="emailHelp" class="form-text text-muted">We'll send yours account details to your E-mail.</small>
                        </div>
                        <div class="form-group">
                            <label for="adress">Adress</label>
                            <textarea class="form-control" required name="adress"  placeholder="Enter adress"></textarea>
                        </div>
                        @endguest
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="acceptCheck" required>
                            <label class="form-check-label" for="acceptCheck">I accept <a href="#" id="showRules" data-toggle="modal" data-target="#rulesModal">school rules</a></label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="acceptCheck2" required>
                            <label class="form-check-label" for="acceptCheck2">I accept <a href="#" id="showConf" data-toggle="modal" data-target="#confModal">confidential politic</a></label>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-register">Register</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="rulesModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">School's rules</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{$rules}}
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="confModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Politic of confidential</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{$konf}}
                </div>
            </div>
        </div>
    </div>

@endsection
