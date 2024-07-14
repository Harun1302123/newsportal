<div class="container tab-pane fade" id="tab_2">
    <div class="row">
        <div class="col-sm-9">
            {!! Form::open([
                'url' => '/users/update-password-from-profile',
                'method' => 'patch',
                'class' => 'form-horizontal',
                'id' => 'password_change_form',
            ]) !!}
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="clearfix"><br /></div>
            <input type="hidden" class="form-control" name="Uid" value="{{ $id }}">

            <div class="form-group row {{ $errors->has('user_old_password') ? 'has-error' : '' }}">
                <label class="col-lg-3 text-left">Old Password</label>
                <div class="col-lg-5">
                    {!! Form::password(
                        'user_old_password',
                        $attributes = [
                            'class' => 'form-control required',
                            'placeholder' => 'Enter your old password',
                            'id' => 'user_old_password',
                            'data-rule-maxlength' => '120',
                        ],
                    ) !!}
                    {!! $errors->first('user_old_password', '<span class="help-block">:message</span>') !!}
                </div>
            </div>

            <div class="form-group row {{ $errors->has('user_new_password') ? 'has-error' : '' }}">
                <label class="col-lg-3 text-left">New Password</label>
                <div id="myPassword" class="col-lg-5">
                    <div class="col-lg-12 p-0">
                        {!! Form::password(
                            'user_new_password',
                            $attributes = [
                                'class' => 'form-control required',
                                'minlength' => '6',
                                'placeholder' => 'Enter your new password',
                                'onkeyup' => 'enableSavePassBtn()',
                                'id' => 'user_new_password',
                                'data-rule-maxlength' => '120',
                            ],
                        ) !!}
                        <input type="text" id="enable_show" class="form-control" style="display:none" />
                        {!! $errors->first('user_new_password', '<span class="help-block">:message</span>') !!}
                        <a href="" class="button_strength float-right" onclick="enableSavePassBtn()">Show</a>
                        <div class="strength_meter mt-4">
                            <div class="">
                                <p></p>
                            </div>
                        </div>
                    </div>
                    <div class="pswd_info">
                        <h4>Password must include:</h4>
                        <ul>
                            <li data-criterion="length" class="invalid">At least <strong> 06 Characters</strong></li>
                            <li data-criterion="capital" class="invalid">At least <strong>one capital letter</strong>
                            </li>
                            <li data-criterion="number" class="invalid">At least <strong>one number</strong></li>
                            <li data-criterion="specialchar" class="invalid">At least <strong>one special
                                    character</strong></li>
                            <li data-criterion="letter" class="valid">No spaces</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="form-group row {{ $errors->has('user_confirm_password') ? 'has-error' : '' }}">
                <label class="col-lg-3 text-left">Confirm New Password</label>
                <div class="col-lg-5">
                    {!! Form::password(
                        'user_confirm_password',
                        $attributes = [
                            'class' => 'form-control required',
                            'minlength' => '6',
                            'placeholder' => 'Confirm your new password',
                            'id' => 'user_confirm_password',
                            'data-rule-maxlength' => '120',
                        ],
                    ) !!}
                    {!! $errors->first('user_confirm_password', '<span class="help-block">:message</span>') !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-2 col-lg-offset-6">
                    <div class="clearfix"><br></div>
                    <button type="submit" class="btn btn-block disabled btn-primary"
                        id="update_pass_btn"><b>Save</b></button>
                </div>
                <div class="col-lg-4"></div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
