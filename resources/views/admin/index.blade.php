@include("admin.layouts.header")
        <div class="container-fluid" style="background-color:#F6F6F7;">
            <!--  Row 1 -->
            <div class="row">
                <div class="col">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title fw-normal bg-white py-2 px-3 rounded-pill">Dashboard > Dashboard</h5>
                        <div class="d-flex">
                            <button class="btn btn-dark mr-2 rounded-0" type="button" data-toggle="modal" data-target="#broadcastModal">
                                <img src="{{asset('assets/images/icons/broadcast-light.svg')}}">
                                Send Broadcast
                            </button>
                            <a href="{{url('/users')}}" class="btn btn-primary rounded-0">
                                <img src="{{asset('assets/images/icons/user-plus-light.svg')}}" />
                                Customers
                            </a>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6">
                            <div class="bg-primary p-3">
                                <span class="text-primary text-white">Total Customers</span>
                                <h3 class="text-white stats"></h3>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 mt-3 mt-xl-0 mt-lg-0 mt-md-0 mt-sm-0">
                            <div class="bg-secondary p-3">
                                <span class="text-primary">Customers (<span class="stat-percent fs-3 fw-semibold"> </span> <span class="fs-2">vs</span> last week)</span>
                                <h3 class="stats"></h3>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 mt-3 mt-xl-0 mt-lg-0 mt-md-0">
                            <div class="bg-secondary p-3">
                                <span class="text-primary">Transactions (<span class="stat-percent fs-3 fw-semibold"> </span> <span class="fs-2">vs</span> last week)</span>
                                <h3 class="stats"></h3>
                            </div>
                        </div>
                         <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 mt-3 mt-xl-0 mt-lg-0 mt-md-0">
                            <div class="bg-secondary p-3">
                                <span class="text-primary">Transactions (<span class="stat-percent fs-3 fw-semibold"> </span> <span class="fs-2">vs</span> last month)</span>
                                <h3 class="stats"></h3>
                            </div>
                        </div>
                    </div>


                    <div class="row mt-5">
                        <!-- Start Of Data Table -->
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-semibold">Transaction History</span>
                                <span class="fw-bolder">view</span>
                            </div>
                            <table class="transactions-table table table-bordered table-responsive bg-white text-nowrap">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                        <!-- End Of Data Table -->
                        <!-- Start Of Chart -->
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-xl-0 mt-lg-0 mt-md-0 mt-3 mt-sm-3">
                            <div class="card w-100">
                                <div class="card-body">
                                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                                      <div class="mb-3 mb-sm-0">
                                        <span class="card-title fw-semibold">Total Transactions</span>
                                        <h3 class="fw-semibold text-primary" id="chart-transactions"></h3>
                                      </div>
                                      <!--<div>
                                        <select class="form-select" name="month">
                                            <option value="0">January</option>
                                            <option value="1">February</option>
                                            <option value="2">March</option>
                                            <option value="3">April</option>
                                            <option value="4">May</option>
                                            <option value="5">June</option>
                                            <option value="6">July</option>
                                            <option value="7">August</option>
                                            <option value="8">September</option>
                                            <option value="9">October</option>
                                            <option value="10">November</option>
                                            <option value="11">December</option>
                                        </select>
                                      </div>-->
                                    </div>
                                    <div id="chart"></div>
                                </div>
                            </div>
                        </div>
                        <!-- End Of Chart -->
                    </div>

                    @include('admin.modals.broadcast-modal')
                    @include('customer.modals.change-password-modal')
                </div>
            </div>
            <!--  End of Row 1 -->
        </div>
    </div>
</div>
<script src="{{asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/slim.min.js')}}"></script>
<script src="{{asset('assets/js/popper.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>

