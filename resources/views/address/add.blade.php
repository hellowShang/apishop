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
<!-- end address -->
<script src="/js/jquery-3.3.1.min.js"></script>
<script>
    $(function () {
        $('#province').change(function () {
            var id = $(this).val();
            $.ajax({
                url: '/user/getaddress',
                data: {'id': id},
                type: 'post',
                dataType: 'json',
                success: function (data) {
                    var str = "";
                    str += "<option>城市</option>";
                    $.each(data, function (k, v) {
                        str += "<option value=" + v.id + ">" + v.name + "</option>";
                    });
                    $('#city').html(str);
                }
            });
        });
        $('#city').change(function () {
            var id = $(this).val();
            $.ajax({
                url: '/user/getaddress',
                data: {'id': id},
                type: 'post',
                dataType: 'json',
                success: function (data) {
                    var str = "";
                    str += "<option>区县</option>";
                    $.each(data, function (k, v) {
                        str += "<option value=" + v.id + ">" + v.name + "</option>";
                    });
                    $('.area').html(str);
                }
            });
        });
        $('.btn').click(function () {
            var address_name = $("input[name='address_name']").val();
            var address_tel = $("input[name='address_tel']").val();
            var address_detailed = $("input[name='address_detailed']").val();
            var province=$("#province option:selected").text();
            var city=$("#city option:selected").text();
            var area=$("#area option:selected").text();
            var is_status=$("input[name='is_status']").prop('checked');
            if(is_status==true){
                var is_status=1;
            }else{
                var is_status='';
            }
            $.ajax({
                url: '/user/addressadd',
                data: {'address_name': address_name, 'address_tel': address_tel, 'address_detailed': address_detailed,'is_status':is_status,'province':province,'city':city,'area':area},
                type: 'post',
                dataType: 'json',
                success: function (data) {
                    if (data.code == 0) {
                        alert(data.msg);
                        location.href = "/user/addresslist";
                    } else if (data.code == 2) {
                        alert(data.msg);
                        location.href = "/user/login";
                    } else {
                        alert(data.msg);
                    }
                }
            });
        });
        return false;
    });
</script>