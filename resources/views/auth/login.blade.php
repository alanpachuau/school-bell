@extends('layouts.app')

@section('content')
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title m-b-md">
                School Bell Login
            </div>
            <el-form method="POST" action="{{ route('login') }}" label-width="120px" :inline=true>
                {{ csrf_field() }}
                <el-form-item label="">
                    <input type="text" autocomplete="off" name="username" placeholder="Username" class="el-input__inner">
                    <!-- <el-input name="username" placeholder="Username"></el-input> -->
                </el-form-item>
                <el-form-item label="">
                    <input type="password" autocomplete="off" name="password" placeholder="Password" class="el-input__inner">
                    <!-- <el-input type="password" name="password" placeholder="Password"></el-input> -->
                </el-form-item>
                <el-button native-type="submit" size="huge" round><i class="el-icon-arrow-right"></i> Login</el-button>
            </el-form>
        </div>
    </div>
@endsection
