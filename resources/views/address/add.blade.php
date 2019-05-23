@extends('layouts.app')
@section('title', 'login')
@section('sidebar')
    @parent
@endsection
@section('content')
    <!-- address -->
    <div class="pages section">
        <div class="container">
            <div class="pages-head">
                <h3>ADDRESS</h3>
            </div>
            <div class="register">
                <div class="row">
                    <form class="col s12" onsubmit="return false">
                        <div class="input-field">
                            <input type="text" name="address_name" class="validate" placeholder="ADDRESS NAME" required>
                        </div>
                        <div class="input-field">
                            <input type="tel" name="address_tel" placeholder="ADDRESS TEL" class="validate" required>
                        </div>
                        <div class="input-field">
                            <input type="checkbox" name="is_status" placeholder="IS STATUS" class="validate" required>
                        </div>
                        <div class="input-field">
                            <textarea name="address_detailed" id="" cols="30" rows="10" placeholder="ADDRESS DETAILED" class="validate" required></textarea>
                        </div>
                        <div ><button class="btn button-default">REGISTER</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end address -->
@endsection