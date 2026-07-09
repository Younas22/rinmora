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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
</script>
</script>
<style type="text/css">
a {
text-decoration: none !important;
}
.nopad {
padding-left: 0 !important;
padding-right: 0 !important;
}
/* //////////////////////////////////////// */
.custom-modal .modal-header {
  position: sticky;
  top: 0;
  left: 0;
  width: 100%;
  z-index: 9999;
}
.book_acconut h6{
    color: white;
    font-size: 24px;
    margin-bottom:0;
}
@media(max-width: 768px) and (min-width: 0px) {
.book_acconut h6{
    color: white;
    font-size: 16px;
    margin:auto;
}
.book_count input, .price_count input{
  margin-left: 10px;
}
.bar_div {
    display: block;
    width: 5px;
    height: 0px;
    margin: -2px 10px !important;
   color: silver;
    font-weight:bold;
} 
}
.book_count input, .price_count input{
  align-items: center;
  justify-content: center;
  height: 30px;
  width: 30px;
  border: 1px solid #ccc;
  margin-right: 10px;
  font-size: 14px;
  font-weight: bold;
}

.bar_div {
    display: block;
    width: 5px;
    height: 0px;
    margin: 3px 10px;
    color: #fff;
    font-weight:bold;
} 

.nav-link {
color: rgba(0, 0, 0, 0.7);
border: 1px solid #dc3545 !important;
background-color: transparent !important;
padding: 16px !important;
margin: 8px 10px 0 10px;
font-weight: bold;
border-radius: 15px !important;
}
.nav-link:hover {
background-color: #dc3545 !important;
color: #fff;
}
.nav-link.active {
background-color: #dc3545 !important;
color: rgba(0, 0, 0, 0.7) !important;
}
@media(max-width: 768px) and (min-width: 0px) {
.nav-link {
color: rgba(0, 0, 0, 0.7);
border: 1px solid #dc3545 !important;
background-color: transparent !important;
padding: 8px !important;
font-weight: 500 !important;
display: flex !important;
}
.all-button button {
padding: 8px 12px 8px 12px !important;
}
}
.btn-outline-primary {
    border-color: transparent;
}
.btn_color{
    border: none;
}
.btn-check {
position: absolute;
clip: rect(0px,60px,200px,0px);
pointer-events: none;
z-index: 1;
margin: 8px;
}
.check_box label{
padding: 0.05rem 0.07rem;
font-size: 1rem;
border-radius: 1.25rem;
}

/* /////////////// */
.btn-check {
    position: absolute;
    left: -9999px;
    right: 20px;
}

.btn-check + label {
    cursor: pointer;
    display: block;
    position: relative;
}


.btn-check:focus + label:before {
    border-color: #007bff;
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
}

.btn-check:checked:focus + label:before {
    border-color: #007bff;
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
}

.btn-check:focus:not(:checked) + label:before {
    border-color: #007bff;
}
.btn-check:checked + label:after {
    content: "\2713";
    display: block;
    width: 24px;
    height: 24px;
    margin-right: 10px;
    background: #007bff;
    border-radius: 50%;
    position: absolute;
    top: 8px;
    left: 10px;
}

.btn-check:checked:focus + label:before {
    border-color: #007bff;
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
}

