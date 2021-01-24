@extends('layouts.dashboard.app')
@section('content')
<script src="{{ asset('jquery.js') }}"></script>
<div class="page-wrapper mdc-toolbar-fixed-adjust">
    <main class="content-wrapper">
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell--span-12">
                    <div class="mdc-card">
                        <h6 class="card-title">Goods</h6>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                            <div class="mdc-card p-0">
                                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Add To Cart</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('menu.cashier.cart') }}" method="post">
                                                    @csrf
                                                    <div class="container">
                                                        <div class="row">
                                                            <input class="form-control" name="stock" value="{{ $pay->stock ?? '' }}" readonly type="hidden" id="stock_hidden">
                                                            <input type="hidden" name="id" id="id" value="{{ $pay->id ?? '' }}">
                                                            <div class="col-md-12">
                                                                <label for="name" class="col-form-label">Name</label>
                                                                <select name="name" class="form-control" id="name">
                                                                    <option value="" disabled selected>Choose Name</option>
                                                                    @foreach ($goods as $key => $value)
                                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="price" class="col-form-label">Price Sell</label>
                                                                <input class="form-control" name="price_sell" value="{{ $pay->price_sell ?? '' }}" readonly type="number" id="price_sell">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="price" class="col-form-label">Price Buy</label>
                                                                <input class="form-control" name="price_buy" value="{{ $pay->price_buy ?? '' }}" readonly type="number" id="price_buy">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="stock" class="col-form-label">Stock</label>
                                                                <input class="form-control" name="stock" value="{{ $pay->stock ?? '' }}" readonly type="number" id="stock">
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label for="description" class="col-form-label">Description</label>
                                                                <input class="form-control" name="description" readonly value="{{ $pay->description ?? ''}}" id="description">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="input" class="col-form-label">Input</label>
                                                                <input class="form-control" name="input" oninput="sum()" type="number" id="input">
                                                            </div>
                                                            <!-- <div class="col-md-6">
                                                                <label for="money" class="col-form-label">Money</label>
                                                                <input class="form-control" name="money" type="number" oninput="pay()" id="money">
                                                            </div> -->
                                                            <div class="col-md-6">
                                                                <label for="total" class="col-form-label">Total</label>
                                                                <input class="form-control" name="total" value="0" readonly type="text" id="total">
                                                            </div>
                                                            <!-- <div class="col-md-6">
                                                                <label for="returns" class="col-form-label">Return</label>
                                                                <input class="form-control" name="returns" value="0" readonly type="number" id="returns">
                                                            </div> -->
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" id="button" class="btn btn-primary">Submit</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $('select[name="name"]').on('change', function() {
                                            var stateID = $(this).val();
                                            if (stateID) {
                                                $.ajax({
                                                    url: '/menu/cashier/get/' + stateID,
                                                    type: "GET",
                                                    dataType: "json",
                                                    success: function(data) {
                                                        $('select[name="city"]').empty();
                                                        $.each(data, function(key, value) {
                                                            $('#price_sell').val(value.price_sell);
                                                            $('#price_buy').val(value.price_buy);
                                                            $('#stock').val(value.stock);
                                                            $('#description').val(value.description);
                                                            $('#stock_hidden').val(value.stock);
                                                            $('#id').val(value.id);
                                                        });
                                                    }
                                                });
                                            } else {
                                                $('select[name="name"]').empty();
                                                console.log('gagal')
                                            }
                                        });
                                    });
                                </script>
                                <script>
                                    window.onload = function() {
                                        document.getElementById('button').disabled = true
                                    }

                                    function pay() {
                                        let money = document.getElementById('money');
                                        let returns = document.getElementById('returns');
                                        returns.value = parseInt(money.value) - parseInt(document.getElementById('totalCart').value);
                                        if (document.getElementById('returns').value < 0 || money.value == 0) {
                                            document.getElementById('buttonPay').disabled = true
                                        } else {
                                            document.getElementById('buttonPay').disabled = false
                                        }
                                    }

                                    function sum() {
                                        let stock = document.getElementById('stock_hidden').value
                                        let input = document.getElementById('input').value
                                        let price = document.getElementById('price_sell').value
                                        total = parseInt(stock) - parseInt(input)
                                        result = parseInt(price) * parseInt(input)
                                        if (!isNaN(total)) {
                                            if (total < 0 || input < 0 || total == "" || input == "") {
                                                document.getElementById('total').style.color = 'red'
                                                document.getElementById('total').value = 0
                                                document.getElementById('stock').value = 0
                                            } else {
                                                document.getElementById('total').style.color = 'black'
                                                document.getElementById('stock').value = total
                                                document.getElementById('total').value = result
                                            }
                                        }
                                    }

                                    document.addEventListener('input', function() {
                                        let total = document.getElementById('total').value
                                        if (parseInt(total) <= 0) {
                                            document.getElementById('button').disabled = true
                                        } else {
                                            document.getElementById('button').disabled = false
                                        }
                                    })
                                    // if(document.getElementById('totalCart')){
                                    //     document.getElementById('buttonPay').disabled = true
                                    // }else{
                                    //     document.getElementById('buttonPay').disabled = false
                                    // }
                                    function rupiah() {
                                        angka = document.getElementById('price').value
                                        let reverse = angka.toString().split('').reverse().join('')
                                        ribuan = reverse.match(/\d{1,3}/g)
                                        ribuan = ribuan.join(',').split('').reverse().join('')
                                        return ribuan
                                    }
                                </script>
                                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
                                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
                                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
                                <!-- tutup -->
                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">
                                    <form action="{{ route('menu.cashier.purchase') }}" method="post">
                                        @csrf
                                        <button type="button" class="mdc-button mdc-button--raised w-100" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@getbootstrap" id="buttonCart">Cart</button>
                                        <button type="submit" id="buttonPay" class="mdc-button mdc-button--raised w-100 filled-button--danger">Pay</button>
                                        <input type="hidden" id="totalCart" name="total" value="{{ $total }}">
                                        <input type="hidden" name="input" value="{{ $stock }}">
                                        <input type="hidden" name="stock" value="12">
                                        <input type="hidden" name="profit" value="{{ $profit }}">
                                </div>
                                <div class="mdc-layout-grid__inner">
                                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-4-tablet">
                                        <div class="mdc-card info-card info-card--success">
                                            <div class="card-inner">
                                                <h5 class="card-title">Total Goods Price</h5>
                                                <h5 class="font-weight-light pb-2 mb-1 border-bottom">{{ $total }}</h5>
                                                <p class="tx-12 text-muted">target reached</p>
                                                <div class="card-icon-wrapper">
                                                    <i class="material-icons">dvr</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-4-tablet">
                                        <div class="mdc-card info-card info-card--danger">
                                            <div class="card-inner">
                                                <h5 class="card-title">Profit</h5>
                                                <h5 class="font-weight-light pb-2 mb-1 border-bottom">{{ $profit }}</h5>
                                                <p class="tx-12 text-muted">target reached</p>
                                                <div class="card-icon-wrapper">
                                                    <i class="material-icons">attach_money</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-4-tablet">
                                        <div class="mdc-card info-card info-card--primary">
                                            <div class="card-inner">
                                                <h5 class="card-title">Total Input Stock</h5>
                                                <h5 class="font-weight-light pb-2 mb-1 border-bottom">{{ $stock }}</h5>
                                                <p class="tx-12 text-muted">target reached</p>
                                                <div class="card-icon-wrapper">
                                                    <i class="material-icons">credit_card</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="template-demo">
                                    <div class="mdc-layout-grid__inner">
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <div class="mdc-text-field mdc-text-field--outlined">
                                                <input type="number" id="money" oninput="pay()" value="0" class="mdc-text-field__input" name="money" value="" required id="text-field-hero-input">
                                                <div class="mdc-notched-outline">
                                                    <div class="mdc-notched-outline__leading"></div>
                                                    <div class="mdc-notched-outline__notch">
                                                        <label for="text-field-hero-input" class="mdc-floating-label">Money</label>
                                                    </div>
                                                    <div class="mdc-notched-outline__trailing"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <div class="mdc-text-field mdc-text-field--outlined">
                                                <input type="number" id="returns" value="0" class="mdc-text-field__input" name="returns" value="" required id="text-field-hero-input">
                                                <div class="mdc-notched-outline">
                                                    <div class="mdc-notched-outline__leading"></div>
                                                    <div class="mdc-notched-outline__notch">
                                                        <label for="text-field-hero-input" class="mdc-floating-label">Return</label>
                                                    </div>
                                                    <div class="mdc-notched-outline__trailing"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            if (document.getElementById('totalCart').value == 0 || document.getElementById('returns').value < 0 || document.getElementById('money').value <= 0) {

                                                document.getElementById('buttonPay').disabled = true
                                            } else {
                                                document.getElementById('buttonPay').disabled = false
                                            }
                                        </script>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                                            <div class="mdc-card p-0">
                                                <div class="table-responsive">
                                                    <table class="table table-hoverable">
                                                        <thead>
                                                            @php
                                                            $nomor = 1;
                                                            @endphp
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Name</th>
                                                                <th>Price</th>
                                                                <th>Stock Input</th>
                                                                <th>Total</th>
                                                                <th>Description</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        @foreach($cart as $cart)
                                                        <tbody>
                                                            <tr>
                                                                <td>{{ $nomor++.'.' }}</td>
                                                                <td>{{ $cart->name }}</td>
                                                                <td>{{ $cart->price_sell }}</td>
                                                                <td>{{ $cart->stock_input }}</td>
                                                                <td>{{ $cart->total }}</td>
                                                                <td>{{ $cart->description }}</td>
                                                                <td><a href="{{ route('menu.cashier.delete',$cart->id) }}" class="mdc-button mdc-button--unelevated filled-button--danger mdc-ripple-upgraded" style="--mdc-ripple-fg-size:56px; --mdc-ripple-fg-scale:1.969919748761058; --mdc-ripple-fg-translate-start:-26.600006103515625px, -21px; --mdc-ripple-fg-translate-end:18.816665649414062px, -10px;">Delete<i class="material-icons">delete</i></a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                        <input type="hidden" name="stock_input[]" value="{{ $cart->stock_input }}">
                                                        <input type="hidden" name="goods_id[]" value="{{ $cart->goods_id }}">
                                                        <input type="hidden" name="id[]" value="{{ $cart->id }}">
                                                        <input type="hidden" name="name[]" value="{{ $cart->name }}">
                                                        <input type="hidden" name="description[]" value="{{ $cart->description }}">
                                                        <input type="hidden" name="price_sell[]" value="{{ $cart->price_sell }}">
                                                        <input type="hidden" name="price_buy[]" value="{{ $cart->price_buy }}">
                                                        @endforeach
                                                        </form>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </main>
</div>

@endsection
