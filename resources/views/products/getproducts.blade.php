<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow">
    <meta name="keywords" content="{{$keywords}}">
    <meta name="description" content="{{$meta_description}}">
    <meta name="author" content="YounasDev">

    <!-- MEDA FOR SEARCH ENGINES AND SOCIAL PLATFORMS -->
    <meta property="og:title" content="{{$meta_title}}">
    <meta property="og:description" content="{{$meta_description}}">
    <meta property="og:image" content="{{$image}}">
    <meta property="og:site_name" content="YounasDev" />
    <meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:publisher" content="YounasDev" />


    <!-- TWITTER CARD -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@'YounasDev' | {{$title}}" />
    <meta name="twitter:title" content="{{$meta_title}}" />
    <meta name="twitter:description" content="{{$meta_description}}" />
    <meta name="twitter:image" content="{{$image}}" />

    <link rel="icon" href="{{url('public/web/images/favicon.png')}}">
    <link rel="canonical" href="{{url()->current()}}" />
    <title>{{$title}}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"
        integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous">
    </script>
    <style type="text/css">
    a {
        text-decoration: none !important;
    }

    .nopad {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    /*image gallery*/
    .image-checkbox {
        cursor: pointer;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        border: 4px solid transparent;
        margin-bottom: 0;
        outline: 0;
    }

    .image-checkbox input[type="checkbox"] {
        display: none;
    }

    .image-checkbox-checked {
        border-color: #4783B0;
    }

    .image-checkbox .fa {
        position: absolute;
        color: #4A79A3;
        background-color: #fff;
        padding: 10px;
        top: 0;
        right: 0;
    }

    .image-checkbox-checked .fa {
        display: block !important;
    }

    @media (max-width: 768px) {
        table th {
            font-size: 14px;
        }

        table td:nth-child(2),
        table th:nth-child(2) {
            width: 50%;
        }
    }

    .table td,
    .table th {
        vertical-align: middle;
    }

    /*card*/
    .card {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        transition: 0.3s;
        border-radius: 20px;
    }

    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }

    .card-img-top {
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
    }

    .price {
        font-size: 1.5rem;
        font-weight: bold;
        color: #ff4500;
    }

    .payment-option {
        cursor: pointer;
    }

    .payment-option.selected {
        border: 2px solid blue;
    }

    input[type="radio"] {
        display: none;
    }

    input[type="radio"]:checked+label .card {
        border: 3px solid #007bff;
    }

    @media (min-width: 576px) {
        .card-title {
            font-size: 1.2rem !important;
        }
    }

    @media (min-width: 768px) {
        .card-title {
            font-size: 1.5rem !important;
        }
    }

    @media (min-width: 992px) {
        .card-title {
            font-size: 1.8rem !important;
        }
    }

    @media (min-width: 1200px) {
        .card-title {
            font-size: 2rem !important;
        }
    }
    </style>
</head>

