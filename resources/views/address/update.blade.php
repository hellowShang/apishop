<form onsubmit="return false">
    <div>
        <input type="text" name="address_name" placeholder="ADDRESS NAME" required>
    </div>
    <div>
        <input type="tel" name="address_tel" placeholder="ADDRESS TEL" required>
    </div>
    <div>
        <input type="checkbox" name="is_status" placeholder="IS STATUS" required>设为默认收货地址
    </div>
    <div>
        <select name="province" id="province">
            <option value="">省份</option>
            @foreach($arr as $k=>$v)
                <option value="{{$v['id']}}">{{$v['name']}}</option>
            @endforeach
        </select>
        <select name="city" class="city" id="city">
            <option>城市</option>
        </select>
        <select name="area" id="area" class="area">
            <option>区县</option>
        </select>
    </div>
    <div>
        <input type="text" name="address_detailed" placeholder="ADDRESS DETAILED" required>
    </div>
    <div>
        <button class="btn">ADDRESS ADD</button>
    </div>
</form>