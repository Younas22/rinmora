</div>
        <!-- /Main Wrapper -->
        
        <!-- jQuery -->
        <script src="{{url('public/assets/js/jquery-3.6.0.min.js')}}"></script>
        
        <!-- Bootstrap Core JS -->
        <script src="{{url('public/assets/js/bootstrap.bundle.min.js')}}"></script>
        
        <!-- Slimscroll JS -->
        <script src="{{url('public/assets/js/jquery.slimscroll.min.js')}}"></script>
        
        <!-- Chart JS -->
        <script src="{{url('public/assets/plugins/apexcharts/apexcharts.min.js')}}"></script>
        <script src="{{url('public/assets/js/chart.js')}}"></script>

        <!-- Select2 JS -->
        <script src="{{url('public/assets/js/select2.min.js')}}"></script>
 
        <!-- Datetimepicker JS -->
        <script src="{{url('public/assets/js/moment.min.js')}}"></script>
        <script src="{{url('public/assets/plugins/datetimepicker/js/tempusdominus-bootstrap-4.min.js')}}"></script>

        <!-- Calendar JS -->
        <script src="{{url('public/assets/js/jquery-ui.min.js')}}"></script>
        <script src="{{url('public/assets/js/fullcalendar.min.js')}}"></script>
        <script src="{{url('public/assets/js/jquery.fullcalendar.js')}}"></script>     
        
        <!-- Custom JS -->
        <script src="{{url('public/assets/js/app.js')}}"></script>
        <script src="{{url('public/assets/js/push.min.js')}}"></script>
        <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script>

// update cart price on book selection
var table = $("#order_teble_1");
var total = 0;
function calculateBookTotal() {
    total = 0;
    var rows = table.find("tbody tr");
    rows.each(function(){
        var qty = $(this).find(".qty").text();
        var price = $(this).find("#price").text();
        price = parseFloat(price.substring(1));
        if($(this).find("input[name='subproduct[]']:checked").length){
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

    if (document.querySelector("#customer_id").value === "customer_id") {
        e.preventDefault();
        alert("Please select a name.");
    }
  });
});



// addtotal_payment
$(document).ready(function(){
  $('input[name="product"]').change(function() {
    addtotal_payment();
  });
});

function addtotal_payment() {
  // Code to execute when radio button is checked
  var selectedProduct = $('input[name="product"]:checked').val();
  console.log("Selected product: " + selectedProduct);
  if(selectedProduct == 2){
      $("#total_payment").val($('.price').text());
  }else{
      $("#total_payment").val($('#total').text());
  }
}
// end addtotal_payment


