@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit User</div>
                <div class="panel-body">
                {!! Form::open(['action' => ['App\Http\Controllers\UserController@update', $user->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    
                        {{ csrf_field() }}
 
                        <div class="form-group{{ $errors->has('First_Name') ? ' has-error' : '' }}">
                            <label for="First_Name" class="col-md-4 control-label">First Name</label>

                            <div class="col-md-6">
                                <input id="First_Name" type="text" class="form-control" name="First_Name" value={{ $user->First_Name}} required autofocus>

                                @if ($errors->has('First_Name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('First_Name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('Last_Name') ? ' has-error' : '' }}">
                            <label for="Last_Name" class="col-md-4 control-label">Last Name</label>

                            <div class="col-md-6">
                                <input id="Last_Name" type="text" class="form-control" name="Last_Name" value={{ $user->Last_Name}} required autofocus>

                                @if ($errors->has('Last_Name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Last_Name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('Email') ? ' has-error' : '' }}">
                            <label for="Email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="Email" type="Email" class="form-control" name="Email" value={{ $user->Email}} required>

                                @if ($errors->has('Email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('Phone_Number') ? ' has-error' : '' }}">
                            <label for="Phone_Number" class="col-md-4 control-label">Phone_Number</label>

                            <div class="col-md-6">
                                <input id="Phone_Number" type="Phone_Number" class="form-control" name="Phone_Number" value={{ $user->Phone_Number}} >

                                @if ($errors->has('Phone_Number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Phone_Number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('Facebook_Account') ? ' has-error' : '' }}">
                            <label for="Facebook_Account" class="col-md-4 control-label">Facebook_Account</label>

                            <div class="col-md-6">
                                <input id="Facebook_Account" type="Facebook_Account" class="form-control" name="Facebook_Account" value={{ $user->Facebook_Account}} >

                                @if ($errors->has('Facebook_Account'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Facebook_Account') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('Instgram_Account') ? ' has-error' : '' }}">
                            <label for="Instgram_Account" class="col-md-4 control-label">Instgram_Account</label>

                            <div class="col-md-6">
                                <input id="Instgram_Account" type="Instgram_Account" class="form-control" name="Instgram_Account" value={{ $user->Instgram_Account}} >

                                @if ($errors->has('Instgram_Account'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Instgram_Account') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('Description') ? ' has-error' : '' }}">
                            <label for="Description" class="col-md-4 control-label">Description</label>

                            <div class="col-md-6">
                                <input id="Description" type="Description" class="form-control" name="Description" value={{ $user->Description}} >

                                @if ($errors->has('Description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                        <label for="Description" class="col-md-4 control-label"> Profile Image</label>
                        <br>
                            {{Form::file('profile_image')}}
                         </div>
                         <div class="form-group">
                        <label for="Description" class="col-md-4 control-label"> Cover Image</label>
                        <br>
                            {{Form::file('cover_image')}}
                         </div>

                         {{Form::hidden('_method','PUT')}}
                        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
                        {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

