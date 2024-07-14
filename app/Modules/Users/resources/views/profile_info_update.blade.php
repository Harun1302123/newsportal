<div id="tab_1" class=" tab-pane active">
    {!! Form::open([
        'url' => '/users/profile_updates/' . $id,
        'method' => 'post',
        'id' => 'update_form',
        'class' => 'form-horizontal',
        'enctype' => 'multipart/form-data',
    ]) !!}
    <div class="row">

        <div class="col-md-6">
            <fieldset>
                {!! Form::hidden('Uid', $id) !!}

                @if ($users->organizationType->org_type_short_name)
                <div class="form-group row">
                    <label class="col-lg-4 text-left">Organization Type</label>
                    <div class="col-lg-8">
                        {{ $users->organizationType->org_type_short_name }}
                    </div>
                </div>
                @endif

                <div class="form-group row">
                    <label class="col-lg-4 text-left">User Role</label>
                    <div class="col-lg-8">
                        {{ $users->userRole->role_name }}
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-4 text-left">{!! trans('Users::messages.user_type') !!}</label>
                    <div class="col-lg-8">
                        {{ $user_type_info->type_name }}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-4 text-left">{!! trans('Users::messages.user_email') !!}</label>
                    <div class="col-lg-8">
                        {{ $users->user_email }}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-4 text-left ">{!! trans('Users::messages.user_name') !!}</label>
                    <div class="col-lg-8">
                        <div class="input-group ">
                            {!! Form::text('', $users->username,
                                $attributes = [
                                    'class' => 'form-control required',
                                    'placeholder' => 'Enter Name',
                                    'data-rule-maxlength' => '50',
                                    'readonly' => true,
                                ],
                            ) !!}
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2"><i class="fa fa-user"></i></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('user_mobile') ? 'has-error' : '' }}">
                    <label class="col-lg-4 text-left required-star">{!! trans('Users::messages.user_mobile') !!}</label>
                    <div class="col-lg-8">

                        {!! Form::text(
                            'user_mobile',
                            $users->user_mobile,
                            $attributes = [
                                'class' => 'form-control required mobile_number_validation',
                                'placeholder' => 'Enter your Mobile Number',
                                'id' => 'user_mobile',
                            ],
                        ) !!}

                        {!! $errors->first('user_mobile', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>

            </fieldset>
        </div>

        <div class="col-md-1 col-sm-1"></div>

        <div class="col-md-5 col-sm-5 col-sm-offset-1">
            <div class="card card-default" id="browseimagepp">
                <div class="row">
                    <div class="col-sm-6 col-md-4 addImages" style="max-height:300px;">
                        <label class="center-block image-upload" for="user_pic" style="margin: 0px">
                            <figure>
                                <img src="{{ asset($users->user_pic) }}"
                                    onerror="this.src=`{{ asset('/images/default_profile.jpg') }}`"
                                    class="img-responsive img-thumbnail" id="user_pic_preview" />
                            </figure>
                            <input type="hidden" id="user_pic_base64" name="user_pic_base64" />
                            @if (!empty($users->user_pic))
                                <input type="hidden" name="user_pic" value="{{ $users->user_pic }}" />
                            @endif
                        </label>
                    </div>
                    <div class="col-sm-6 col-md-8">
                        <h4 id="profile_image">
                            {!! Form::label('user_pic', trans('Users::messages.profile_image'), ['class' => 'text-left required-star']) !!}
                        </h4>
                        <span class="text-success col-lg-8 text-left"
                            style="font-size: 9px; font-weight: bold; display: block;">[File Format: *.jpg/ .jpeg/ .png
                            | Width 300PX, Height 300PX]</span>

                        <span id="user_err" class="text-danger col-lg-8 text-left" style="font-size: 10px;">
                            {!! $errors->first('applicant_photo', '<span class="help-block">:message</span>') !!}</span>
                        <div class="clearfix"><br /></div>
                        <label class="btn btn-primary btn-file">
                            <i class="fa fa-picture-o" aria-hidden="true"></i>
                            {!! trans('Users::messages.browse') !!}
                            <input type="file"
                                class="custom-file-input input-sm {{ !empty($users->user_pic) ? '' : 'required' }}"
                                name="user_pic" id="user_pic"
                                onchange="imageUploadWithCroppingAndDetect(this, 'user_pic_preview', 'user_pic_base64')"
                                size="300x300" />
                        </label>

                        <label class="btn btn-primary btn-file" id="cameraclick">
                            <i class="fa fa-picture-o" aria-hidden="true"></i>
                            Camera <span class="btn btn-primary"></span>
                        </label>
                    </div>


                </div>
            </div>
            <div class="card card-default" style="display: none" id="camera">
                <div class="row">
                    <div class="col-sm-6 col-md-8">

                    </div>

                    <div class="col-md-6">

                        <h4>
                            {!! Form::label('user_pic', trans('Users::messages.profile_image'), ['class' => 'text-left required-star']) !!}
                        </h4>
                        <span class="text-success col-lg-12 text-left"
                            style="font-size: 9px; font-weight: bold; display: block;">[File Format: *.jpg/ .jpeg/ .png
                            | Width 300PX, Height 300PX]</span>

                        <div id="my_camera"></div>
                        <div id="results">Your captured image will appear here...</div>

                        <br />

                        <input type=button id="ts" value="Take Snapshot" onClick="take_snapshot()">

                        <input type="hidden" name="image" class="image-tag">

                        <button type="button" id="reset_image_from_webcamera" class="btn btn-warning btn-xs"
                            value="">Reset image
                        </button>

                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-12"><br>
            <div class="float-right">
                <button type="submit" class="btn btn-info px-3 " id='update_info_btn'><b><i class="fa fa-save"></i>
                        {!! trans('Users::messages.save') !!}
                    </b>
                </button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

</div>