<body style="background-color: black;">
    <!-- Add orders Modal -->
    <div id="add_orders" class="custom-modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#535da1;">
                    <h2 class="text-center  p-3 text-white font-weight-bold">OrderNow</h2>
                    <a class="btn-sm btn-success text-dark" target="_blank" href="{{ url('customer-service') }}"
                        style="text-decoration: none; background-color: #ffe400;">Help</a>
                </div>
                <div class="modal-body">
                    <form action="{{ route('create.order.store') }}" method="POST" accept-charset="utf-8"
                        enctype="multipart/form-data" id="order_form">
                        @csrf
                        <div class="row">
                            <div class="col-lg-8 offset-lg-2">
                                <h2 class="text-center">Our Products</h2>
                                <p class="text-center d-none">Lorem ipsum dolor sit amet, consectetur adipisicing elit
                                </p>
                            </div>
                            @foreach ($products as $product)
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 mt-3 mb-3">
                                <input type="radio" id="p{{$product->id}}" name="product" @if ($product->id == 1)
                                {{'checked'}} @endif value="{{$product->id}}">
                                <label for="p{{$product->id}}">
                                    <div class="card" style="cursor: pointer;">
                                        <img src="{{$product->image}}" class="card-img-top">
                                        <div class="card-body text-center">
                                            <h5 class="card-title font-weight-bold">{{$product->name}}</h5>
                                            <a href="{{$product->website}}" class="btn-sm text-white"
                                                style="background-color:#535da1;">Website</a>
                                            <a href="#" class="d-none btn-sm btn-danger">YouTube</a>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @endforeach
                            {{-- book_details --}}
                            <div id="book_details">
                                <div class="col-sm-12">
                                    <h2 class="text-center font-weight-bold"><?=$product_b->name?></h2>
                                    <p><?=$product_b->desc?></p>
                                </div>
                                <div class="col-sm-12 mt-3">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-sm" id="order_teble_1">
                                            <thead>
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col">Book Name</th>
                                                    <th scope="col">Image</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">Qty</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $count = 1; ?>
                                                @foreach ($booking_details as $booking_b)

                                                <tr>
                                                    <th scope="row">{{$count}}</th>
                                                    <td class="checkbox-td">
                                                        <div class="form-group">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox"
                                                                    class="custom-control-input checkbox-group"
                                                                    id="{{$booking_b->id}}" value="{{$booking_b->id}}"
                                                                    name="subproduct[]">
                                                                <label class="custom-control-label"
                                                                    for="{{$booking_b->id}}">{{$booking_b->name}}</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <label class="image-checkbox">
                                                            <img class="img-responsive" width="100" height="auto"
                                                                src="{{$booking_b->image}}" />
                                                        </label>
                                                    </td>
                                                    <td id="price">${{$booking_b->price}}</td>
                                                    <td class="qty">1</td>
                                                </tr>
                                                <?php $count++; ?>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4" class="font-weight-bold">Total</td>
                                                    <td id="total" class="font-weight-bold"></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            {{-- end book_details --}}
                            {{-- blogging_details --}}
                            <div id="blogging_details">
                                <div class="col-sm-12">
                                    <h2 class="text-center font-weight-bold">{{$product_s->name}}</h2>
                                    <p>{{$product_s->desc}}</p>
                                </div>
                                <div class="col-lg-6 offset-lg-3 mt-3">
                                    <div id="order_teble_2" class="text-center">
                                        <div class="card" style="width_: 18rem;">
                                            <img src="{{$code_details->image}}" class="card-img-top img-fluid">
                                            <div class="card-body">
                                                <h5 class="card-title text-center">{{$code_details->name}}</h5>
                                                <hr>
                                                <p class="card-text text-center">
                                                    <span class="price">${{$code_details->price}}</span>
                                                </p>
                                                <div class="text-center">
                                                    <a href="#" class="btn-sm text-white"
                                                        style="background-color:#535da1;">Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- end blogging_details --}}

                            <div class="col-sm-12 mt-5 mb-3">
                                <h2 class="text-center font-weight-bold">Customer Information</h2>
                            </div>
                            <input type="hidden" name="created_by" value="self">
                            <input type="hidden" name="order_type" value="product">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input class="form-control" type="text" name="customer_name" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="form-control" type="text" name="customer_email" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input class="form-control" type="text" name="customer_phone" required>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Note</label>
                                    <input class="form-control" type="text" name="note">
                                </div>
                            </div>
                            <div class="col-sm-12 mt-3 mb-3">
                                <h2 class="text-center font-weight-bold">Payment</h2>
                            </div>
                            <div class="col-6 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                <img src="{{ url('public/assets/img/payment/jazzcash.png') }}"
                                    class="payment-option img-thumbnail img-responsive" data-name="JazzCash"
                                    data-details="Pay via JazzCash and enjoy quick and secure transactions.
                            <p>Title: Muhammad Yousaf</p>
                            <p>Account: +92-304-7222-723</p>
                            ">
                            </div>
                            <div class="col-6 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                <img src="{{ url('public/assets/img/payment/easypasa.png') }}"
                                    class="payment-option img-thumbnail img-responsive" data-name="EasyPaisa"
                                    data-details="Pay via EasyPaisa and enjoy quick and secure transactions.
                            <p>Title: Muhammad Younas</p>
                            <p>Account: +92-317-4340-853</p>
                            ">
                            </div>
                            <div class="col-6 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                <img src="{{ url('public/assets/img/payment/ubl.png') }}"
                                    class="payment-option img-thumbnail img-responsive p-4" data-name="UBL Omni"
                                    data-details="Pay via UBL Omni and enjoy quick and secure transactions.
                            <p>Title: Muhammad Younas</p>
                            <p>Account: 1097263183584</p>
                            ">
                            </div>
                            <div class="col-6 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                <img src="{{ url('public/assets/img/payment/payoneer.png') }}"
                                    class="payment-option img-thumbnail img-responsive p-4" data-name="Payoneer"
                                    data-details="Pay via Payoneer and enjoy quick and secure transactions.
                            <p>Title: Muhammad Younas</p>
                            <p>Account: hm.younas22@gmail.com</p>
                            ">
                            </div>
                            <div class="col-12">
                                <div id="payment-details" class="mb-5 mt-3"></div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Payment Option</label>
                                    <input type="text" class="form-control has-danger" name="payment_method"
                                        id="payment_method" value="" required>
                                </div>
                            </div>
                            <div class="col-sm-4 ">
                                <div class="form-group">
                                    <label>Add Payment</label>
                                    <input type="text" class="form-control has-danger" name="total_payment"
                                        id="total_payment" required>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Upload Payment screenshoot</label>
                                    <input class="form-control" type="file" name="screenshoot" required>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section text-center mt-3">
                            <button class="btn btn-danger submit-btn" id="submit-button">Order</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add orders Modal -->
    <script type="text/javascript">
    // update cart price on book selection
    var table = $("#order_teble_1");
    var total = 0;

    function calculateBookTotal() {
        total = 0;
        var rows = table.find("tbody tr");
        rows.each(function() {
            var qty = $(this).find(".qty").text();
            var price = $(this).find("#price").text();
            price = parseFloat(price.substring(1));
            if ($(this).find("input[name='subproduct[]']:checked").length) {
                total += qty * price;
            }
        });
        $("#total").text("$" + total.toFixed(2));
        $("#total_payment").val("$" + total.toFixed(2));
    }
    table.on("input", calculateBookTotal);
    calculateBookTotal();
    // form validation
    $(document).ready(function() {
        $('#order_form').submit(function(e) {
            var selectedProduct = $('input[name="product"]:checked').val();
            var subproductChecked = $('input[name="subproduct[]"]:checked').length > 0;
            if (selectedProduct == 1 && !subproductChecked) {
                e.preventDefault();
                alert("Please select at least one book");
            }
        });
    });
    // addtotal_payment
    $(document).ready(function() {
        $('input[name="product"]').change(function() {
            addtotal_payment();
        });
    });

    function addtotal_payment() {
        // Code to execute when radio button is checked
        var selectedProduct = $('input[name="product"]:checked').val();
        console.log("Selected product: " + selectedProduct);
        if (selectedProduct == 2) {
            $("#total_payment").val('$' + 25);
        } else if (selectedProduct == 3) {
            $("#total_payment").val('$' + 12);
        } else {
            $("#total_payment").val($('#total').text());
        }
    }
    // end addtotal_payment
    // tabs update hide/show
    $('#blogging_details').hide();
    $('#web_designing_details').hide();
    $('#p1').click(function() {
        $('#book_details').show();
        $('#blogging_details').hide();
        $('#web_designing_details').hide();
    });
    $('#p2').click(function() {
        $('#book_details').hide();
        $('#blogging_details').show();
        $('#web_designing_details').hide();
    });
    $('#p3').click(function() {
        $('#book_details').hide();
        $('#blogging_details').hide();
        $('#web_designing_details').show();
    });
    // paymentOptions update
    const paymentOptions = document.querySelectorAll(".payment-option");
    const paymentDetails = document.querySelector("#payment-details");
    const payment_method = document.querySelector("#payment_method");
    paymentOptions.forEach(option => {
        option.addEventListener("click", event => {
            paymentOptions.forEach(option => {
                option.classList.remove("selected");
            });
            event.target.classList.add("selected");
            paymentDetails.innerHTML = `
<h3 style='margin-top:10px;'>${event.target.dataset.name}</h3>
<p>${event.target.dataset.details}</p>
`;
            payment_method.value = `${event.target.dataset.name}`;
        });
    });
    </script>
</body>

</html>