// tabs update hide/show
    $('#blogging_details').hide();
    $('#web_designing_details').hide();
    $('#p1').click(function(){
        $('#book_details').show();
        $('#blogging_details').hide();
        $('#web_designing_details').hide();

    });

    $('#p2').click(function(){
        $('#book_details').hide();
        $('#blogging_details').show();
        $('#web_designing_details').hide();

    });

    $('#p3').click(function(){
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



    // add logo in public dir and use it here
const iconPath = '{{ asset('profile.jpg') }}';
 Push.create("Hello Shailesh!",{
       body: "Welcome to the Dashboard.",
       timeout: 5000,
       icon: iconPath
});

$("select[name='break_status']").change(function(){
var break_status = $(this).val();
// alert(break_status);
var token = '{{ csrf_token() }}';
$.ajax({
{{-- url: '{{ route('employee.break') }}', --}}
method: 'GET',
data: {break_status:break_status, _token:token},
success: function(data) {
alert('ok');
}
});
});
</script>

<?php 
    if (isset($yesterday_task_arr)) {
        $yesterday_task_arr = $yesterday_task_arr;
    }else{
        $yesterday_task_arr='';
    }

    if (isset($today_task_arr)) {
        $today_task_arr = $today_task_arr;
    }else{
        $today_task_arr='';
    }

    if (isset($yesterday_graph_arr)) {
        $yesterday_graph_arr = $yesterday_graph_arr;
    }else{
        $yesterday_graph_arr='';
    }

    if (isset($today_graph_arr)) {
        $today_graph_arr = $today_graph_arr;
    }else{
        $today_graph_arr='';
    }

    if (isset($get_daily_sell_arr)) {
        $get_daily_sell_arr = $get_daily_sell_arr;
    }else{
        $get_daily_sell_arr='';
    }

    if (isset($date_arr)) {
        $date_arr = $date_arr;
    }else{
        $date_arr='';
    }

    if (isset($get_monthly_sell_arr)) {
        $get_monthly_sell_arr = $get_monthly_sell_arr;
    }else{
        $get_monthly_sell_arr='';
    }

    if (isset($todays_sele_graph_arr)) {
        $todays_sele_graph_arr = $todays_sele_graph_arr;
    }else{
        $todays_sele_graph_arr='';
    }

    if (isset($monthly_sele_graph_arr)) {
        $monthly_sele_graph_arr = $monthly_sele_graph_arr;
    }else{
        $monthly_sele_graph_arr='';
    }

    if (isset($todays_task_graph_arr)) {
        $todays_task_graph_arr = $todays_task_graph_arr;
    }else{
        $todays_task_graph_arr='';
    }

    if (isset($monthly_task_graph_arr)) {
        $monthly_task_graph_arr = $monthly_task_graph_arr;
    }else{
        $monthly_task_graph_arr='';
    }

    if (isset($department_id)) {
        $department_id = $department_id;
    }else{
        $department_id='';
    }

 $selected_users = Request::segment(2); 
?>
<script>



$(function () {
    $('select[name="hr_id"]').change(function() {
        $('#employee_id option').attr('selected', false);
        $('#self option').attr('selected', false);
    });

    $('select[name="employee_id"]').change(function() {
        $('#hr_id option').attr('selected', false);
        $('#self option').attr('selected', false);
    });

    $('select[name="self"]').change(function() {
        $('#employee_id option').attr('selected', false);
        $('#hr_id option').attr('selected', false);
    });
});





!function($) {
    "use strict";
    var CalendarApp = function() {
        this.$body = $("body")
        this.$modal = $('#sell-modal'),
        this.$event = ('#external-events div.external-event'),
        this.$calendar = $('#calendar'),
        this.$saveCategoryBtn = $('.save-category'),
        this.$categoryForm = $('#add-category form'),
        this.$extEvents = $('#external-events'),
        this.$calendarObj = null
    };


    /* on select */
    CalendarApp.prototype.onSelect = function (start, end, allDay) {
            var $this = this;
            $this.$modal.modal({
                backdrop: 'static'
            });

            var selected_users = "<?php echo $selected_users; ?>";
            var department_id = "<?php echo $department_id; ?>";
            var form = $("<form></form>");
            form.append("<div class='row'></div>");
            form.find(".row")
                .append("<div class='col-md-12'><div class='form-group'><label class='control-label'>Sell</label><input class='form-control' type='text' name='sell'/></div></div>")
                .append("<div class='col-md-12'><div class='form-group'><input type='hidden' class='select form-control' name='user'></div></div>")
                .find("input[name='user']").val(selected_users);

            $this.$modal.find('.delete-event').hide().end().find('.save-event').show().end().find('.modal-body').empty().prepend(form).end().find('.save-event').unbind('click').click(function () {
                form.submit();
            }); 
            $this.$modal.find('form').on('submit', function () {
                var sell = form.find("input[name='sell']").val();
                var beginning = form.find("input[name='beginning']").val();
                var ending = form.find("input[name='ending']").val();
                var user = form.find("input[name='user']").val();
                if (sell !== null && sell.length != 0 && user !== null && user.length != 0) {
                        // alert(sell+' '+start+ user);

                const weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
                var date = new Date(start);
                var month = date.getMonth()+1;
                var created_at = date.getFullYear()+'-'+month+'-'+date.getDate();
                let day = weekday[date.getDay()];
                        



                    $this.$modal.modal('hide');
                }
                else{
                    alert('Sell and user required');

                }
                return false;
                
            });
            $this.$calendarObj.fullCalendar('unselect');
    }
    /* Initializing */
    CalendarApp.prototype.init = function() {
        /*  Initialize the calendar  */
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var form = '';
        var today = new Date($.now());

        var defaultEvents =  [{
                title: '',
                start: ''
            },
            {
                title: '',
                start: '',
                end: ''
            },
            {
                title: '',
                start: ''
            },
            {
                title: '',
                start: ''
            }];

        var $this = this;
        $this.$calendarObj = $this.$calendar.fullCalendar({
            slotDuration: '00:15:00', /* If we want to split day time each 15minutes */
            minTime: '08:00:00',
            maxTime: '19:00:00',  
            defaultView: 'month',  
            handleWindowResize: true,   
            height: $(window).height() - 200,   
            header: {
                left: 'prev,next today',
                center: 'title',
                right: ''
            },
            events: defaultEvents,
            editable: false,
            droppable: false, // this allows things to be dropped onto the calendar !!!
            eventLimit: false, // allow "more" link when too many events
            selectable: true,
            drop: function(date) { $this.onDrop($(this), date); },
            select: function (start, end, allDay) { $this.onSelect(start, end, allDay); },
            eventClick: function(calEvent, jsEvent, view) { $this.onEventClick(calEvent, jsEvent, view); }

        });

        //on new event
        this.$saveCategoryBtn.on('click', function(){
            var categoryName = $this.$categoryForm.find("input[name='category-name']").val();
            var categoryColor = $this.$categoryForm.find("select[name='category-color']").val();
            if (categoryName !== null && categoryName.length != 0) {
                $this.$extEvents.append('<div class="external-event bg-' + categoryColor + '" data-class="bg-' + categoryColor + '" style="position: relative;"><i class="mdi mdi-checkbox-blank-circle m-r-10 vertical-middle"></i>' + categoryName + '</div>')
            }

        });
    },

   //init CalendarApp
    $.CalendarApp = new CalendarApp, $.CalendarApp.Constructor = CalendarApp
    
}(window.jQuery),

//initializing CalendarApp
function($) {
    "use strict";
    $.CalendarApp.init()
}(window.jQuery);





// weekly_sales
if($('#weekly_sales').length > 0) {

<?php
$php_array = $get_daily_sell_arr;
$js_array = json_encode($php_array);
echo "var a = ". $js_array . ";\n";
?>


    var options = {
        series: [{
            name: 'Sell',
            data: a
        }, 

        // {
        //  name: ' Project Taken',
        //  data: [35, 41, 36, 26, 45]
        // }

        ],
            chart: {
            type: 'bar',
            height: 300,
            toolbar: false
        },
        colors: ['#E24F55', '#5F3B7E'],
        plotOptions: {
            bar: {
            horizontal: false,
            columnWidth: '55%',
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 3,
            colors: ['transparent']
        },
        xaxis: {
            categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        },
        fill: {
            opacity: 1,
        },
        grid: {
            yaxis: {
                lines: {
                  show: false
                }
              }
        },
        tooltip: {
            y: {
            formatter: function (val) {
                return "Inr " + val + ""
            }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#weekly_sales"), options);
    chart.render();
}



    // monthly_sales
    if($('#monthly_sales').length > 0) {
        <?php
        $date_array = $date_arr;
        $js_date_array = json_encode($date_array);
        echo "var categories_arr = ". $js_date_array . ";\n";

        $get_monthly_sell_array = $get_monthly_sell_arr;
        $js_monthly_sell_array = json_encode($get_monthly_sell_array);
        echo "var data_arr = ". $js_monthly_sell_array . ";\n";
        ?>

        var options = {
            series: [{
                name: 'Sell',
                data: data_arr
            }, 

            // {
            //  name: ' Project Taken',
            //  data: [35, 41, 36, 26, 45]
            // }

            ],
                chart: {
                type: 'bar',
                height: 300,
                toolbar: false
            },
            colors: ['#E24F55', '#5F3B7E'],
            plotOptions: {
                bar: {
                horizontal: false,
                columnWidth: '55%',
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 3,
                colors: ['transparent']
            },
            xaxis: {
                categories: categories_arr,
            },
            fill: {
                opacity: 1,
            },
            grid: {
                yaxis: {
                    lines: {
                      show: false
                    }
                  }
            },
            tooltip: {
                y: {
                formatter: function (val) {
                    return "Inr " + val + ""
                }
                }
            }
        };
    
        var chart = new ApexCharts(document.querySelector("#monthly_sales"), options);
        chart.render();
    }


//dashboard today sell
    if($('#dashboard_today_sell').length > 0) {

        <?php
        $js_today_graph_arr = json_encode($today_graph_arr);
        echo "var js_today_graph_data = ". $js_today_graph_arr . ";\n";
        ?>

        var options = {
            series: js_today_graph_data,
            colors : ['#009efb', '#E24F55'],
            chart: {
                type: 'donut',
            },
            fill: {
                type: 'normal'
            },
            legend: {
                formatter: function(val, opts) {
                    if (val == 'series-1') {
                        var val = 'Incentives';
                    }else{
                        var val = 'sell';
                    }
                    
                    

                    return val + " - " + opts.w.globals.series[opts.seriesIndex]
                },
                position: 'bottom'
            },
            plotOptions: {
                labels: {
                    show: false
                }
            },
            dataLabels: {
                enabled: false
            },
            title: {
                show: true,
            },
            donut: {
                labels: {
                    show: false,
                    name: {
                        show: true,
                    }
                }
            },
            
        };

        var chart = new ApexCharts(document.querySelector("#dashboard_today_sell"), options);
        chart.render();
    }


//dashboard yesterday sell
    if($('#dashboard_yesterday_sell').length > 0) {
        <?php
        $js_yesterday_graph_arr = json_encode($yesterday_graph_arr);
        echo "var js_yesterday_graph_data = ". $js_yesterday_graph_arr . ";\n";
        ?>

        var options = {
            series: js_yesterday_graph_data,
            colors : ['#ff943a','#5f3b7e'],
            chart: {
                type: 'donut',
            },
            fill: {
                type: 'normal'
            },
            legend: {
                formatter: function(val, opts) {
                    if (val == 'series-1') {
                        var val = 'Incentives';
                    }else{
                        var val = 'sell';
                    }
                    return val + " - " + opts.w.globals.series[opts.seriesIndex]
                },
                position: 'bottom'
            },
            plotOptions: {
                labels: {
                    show: false
                }
            },
            dataLabels: {
                enabled: false
            },
            title: {
                show: true,
            },
            donut: {
                labels: {
                    show: false,
                    name: {
                        show: true,
                    }
                }
            },
            
        };

        var chart = new ApexCharts(document.querySelector("#dashboard_yesterday_sell"), options);
        chart.render();
    }



$(function(){
    $(window).on('resize', function(){
        if(window.innerWidth < 680){
          $('.top').removeClass('text_center');
          $('.top').removeClass('text_right');
            
        }else{
          $('.top').addClass('text_center');
          $('.top').addClass('text_right');
        }
    });
});

//dashboard time
window.onload = function() {
  // Month Day, Year Hour:Minute:Second, id-of-element-container
  countUpFromTime("Jan 1, 2014 12:00:00", 'countup1');
};

function countUpFromTime(countFrom, id) {
  countFrom = new Date(countFrom).getTime();
  var now = new Date(),
      countFrom = new Date(countFrom),
      timeDifference = (now - countFrom);
    
  var secondsInADay = 60 * 60 * 1000 * 24,
      secondsInAHour = 60 * 60 * 1000;
    
  days = Math.floor(timeDifference / (secondsInADay) * 1);
  years = Math.floor(days / 365);
  if (years > 1){ days = days - (years * 365) }
  hours = Math.floor((timeDifference % (secondsInADay)) / (secondsInAHour) * 1);
  mins = Math.floor(((timeDifference % (secondsInADay)) % (secondsInAHour)) / (60 * 1000) * 1);
  secs = Math.floor((((timeDifference % (secondsInADay)) % (secondsInAHour)) % (60 * 1000)) / 1000 * 1);

  var idEl = document.getElementById(id);
  idEl.getElementsByClassName('hours')[0].innerHTML = hours;
  idEl.getElementsByClassName('minutes')[0].innerHTML = mins;
  idEl.getElementsByClassName('seconds')[0].innerHTML = secs;

  clearTimeout(countUpFromTime.interval);
  countUpFromTime.interval = setTimeout(function(){ countUpFromTime(countFrom, id); }, 1000);
}


//dashboard today task
    if($('#dashboard_today_task').length > 0) {

        <?php
        $js_today_task_arr = json_encode($today_task_arr);
        echo "var today_js_graph_data = ". $js_today_task_arr . ";\n";
        ?>

        var options = {
            series: today_js_graph_data,
            colors : ['#009efb', '#E24F55'],
            chart: {
                type: 'donut',
            },
            fill: {
                type: 'normal'
            },
            legend: {
                formatter: function(val, opts) {
                    if (val == 'series-1') {
                        var val = 'Completed';
                    }else{
                        var val = 'Task';
                    }
                    
                    

                    return val + " - " + opts.w.globals.series[opts.seriesIndex]
                },
                position: 'bottom'
            },
            plotOptions: {
                labels: {
                    show: false
                }
            },
            dataLabels: {
                enabled: false
            },
            title: {
                show: true,
            },
            donut: {
                labels: {
                    show: false,
                    name: {
                        show: true,
                    }
                }
            },
            
        };

        var chart = new ApexCharts(document.querySelector("#dashboard_today_task"), options);
        chart.render();
    }


//dashboard yesterday task
    if($('#dashboard_yesterday_task').length > 0) {
        <?php
            $js_yesterday_task_arr = json_encode($yesterday_task_arr);
            echo "var js_yesterday_task_data = ". $js_yesterday_task_arr . ";\n";
        ?>

        var options = {
            series: js_yesterday_task_data,
            colors : ['#ff943a','#5f3b7e'],
            chart: {
                type: 'donut',
            },
            fill: {
                type: 'normal'
            },
            legend: {
                formatter: function(val, opts) {
                    if (val == 'series-1') {
                        var val = 'Completed';
                    }else{
                        var val = 'Task';
                    }
                    return val + " - " + opts.w.globals.series[opts.seriesIndex]
                },
                position: 'bottom'
            },
            plotOptions: {
                labels: {
                    show: false
                }
            },
            dataLabels: {
                enabled: false
            },
            title: {
                show: true,
            },
            donut: {
                labels: {
                    show: false,
                    name: {
                        show: true,
                    }
                }
            },
            
        };

        var chart = new ApexCharts(document.querySelector("#dashboard_yesterday_task"), options);
        chart.render();
    }



$(function(){
    $(window).on('resize', function(){
        if(window.innerWidth < 680){
          $('.top').removeClass('text_center');
          $('.top').removeClass('text_right');
            
        }else{
          $('.top').addClass('text_center');
          $('.top').addClass('text_right');
        }
    });
});



//daily graph for hr

    if($('#daily_sell_hr_dashboad').length > 0) {
        <?php
            $js_todays_sele_graph_arr = json_encode($todays_sele_graph_arr);
            echo "var js_todays_sele_graph_data = ". $js_todays_sele_graph_arr . ";\n";
        ?>

        var options = {
            series: js_todays_sele_graph_data,
            colors : ['#BA4A00', '#D68910', '#2ECC71','#1ABC9C','#2980B9','#000'],
            chart: {
                type: 'donut',
            },
            fill: {
                type: 'normal'
            },
            legend: {
                formatter: function(val, opts) {
                    // console.log(val);
                    if (val == 'series-1') {
                        val = 'Mobile';
                    }
                    if (val == 'series-2') {
                        val = 'Web';
                    }
                    if (val == 'series-3') {
                        val = 'Desktop';
                    }
                    if (val == 'series-4') {
                        val = 'Website';
                    }
                    if (val == 'series-5') {
                        val = 'A2Z Service';
                    }
                    if (val == 'series-6') {
                        val = 'Graphic Design';
                    }
                    return val + " - " + opts.w.globals.series[opts.seriesIndex]
                },
                position: 'bottom'
            },
            plotOptions: {
                labels: {
                    show: false
                }
            },
            dataLabels: {
                enabled: false
            },
            title: {
                show: true,
            },
            donut: {
                labels: {
                    show: false,
                    name: {
                        show: true,
                    }
                }
            },
            
        };

        var chart = new ApexCharts(document.querySelector("#daily_sell_hr_dashboad"), options);
        chart.render();
    }


//monthly graph for hr

    if($('#monthly_sell_hr_dashboad').length > 0) {
        <?php
            $js_monthly_sele_graph_arr = json_encode($monthly_sele_graph_arr);
            echo "var js_monthly_sele_graph_data = ". $js_monthly_sele_graph_arr . ";\n";
        ?>

        var options = {
            series: js_monthly_sele_graph_data,
            colors : ['#BA4A00', '#D68910', '#2ECC71','#1ABC9C','#2980B9','#000'],
            chart: {
                type: 'donut',
            },
            fill: {
                type: 'normal'
            },
            legend: {
                formatter: function(val, opts) {
                    if (val == 'series-1') {
                        val = 'Mobile';
                    }
                    if (val == 'series-2') {
                        val = 'Web';
                    }
                    if (val == 'series-3') {
                        val = 'Desktop';
                    }
                    if (val == 'series-4') {
                        val = 'Website';
                    }
                    if (val == 'series-5') {
                        val = 'A2Z Service';
                    }
                    if (val == 'series-6') {
                        val = 'Graphic Design';
                    }
                    return val + " - " + opts.w.globals.series[opts.seriesIndex]
                },
                position: 'bottom'
            },
            plotOptions: {
                labels: {
                    show: false
                }
            },
            dataLabels: {
                enabled: false
            },
            title: {
                show: true,
            },
            donut: {
                labels: {
                    show: false,
                    name: {
                        show: true,
                    }
                }
            },
            
        };

        var chart = new ApexCharts(document.querySelector("#monthly_sell_hr_dashboad"), options);
        chart.render();
    }



//daily task graph for hr

    if($('#daily_task_hr_dashboad').length > 0) {
        <?php
            $js_todays_task_graph_arr = json_encode($todays_task_graph_arr);
            echo "var js_todays_task_graph_data = ". $js_todays_task_graph_arr . ";\n";
        ?>

        var options = {
            series: js_todays_task_graph_data,
            colors : ['#BA4A00', '#D68910', '#2ECC71','#1ABC9C','#2980B9','#000'],
            chart: {
                type: 'donut',
            },
            fill: {
                type: 'normal'
            },
            legend: {
                formatter: function(val, opts) {
                    // console.log(val);
                    if (val == 'series-1') {
                        val = 'Mobile';
                    }
                    if (val == 'series-2') {
                        val = 'Web';
                    }
                    if (val == 'series-3') {
                        val = 'Desktop';
                    }
                    if (val == 'series-4') {
                        val = 'Website';
                    }
                    if (val == 'series-5') {
                        val = 'A2Z Service';
                    }
                    if (val == 'series-6') {
                        val = 'Graphic Design';
                    }
                    return val + " - " + opts.w.globals.series[opts.seriesIndex]
                },
                position: 'bottom'
            },
            plotOptions: {
                labels: {
                    show: false
                }
            },
            dataLabels: {
                enabled: false
            },
            title: {
                show: true,
            },
            donut: {
                labels: {
                    show: false,
                    name: {
                        show: true,
                    }
                }
            },
            
        };

        var chart = new ApexCharts(document.querySelector("#daily_task_hr_dashboad"), options);
        chart.render();
    }


//monthly graph for hr

    if($('#monthly_task_hr_dashboad').length > 0) {
        <?php
            $js_monthly_task_graph_arr = json_encode($monthly_task_graph_arr);
            echo "var js_monthly_task_graph_data = ". $js_monthly_task_graph_arr . ";\n";
        ?>

        var options = {
            series: js_monthly_task_graph_data,
            colors : ['#BA4A00', '#D68910', '#2ECC71','#1ABC9C','#2980B9','#000'],
            chart: {
                type: 'donut',
            },
            fill: {
                type: 'normal'
            },
            legend: {
                formatter: function(val, opts) {
                    if (val == 'series-1') {
                        val = 'Mobile';
                    }
                    if (val == 'series-2') {
                        val = 'Web';
                    }
                    if (val == 'series-3') {
                        val = 'Desktop';
                    }
                    if (val == 'series-4') {
                        val = 'Website';
                    }
                    if (val == 'series-5') {
                        val = 'A2Z Service';
                    }
                    if (val == 'series-6') {
                        val = 'Graphic Design';
                    }
                    return val + " - " + opts.w.globals.series[opts.seriesIndex]
                },
                position: 'bottom'
            },
            plotOptions: {
                labels: {
                    show: false
                }
            },
            dataLabels: {
                enabled: false
            },
            title: {
                show: true,
            },
            donut: {
                labels: {
                    show: false,
                    name: {
                        show: true,
                    }
                }
            },
            
        };

        var chart = new ApexCharts(document.querySelector("#monthly_task_hr_dashboad"), options);
        chart.render();
    }



    // image gallery
// init the state from the input
$(".image-checkbox").each(function () {
  if ($(this).find('input[type="checkbox"]').first().attr("checked")) {
    $(this).addClass('image-checkbox-checked');
  }
  else {
    $(this).removeClass('image-checkbox-checked');
  }
});

// sync the state to the input
$(".image-checkbox").on("click", function (e) {
  $(this).toggleClass('image-checkbox-checked');
  var $checkbox = $(this).find('input[type="checkbox"]');
  $checkbox.prop("checked",!$checkbox.prop("checked"))

  e.preventDefault();
});
</script>


    </body>
</html>