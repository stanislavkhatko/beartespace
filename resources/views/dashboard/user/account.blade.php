@extends('dashboard.index')

@section('dashboard-content')

    <el-main class="app--wrapper">
        <div class="app-account">

                <div class="account">

                    <el-card style="margin-bottom: 20px;">
                        <div slot="header">Change password</div>
                        <el-form method="POST" action="{{ route('dashboard.change-password') }}">

                            @include('partials.errors')

                            {{ csrf_field() }}

                            <el-form-item label="Old Password" required>
                                <el-input type="password" placeholder="Old Password" value="{{ old('email') }}"
                                          name="old_password"
                                          autofocus></el-input>
                            </el-form-item>

                            <el-form-item label="New Password" required>
                                <el-input type="password" placeholder="New password" value="{{ old('new_password') }}"
                                          name="new_password"></el-input>
                            </el-form-item>


                            <el-form-item label="Confirm New Password" required>
                                <el-input type="password" placeholder="Confirm New Password"
                                          value="{{ old('new_password_confirmation') }}"
                                          name="new_password_confirmation"></el-input>
                            </el-form-item>


                            <el-form-item>
                                <el-button type="primary" native-type="submit">Save</el-button>

                                <el-button type="text"><a href="/">Return to home page</a></el-button>
                            </el-form-item>

                        </el-form>

                    </el-card>

                </div>

        </div>
    </el-main>

@endsection