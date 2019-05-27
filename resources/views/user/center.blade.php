@extends('layouts.app')
@section('title', 'center')
@section('sidebar')
    @parent
@endsection
@section('content')
    <div class="pages section">
        <div class="container">
            <div class="pages-head">
                <h3>CENTER</h3>
            </div>
            <div class="row">
                <table class="pages-head container">
                    <tr>
                        <td>用户名</td>
                        <td>{{$arr['name']}}</td>
                    </tr>
                    <tr>
                        <td>年龄</td>
                        <td>{{$arr['age']}}</td>
                    </tr>
                    <tr>
                        <td>电话</td>
                        <td>{{$arr['tel']}}</td>
                    </tr>
                    <tr>
                        <td>邮箱</td>
                        <td>{{$arr['email']}}</td>
                    </tr>
                    <tr>
                        <td>入坑时间</td>
                        <td>{{date('Y-m-d H:i:s',$arr['add_time'])}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection