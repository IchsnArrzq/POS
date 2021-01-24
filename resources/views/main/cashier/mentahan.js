
$(document).ready(function () {
    $('select[name="name"]').on('change', function () {
        var stateID = $(this).val();
        if (stateID) {
            $.ajax({
                url: '/menu/cashier/get/' + stateID,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('select[name="city"]').empty();
                    $.each(data, function (key, value) {
                        $('#price_sell').val(value.price_sell);
                        $('#price_buy').val(value.price_buy);
                        $('#stock').val(value.stock);
                        $('#description').val(value.description);
                        $('#stock_hidden').val(value.stock);
                        $('#id').val(value.id);
                        // console.log(value.price_sell)
                    });
                }
            });
        } else {
            $('select[name="name"]').empty();
            console.log('gagal')
        }
    });
});



window.onload = function () {
    document.getElementById('button').disabled = true
}

function pay() {
    let money = document.getElementById('money');
    let returns = document.getElementById('returns');
    returns.value = parseInt(money.value) - parseInt(document.getElementById('total').value);
}

function sum() {
    let stock = document.getElementById('stock_hidden').value
    let input = document.getElementById('input').value
    let price = document.getElementById('price_sell').value
    total = parseInt(stock) - parseInt(input)
    result = parseInt(price) * parseInt(input)
    if (!isNaN(total)) {
        if (total < 0 || input < 0) {
            document.getElementById('total').style.color = 'red'
            document.getElementById('total').value = 0
            document.getElementById('stock').value = 0
        } else {

            document.getElementById('total').style.color = 'black'
            document.getElementById('stock').value = total
            document.getElementById('total').value = result
        }
    }
    let money = document.getElementById('money');
    let returns = document.getElementById('returns');
    returns.value = parseInt(money.value) - parseInt(document.getElementById('total').value);
}

document.addEventListener('input', function () {
    let total = document.getElementById('total').value
    let returns = document.getElementById('returns').value;
    if (parseInt(total) <= 0 || parseInt(returns) < 0 || document.getElementById('money').value == 0) {
        document.getElementById('button').disabled = true
    } else {
        document.getElementById('button').disabled = false
    }
})

function rupiah() {
    angka = document.getElementById('price').value
    let reverse = angka.toString().split('').reverse().join('')
    ribuan = reverse.match(/\d{1,3}/g)
    ribuan = ribuan.join(',').split('').reverse().join('')
    return ribuan
}
