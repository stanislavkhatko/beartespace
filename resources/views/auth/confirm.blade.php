@extends('layouts.simple')

@section('content')


    <el-main class="app-auth">

        @if(auth()->user())

            <el-card class="box-card app-auth-login">
                <div slot="header" class="h4"><i class="el-icon-success"></i> &nbsp; Please confirm your email address
                </div>

                <div class="p">Confirmation has been send to <b>{{ auth()->user()->email }}</b>.</div>
                <div class="p">Please go to your email box and follow the link to continue.</div>

                <div class="p">Click
                    <a href="{{ route('confirm-email.resend') }}" class="el-button el-button--text">here</a>
                    to send verification code to your email again.
                </div>

                <div style="text-align: right;">

                    <a href="{{ route('confirm-email.resend') }}" class="el-button el-button--text">Send email again</a>

                    <a href="/" class="el-button el-button--default el-button--primary">Home</a>

                </div>
            </el-card>

        @endif

    </el-main>

@endsection
