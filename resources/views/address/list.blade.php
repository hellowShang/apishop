@extends('layouts.app')
@section('title', 'login')
@section('sidebar')
    @parent
@endsection
@section('content')
    <table border="1">
        <tr>
            <td>姓名</td>
            <td>电话</td>
            <td>省市区</td>
            <td>详细地址</td>
            <td>操作</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
@endsection