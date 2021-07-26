@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="main-container">
            @if(isset($report))
                <div class="alert alert-success" style="text-align:center;">
                    {{$report}}
                </div>
            @else
            <div class="motivate">
                    <h2 id="contactMotto">Say something ...</h2>
                    <p>Having a problem with our services ? need to ask about something ? <strong>send us a message !</strong> </p>        
                </div>
                 <div class="row justify-content-center">
                        <div class="col-md-8 col-sm-8 col-8 col-lg-8 contact-card">
                            <h2 id="header">Contact Form</h2>
                            <div class="contact-container">
                                <form id="contact-form" method="post" action="{{ action('MessageController@store') }}" role="form">
                                    @csrf
                                        <div class="controls">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="form_email">Email<span class="astrisc"> *</span></label>
                                                        <input id="form_email" type="email" name="email" class="form-control" placeholder="Please enter your email *" required="required">
                                                    </div>
                                                </div>
                                            </div>
                                            @if(app('request')->input('fileid') !== null)
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form_name">File ID<span class="astrisc"> *</span></label>
                                                            <input id="form_name" readonly type="text" name="subject" class="form-control" required="required" value="{{app('request')->input('fileid')}}">
                                                            <input type="hidden" name="type" value="report" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="form_message">Reason<span class="astrisc"> *</span></label>
                                                                <textarea id="form_message" name="message" class="form-control" placeholder="What are your reasons for reporting this file ? *" rows="4" required="required"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <input type="submit" class="btn btn-success btn-send" value="Report">
                                                        </div>
                                                </div>
                                            @else
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form_name">Subject<span class="astrisc"> *</span></label>
                                                            <input id="form_name" type="text" name="subject" class="form-control" placeholder="Please enter the subject *" required="required">
                                                            <input type="hidden" name="type" value="message" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="form_message">Message<span class="astrisc"> *</span></label>
                                                            <textarea id="form_message" name="message" class="form-control" placeholder="What's on your mind ? *" rows="4" required="required"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <input type="submit" class="btn btn-success btn-send" value="Send message">
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p class="text-muted">
                                                        <strong><span class="astrisc"> *</span></strong> These fields are required.
                                                </div>
                                            </div>
                                        </div>
                                </form>
                            </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
<style>
body {
    min-height: 100%;
}
.main-container {
    min-height: 100%;
}
.contact-container {
    margin-top: -3vh;
}
.contact-card {
    background-color: white;
    margin-bottom: 30px;
}
.motivate {
    margin: 10px 0px 20px 30px;
}
p {
    margin-left: 20px;
}
label {
    font-weight: 900;
}
.astrisc {
    color: red;
}
#header {
  text-align: center;
  font-family: Verdana, Geneva, Tahoma, sans-serif;
  color: gray;
  text-decoration: none;
  text-transform: uppercase;
  font-weight: 800;
  line-height: 1;
  text-shadow: #EDEDED 3px 2px 0;
  position: relative;
  margin-top: 10px;
}
#header:after {
  content:"dreamdealer";
  position: absolute;
  left: 8px;
  top: 32px;
}
#header:after {
  /*background: url(https://subtlepatterns.com/patterns/crossed_stripes.png) repeat;*/
  background-image: -webkit-linear-gradient(left top, transparent 0%, transparent 25%, #555 25%, #555 50%, transparent 50%, transparent 75%, #555 75%);
  background-size: 4px 4px;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  z-index: -5;
  display: block;
  text-shadow: none;
}
</style>