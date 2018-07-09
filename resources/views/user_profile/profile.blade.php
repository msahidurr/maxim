@extends('layouts.dashboard')
{{-- @section('page_heading','Add Role') --}}
@section('section')
           
<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-5 col-sm-offset-3">
            
            @if(count($errors) > 0)
                    <div class="alert alert-danger" role="alert">
                        @foreach($errors->all() as $error)
                          <li><span>{{ $error }}</span></li>
                        @endforeach
                    </div>
            @endif
            @if(Session::has('profile_update'))
                @include('widgets.alert', array('class'=>'success', 'message'=> Session::get('profile_update') ))
            @endif
            

            <form role="form" action="{{ Route('user_profile_action') }}" method="post">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="user_id" value="{{ $selectedUser->user_id }}">
                
                <div class="form-group">
                    <input class="form-control" type="text" name="personal_name" value="{{ $selectedUser->first_name }}" placeholder="Personal Name">
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" name="personal_phone_number" value="{{ $selectedUser->phone_no }}" placeholder="Phone Number">
                </div>

                <div class="form-group">
                    <input class="form-control" type="email" name="email" value="{{ $selectedUser->email }}" placeholder="Email" required="email" disabled>
                </div>

                 <div class="form-group">
                    <input class="form-control" type="text"  value="{{ $selectedUser->name }}" placeholder="Company Number" disabled>
                </div>

                <div class="form-group">
                        @foreach($roleList as $role)
                            @if($selectedUser->user_role_id == $role->id)
                                <input class="form-control" type="text"  value="{{ $role->name }}"  disabled>
                            @endif
                        @endforeach
                </div>
                
                <div class="form-group">
                    <input class="form-control" type="text"  value="{{ $selectedUser->phone }}" placeholder="Company Phone" disabled>
                </div>
                <div class="form-group">
                    <input class="form-control" type="text"  value="{{ $selectedUser->address }}" placeholder="Company Address" disabled>
                </div>
                <div class="form-group">
                    <input class="form-control" type="text"  value="{{ $selectedUser->description }}" placeholder="Company Address" disabled>
                </div>

                <div class="form-group">
                    <select class="form-control" name="is_active" disabled>                        
                        <option value="0">Deactive</option>
                        <option @if($selectedUser->is_active == 1) {{ 'selected' }} @endif value="1">Active</option>
                    </select>
                </div>


                <button style="margin-bottom: 20px;" type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">Change Password</button>
                <div id="demo" class="collapse">
                    
                    <div class="form-group">
                        <input type="password" class="form-control" name="current_password" value="" placeholder="Current Password">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" value="" placeholder="New Password">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password_confirmation" value="" placeholder="Confirm Password">
                    </div>

                </div>


                <div class="form-group">
                    <input class="form-control btn btn-primary btn-outline" type="submit" value="Update" >
                </div>
            </form>
        </div>
    </div>
</div>
            
@stop