.btn-check:checked:focus + label:after {
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
}
/* /////////////////////////////////////// */
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
.card-body {
padding: 1rem 0.3rem;
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
</style>
</head>
<body style="background-color: black;">
<!-- Add orders Modal -->
<div id="add_orders" class="custom-modal" role="dialog">
<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
<div class="modal-content">
<div class="modal-header" style="background-color:#535da1;">
<h2 class="text-center py-3 text-white font-weight-bold">Order</h2>
        <div class="book_acconut d-flex align-self-end">
          <div class="book_count d-flex">
            <h6 id="total_book">Books: 0</h6>
          </div>
          <div class="bar_div">
            <span>&#124;</span>
          </div>
          <div class="price_count d-flex">
            <h6 id="total_cost">Price: $0</h6>
          </div>
        </div>
{{-- <a class="btn-sm btn-success text-dark" target="_blank" href="{{ url('customer-service') }}"
style="text-decoration: none; background-color: #ffe400;">Help</a> --}}

<a class="btn-sm btn-success text-dark" target="_blank" href="https://www.ebookstatus.com/"
style="text-decoration: none; background-color: #ffe400;">eBook Status</a>

</div>
<div class="modal-body">
<form action="{{ route('create.order.store') }}" method="POST" accept-charset="utf-8"enctype="multipart/form-data" id="order_form">
    @csrf
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <h2 class="text-center">Our Products</h2>
            <p class="text-center d-none">Lorem ipsum dolor sit amet, consectetur adipisicing elit
            </p>
        </div>
        {{-- book_details --}}
        <!-- /////////////////////////////////// -->
        <div class="row justify-content-center">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-8">
                <ul class="nav nav-pills mb-5 justify-content-center" id="pills-tab" role="tablist">
                    <li class="nav-item all-button" role="presentation">
                        <button class="nav-link active" id="pills-all-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-all" type="button" role="tab"
                        aria-controls="pills-all" aria-selected="false">All</button>
                    </li>

                    <?php foreach ($product_cat as $key) {?>
                    <li class="nav-item " role="presentation">
                        <button class="nav-link book_list_data" data-cat="<?=$key->id?>" id="book_<?=$key->id?>" data-bs-toggle="pill" data-bs-target="#book_<?=$key->id?>" type="button" role="tab" aria-controls="book_<?=$key->id?>" aria-selected="false"><?=$key->title?></button>
                    </li>
                    <?php } ?>


                    </ul>
                </div>
            </div>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-all" role="tabpanel"
                    aria-labelledby="pills-all-tab">
                    <div class="row justify-content-center check_box g-3">


                        <?php foreach ($booking_details as $key) {
                            if ($key->price > 0) {
                            $name = str_replace(' ', '-', strtolower($key->name));
                            $price = '$'.$key->price;
                            $price_val = $key->price;
                            } else {
                            $price = "Free";
                            $price_val = 0;
                            }
                        ?>
                        <div class="col-lg-2 col-md-4 col-sm-6 col-6 book_list cat_<?=$key->cat_id; ?>">
                              <input type="checkbox" class="btn-check book-checkbox" name="subproduct[]" id="<?=$key->id?>" value="<?=$key->id?>" autocomplete="off">
                              <label class="btn btn-outline-primary" id="activate-btn" for="<?=$key->id?>">
                                <div class="single-team position-relative">
                                  <div class="card text-center">
                                    <img class="card-img-top" src="<?php echo $key->image; ?>" alt="<?php echo $key->name; ?>">
                                    <div class="card-body">
                                      <h6 class="card-title text-dark">
                                        <?php echo $key->name; ?>
                                      </h6>
                                    </div>
                                  </div>
                              <div class="position-absolute top-0 end-0 mt-2 me-2">
                                <span class="badge bg-danger book-price" style="font-size:17px;"><?php echo $price; ?></span>
                                <input type="hidden" id="price_val" value="<?php echo $price_val; ?>">
                              </div>
                                </div>
                              </label>
                            </div>
                        <?php
                        }
                        ?>



                      
                            
                        </div>
                    </div>


                    </div>
                    <!-- ///////////////////////////////// -->
                    {{-- end book_details --}}
                    {{-- blogging_details --}}
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

    // Show all books by default
$('.book_list').show();
// Handle click events of category buttons
$('.book_list_data').click(function () {
var cat_id = $(this).data('cat');
if (cat_id) {
// Show books with the selected cat_id and hide others
$('.book_list').hide();
$('.book_list.cat_' + cat_id).show();
} else {
// Show all books
$('.book_list').show();
}
});
$('#pills-all-tab').click(function () {
$('.book_list').show();
});


$(document).ready(function() {

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


// form validation
$('#order_form').submit(function(e) {
    var subproductChecked = $('input[name="subproduct[]"]:checked').length > 0;
    if (!subproductChecked) {
        e.preventDefault();
        alert("Please select at least one book");
    }
});



// Get references to the book count and price elements
const bookCount = document.querySelector('#total_book');
const totalCost = document.querySelector('#total_cost');

// Get references to all the book checkboxes
const bookCheckboxes = document.querySelectorAll('.book-checkbox');

// Function to update the book count and price
function updateBookCountAndPrice() {
  // Initialize the count and price to 0
  let count = 0;
  let price = 0;
  
  // Loop through all the book checkboxes
  bookCheckboxes.forEach(function(checkbox) {
    // If the checkbox is checked
    if (checkbox.checked) {
      // Increment the count
      count++;
      // Get the price of the book and add it to the total price
      const bookPrice = parseFloat(checkbox.parentNode.querySelector('#price_val').value);
      price += bookPrice;
    }
  });
  
  // Update the book count and price elements
  bookCount.textContent = `Books: ${count}`;
  totalCost.textContent = `Price: $${price.toFixed(2)}`;

  $("#total_payment").val("$" + price.toFixed(2));
}

// Add event listeners to the book checkboxes to update the count and price when they are checked or unchecked
bookCheckboxes.forEach(function(checkbox) {
  checkbox.addEventListener('change', function() {
    updateBookCountAndPrice();
  });
});


});
</script>
</body>
</html>