<script src="{{asset('assets/libs/axios/axios.js')}}"></script>
<script src="{{asset('assets/libs/apexcharts/dist/apexcharts.min.js')}}"></script>
<script src="{{asset('assets/libs/simplebar/dist/simplebar.js')}}"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script>
    let token = $("meta[name='csrf-token']").attr("content");
    let baseUrl = $("meta[name='base-url']").attr("content");

    function getStats(statistics){
        let results = statistics;
        $(".stats").eq(0).text(results?.customers_count);
        $(".stats").eq(1).text(results?.customers_last_week[0]);
        $(".stats").eq(2).text("₦"+parseInt(results?.transactions_cost_last_week[0]).toLocaleString());
        $(".stats").eq(3).text("₦"+parseInt(results?.transactions_cost_last_month[0]).toLocaleString());
        $(".stat-percent").eq(0).text("+"+results?.customers_last_week[1].toFixed(0)+"%").css("color", "#128807");
        $(".stat-percent").eq(1).text("+"+results?.transactions_cost_last_week[1].toFixed(0)+"%").css("color", "#128807");
        $(".stat-percent").eq(2).text("+"+results?.transactions_cost_last_month[1].toFixed(0)+"%").css("color", "#128807");
    };
    getStats(@json($statistics));

    $("#broadcastModal #searchUser").on("keyup", function() {
        var searchTerm = $(this).val().toLowerCase();
        var matchFound = false;
        $("#recipient option").each(function(index, element) {
            var optionText = $(this).text().toLowerCase();
            if (optionText.indexOf(searchTerm) !== -1) {
                $(this).show();
                if (!matchFound) {
                    $("#recipient").val($(this).val()); // Select the first match
                    var email = $("#recipient").find('option:selected').data('email');
                    $("#broadcastModal input[name='email']").val(email); 
                    matchFound = true;
                }
            } else {
                $(this).hide();
            }
        });

        // Reset selection if no match is found
        if(!matchFound) {
            $("#recipient").val('');
        }
    });

    function getCustomers(){
        const config = {
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
                "X-Requested-With": "XMLHttpRequest"
            }
        };
        axios.get(`${baseUrl}/admin/get-all-customers`, config)
        .then((res) => {
            let users = res.data.results;
            users.forEach(function(user, index){
                $("select[name='recipient']").append(`
                    <option value=${user.id} data-email=${user.email}>${user.firstname+" "+user.lastname}</option>
                `);
            });
        });
    };
    getCustomers();

    const status = {
        pending: "custom-bg-warning",
        success: "custom-bg-success",
        failed: "custom-bg-danger"
    };

    function getRandomColor(){
        const r = Math.floor(Math.random() * 256);
        const g = Math.floor(Math.random() * 256);
        const b = Math.floor(Math.random() * 256);

        //Convert the RGB components to headecimal format
        const colorHex = `#${r.toString(16)}${g.toString(16)}${b.toString(16)}`;
        return colorHex;
    }

    const getInitials = (name) => {
        let fullname = name.split(" ");
        let initials = "";
        for(let i=0; i<fullname.length; i++){
            initials += fullname[i].charAt(0);
            if (i === 1) {
                break; // Break the loop after extracting the second initial
            }
        }
        return initials;
    }

    function getTransactions(data){
        let transactions = data.slice(0, 5);

        $(".transactions-table tbody").empty();
        transactions.forEach(function(transaction, index){
            let name = transaction.wallet.user.firstname+" "+transaction.wallet.user.lastname;
            const userCard = (transaction.wallet.user.photo == null ) ? `
                <td scope="row">
                    <div class="user-card">
                        <div class="user-avatar ${status[transaction.status]}">
                            <span>${getInitials(name)}</span>
                        </div>
                        <div class="user-name">
                            <span class="fw-normal">
                            ${name}
                            </span>
                        </div>
                    </div>
                </td>
            ` : `
                <td scope="row">
                    <div class="user-card">
                        <div class="user-avatar">
                            <img src="${transaction.wallet.user.photo}" class="w-100 h-100">
                        </div>
                        <div class="user-name">
                            <span class="fw-normal">${name}</span>                        
                        </div>
                    </div> 
                </td>
            `;

            $(".transactions-table tbody").append(`
                <tr>
                    ${userCard}
                    <td scope="row"><b>₦</b>${transaction.amount.toLocaleString()}</td>
                    <td scope="row">${transaction.created_at}</td>
                    <td scope="row">
                        <span class="py-2 badge rounded-2 fw-semibold ${status[transaction.status]}">
                        ${transaction.status.charAt(0).toUpperCase() + transaction.status.slice(1)}
                        </span>
                    </td>
                </tr>  
            `);
        })
    };
    getTransactions(@json($transactions));

    $("#send").on("click", function(event){
        event.preventDefault();
        let url = $(this).data("url");
        let btn = $(this);
        btn.html(`<img src="{{asset('assets/images/loader.gif')}}" id="loader-gif">`);
        btn.attr("disabled", true);
        let inputs = {};
        $("#broadcastModal").find("input, select, textarea").each(function(){
            var fieldName = $(this).attr("name");
            var fieldType = $(this).prop("tagName").toLowerCase();
            if(fieldType === "input" || fieldType === "select" || fieldType === "textarea") {
                if(fieldName != "search" && fieldName != "email"){
                    inputs[fieldName] = $(this).val();
                }
            }
        });

        alert(JSON.stringify(inputs));
        let errorEl = $('#broadcastModal .error');
        let msg = $('#broadcastModal .message');
        errorEl.text('');
        msg.text('');
        // Append loader immediately
        setTimeout(() => {
            const config = {
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer "+ userToken
                }
            };
            axios.post(url, inputs, config)
            .then(function(response){
                let message = response.data.message;
                msg.css("color", "green").text(message);
                btn.attr("disabled", true).text("Notifications sent");
            })
            .catch(function(error){
                let errors = error.response.data.error;
                if(errors.title){
                    errorEl.eq(0).text(errors.title);
                }
                if(errors.message){
                    errorEl.eq(1).text(errors.message);
                }

                btn.attr("disabled", false).text("Send Now");
            });
        }, 100); // Delay submission by 100 milliseconds
    });

    $('#recipient').change(function() {
        var email = $(this).find('option:selected').data('email');

        $("#broadcastModal input[name='email']").val(email); 
    });

    var chart = {
        series: [],
        title: {text: "Total Revenues"},
        noData: {text: "Loading..."},
        chart: {
            type: "line",
            height: 345,
            foreColor: "#adb0bb",
            fontFamily: 'inherit',
            offsetX: -15
        },
        colors: ["#d8383e"],
        fill: {
            colors: ["#000"],
            type: "gradient",
            gradient: {
                shapeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.9,
                stops: [0, 90, 100],
                inverseColors: false,
                shade: "dark",
                type: "vertical"
            }
        },
        grid: {
            borderColor: "rgba(0,0,0,0.1)",
            strokeDashArray: 3,
            xaxis: {
                lines: {
                   show: true
                },
            },
        },
        xaxis: {
            type: "category",
            categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            labels: {
                style: { cssClass: "grey--text lighten-2--text fill-color" },
            },
        },
        yaxis: {
            show: true,
            min: 0,
            // max: 400,
            tickAmount: 4,
            labels: {
                style: {
                   cssClass: "grey--text lighten-2--text fill-color",
                },
                formatter: function(value){
                    return "₦"+value;
                }
            }
        },
        stroke: {
            show: true,
            curve: "smooth",
            width: 3,
            lineCap: "butt"
        }
    };
    var chart = new ApexCharts(document.querySelector("#chart"), chart);
    chart.render();

    function fetchChartData(){
        const config = {
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
                "X-Requested-With": "XMLHttpRequest"
            }
        };
        axios.get(`${baseUrl}/get-chart-data`, config)
        .then((res) => {
            let revenues = res.data.results;
            chart.updateSeries([{ 
                name: "Transactions", 
                data: revenues
            }]);
        });
    }
    fetchChartData();
</script>
@include("admin.layouts.footer")