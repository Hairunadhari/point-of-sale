@extends('layout.app')
@section('content')
<style>
    table input,
    .total-akhir input {
        border: 0;
    }

</style>
<div class="row w-100">
    <div class="col-7">
        @foreach ($kategori as $item)
        <div class="row mb-3">
            <div class="col-9">
                <div class="row">
                    @foreach ($item->menu as $itemMenu)
                    <div class="col mb-3">
                        <div class="card menu-item" style="width: 10rem; height:10rem; cursor: pointer;"
                            data-name="{{ $itemMenu->name }}" data-price="{{ $itemMenu->price }}">
                            <img src="/storage/image/{{$itemMenu->gambar}}" style="height: 100px" class="card-img-top"
                                alt="...">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{$itemMenu->name}}</h5>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </div>
            </div>
            <div class="col-3">
                <div class="row">
                    <div class="col">
                        <div class="card" style="width: 10rem; height:10rem">
                            <div class="card-body text-center"
                                style="display: flex; justify-content: center; align-items: center">
                                <h5 class="card-title ">{{$item->kategori}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="col-5">
        <div class="row border p-3 text-center " style="background-color: #E7FBE6">
            <div class="col-2"><i class="fa-solid fa-user"></i></div>
            <h4 class="col-8">New Customer</h4>
            <div class="col-2"><i class="fa-solid fa-list"></i></div>
        </div>
        <div class="row border">

            <div class="row pt-2">
                <div class="col-12 text-center">
                    <p>Dine In</p>
                </div>
            </div>
            <hr>
            <form action="/cetak-bill" method="post">
                @csrf
                <div class="table-responsive">

                    <table class="table">

                        <thead>
                            <tr>
                                <th scope="col">Menu</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Harga</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <div class="total-akhir mb-3">
                        <label for="">Total : Rp</label>
                        <input type="number" id="allQty" readonly value="" hidden>
                        <input type="number" id="allPrice" readonly name="total" value="">
                    </div>
                </div>


                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <button type="button" id="clear-sale" class="btn btn-outline-secondary mb-3">Clear Sale</button>
                    </div>
                </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 text-center">
                <button type="button" id="saveBill" class="btn btn-primary mb-3">Save Bill</button>
                <button type="submit" class="btn btn-danger mb-3">Print Bill</button>
            </div>
        </div>
        </form>
        <div class="row" id="charge">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success chargeButton" data-bs-toggle="modal"
                data-bs-target="#exampleModalcharge">
                Charge Rp 0
            </button>
        </div>

        <!-- Modal charge-->
        <div class="modal fade" id="exampleModalcharge" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Total Charge</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body " id="modal-body">
                        <!-- Total Charge -->
                        <p>Total Charge: <strong>Rp <span id="totalCharge">0</span></strong></p>

                        {{-- {{-- <!-- Input Uang Pembeli --> --}}
                        <div class="mb-3">
                            <label for="buyerMoney" class="form-label">Uang Pembeli</label>
                            <input type="number" class="form-control" id="buyerMoney"
                                placeholder="Masukkan jumlah uang pembeli">
                        </div>

                        <!-- Total Kembalian -->
                        <p>Kembalian: <strong>Rp <span id="totalChange">0</span></strong></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if (session('warning'))
<script>
    swal({
        title: "Upss",
        text: "{{session('warning')}}",
        icon: "info",
        button: "Ok",
    });

</script>
@endif
<script>
    $(document).ready(function () {
        totalQty = 0;
        totalPrice = 0;

        $('#clear-sale').click(function () {
            $('tbody').empty();
            $('#allPrice').val(0);
            $("#totalCharge").html(0);
        });
        $('.menu-item').click(function () {
            itemName = $(this).data('name');
            itemPrice = $(this).data('price');
            cekItem = $("tbody tr").filter(function () {
                return $(this).find('input[type="text"]').val() === itemName;
            });

            if (cekItem.length) {
                qtyInput = cekItem.find('#qty');
                newQty = parseInt(qtyInput.val()) + 1;
                qtyInput.val(newQty);

                priceInput = cekItem.find('#price');
                newPrice = parseInt(priceInput.val()) + itemPrice;
                priceInput.val(newPrice);

                totalQty += 1;
                totalPrice += itemPrice;

            } else {
                qty = 1;
                $("tbody").append(`
                <tr>
                    <td><input name="order_name[]" type="text" readonly value="${itemName}"></td>
                    <td><input type="number" name="order_qty[]" id="qty" value="${qty}" readonly> </td>
                    <td>Rp <input type="number" name="order_price[]" id="price" value="${itemPrice}" readonly> </td>
                    </tr>
                    `);
                totalQty += 1;
                totalPrice += itemPrice;
            }
            console.log(totalQty);
            $('#allQty').val(totalQty)
            $('#allPrice').val(totalPrice)
            $('#charge').html(
                `<button type="button" class="btn btn-success chargeButton" data-bs-toggle="modal" data-bs-target="#exampleModalcharge">
                Charge Rp ${totalPrice}
            </button>`
            );

            $("#totalCharge").html(totalPrice);
        });


        $('#saveBill').click(function () {
            swal({
                title: "Success",
                text: "Yeeaayy Bill berhasil di Save",
                icon: "success",
                button: "Ok",
            });
        })
        $("#buyerMoney").on('input', function() {
                buyerMoney = $('#buyerMoney').val();
                totalCharge = $('#totalCharge').text();
                change = buyerMoney - totalCharge;
                
                // Tampilkan kembalian jika ada
                $('#totalChange').html(change > 0 ? change : 0);
        });
    });

</script>
@endsection
