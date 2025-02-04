@extends('frontend.layouts.master')

@section('content')

<div class="container my-5" >
    <div class="row">
        <div class="col-12 pt-4 pb-4 rounded" style="background: snow; opacity:0.88;">
            <h2 class="text-center pb-4 pt-2 nfis-sec-title">Two Step Verification </h2>
            {!! Session::has('success') ? '<div class="alert alert-success alert-dismissible"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'. Session::get("success") .'</div>' : '' !!}
            {!! Session::has('error') ? '<div class="alert alert-danger alert-dismissible"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'. Session::get("error") .'</div>' : '' !!}


            <div class="row">
                <div class="col-md-6">
                    {!! Form::open(array('url' => 'users/check-two-step/','method' => 'patch', 'class' => 'form-horizontal', 'id' => 'packagesCreateForm',
                 'enctype' =>'multipart/form-data', 'files' => 'true')) !!}
                    @if(Request::get('req')!=null)
                        {!! Form::hidden('req_dta',Request::get('req')) !!}
                    @endif
                    <div class="card border-0 shadow bg-white rounded">
                        <div class="card-header text-center"  style="font-size: 22px;">
                          Choose Your Method
                        </div>
                        <div class="card-body">
                            <img src="{{url('images/sms.png')}}" class="rounded mx-auto d-block"  alt="Two-step verification by SMS"
                            id="sms_verification_img"  width="80" />
                         <p class="card-text text-center pt-2">The system automatically generate 4 digit code send it to your mobile phone and email. You can use the code only one time.
                        </p>
                          <h5 class="card-title pt-3">
                            <label>
                                <?php $email = Auth::user()->user_email; ?>
                                {!! Form::radio('steps', 'email',  true, ['class' => ' required']) !!}
                                Get code in Email
                            </label>
                            (<?php echo substr($email, 0, 3) . '***************' . substr($email, -9); ?>)
                          </h5>
                          <h5 class="card-title">
                            <label>
                                <label>
                                    {!! Form::radio('steps', 'mobile_no', null, ['class' => 'required']) !!}
                                    Get SMS in Mobile No.
                                    {!! $errors->first('state','<span class="help-block">:message</span>') !!}
                                </label>
                                (<?php echo substr(Auth::user()->user_mobile, 0, 6) . '**********' . substr(Auth::user()->user_mobile, -2); ?>)
                          </h5>
                          <div class="email_address form-group row " style="display: none;">
                            <label for="email_address" class="col-sm-5 col-form-label">Email Address </label>
                            <div class="col-sm-7">
                                <input class="form-control" placeholder="Email Address" name="email_address" type="text" value="" id="email_address">

                            </div>
                        </div>
                        <a href="{{ url('/users/logout') }}" class="btn btn-danger mr-2"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        <button type="submit" class="btn btn-primary float-right">
                            <i class="fa fa-chevron-circle-right"></i> Next</button>
                        </div>
        
                      </div>
                    </form><!-- /.form end -->
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <h4 style="font-size: 22px;">What is two-step verification?</h4>
                        <p style="line-height: 1.9;">Two-step verification is a process that involves two authentication methods performed one after the other to verify that someone or something requesting access is who or what they are declared to be.</p>   
                    </div>
                    <div class="col-md-12 ">
                        <h4 style="font-size: 22px;">Why I need two step verification?</h4>
                        <p style="line-height: 1.9;">Two-step verification or multifactor authentication -- is widely used to add a layer of security to your online accounts. The most common form of two step verification when logging into an account is the process of entering your password and then receiving a code via text on your phone that you then need to enter. The second layer in two step verification means a hacker or other nefarious individual would need to steal your password along with your phone in order to access your account</p>
                    </div>
                    {{-- <div class="col-md-12">
                        <h4 style="font-size: 22px;">What is verification code?</h4>
                    </div> --}}

                    {{-- <div class="col-md-12" style="padding: 0px;">

                        <div class="row">
                            <div class="col-md-6" style="padding: 0px;">

                                <div class="col-md-12">

                                    <h4> দ্বিতীয় দফা ভেরিফিকেশন কী?</h4>
                                    <ul style="padding:7px 0px 0px 0px;font-size:14px;">
                                        <li> দ্বিতীয় দফা ভেরিফিকেশন এই সিস্টেমের একটি অতিরিক্ত নিরাপত্তা বলয়, যেখানে একজন ব্যবহারকারী তার পাসওয়ার্ড দিয়ে সিস্টেমে প্রবেশ করার পূর্বে
                                            তার ইমেইল অথবা মোবাইলে SMS এর মাধ্যমে একটি গোপনীয় ভেরিফিকেশন কোড পাঠানো হয়ে থাকে। ভেরিফিকেশন কোডটি প্রদান করার পর ব্যবহারকারীগন সিস্টেমে প্রবেশ করতে পারবেন। </li>
                                    </ul>
                                </div>
                                <div class="col-md-12">
                                    <h4>কেন দ্বিতীয় দফায় ভেরিফিকেশন প্রয়োজন?</h4>
                                    <ul style="padding:7px 0px 0px 0px;font-size:14px;">
                                        <li>যদি কোন তৃতীয় পক্ষ আপনার পাসওয়ার্ড জেনে যায়, তাহলে এই ভেরিফিকেশন প্রক্রিয়া তাকে আপনার অ্যাকাউন্টিতে প্রবেশ করতে প্রতিহত করবে। যতক্ষণ পর্যন্ত কারো নিকট আপনার ইমেইল এক্সেস অথবা মোবাইল নম্বরটি না থাকে ততক্ষন পর্যন্ত এই ভেরিফিকেশন প্রক্রিয়া তাকে সিস্টেমে প্রবেশ করতে দেবে না।</li>
                                    </ul>
                                </div>
                                <div class="col-md-12">
                                    <h4>ভেরিফিকেশন কোড কী?</h4>
                                    <ul style="padding:7px 0px 0px 0px;font-size:14px;">
                                        <li>আপনার ব্যবহারের জন্য সিস্টেম থেকে চার ডিজিটের একটি নাম্বার যা স্বয়ংক্রিয়ভাবে প্রস্তুত করা হয়ে থাকে, যাকে আমরা ভেরিফিকেশন কোড বলে আখ্যায়িত করছি।
                                            প্রতিটি ভেরিফিকেশন কোড শুধুমাত্র একবারই ব্যবহার করা যাবে। </li>
                                    </ul>
                                </div>
                            </div> 
               
                        </div>





                    </div> --}}

                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section ('footer-script')
<style>
    ul li {
       list-style-type: none;
    }
</style>
@endsection
