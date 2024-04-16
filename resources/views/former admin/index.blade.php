@include("admin.layouts.header")
        <div class="container-fluid" style="background-color:#F5F6FA">
            <!--  Row 1 -->
            <div class="row">
                <div class="col">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-9 fw-semibold h-100">Welcome, Admin👋</h5>
                        <div class="d-flex">
                            <div class="bg-white p-2 d-flex align-items-center justify-content-center mr-2 reload-data" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                    class="lucide lucide-refresh-cw">
                                    <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/>
                                    <path d="M21 3v5h-5"/>
                                    <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/>
                                    <path d="M8 16H3v5"/>
                                </svg>
                            </div>
                            <button class="btn btn-dark mr-2 rounded-0" type="button" data-toggle="modal" data-target="#broadcastModal">
                                <img src="{{asset('assets/images/icons/broadcast-light.svg')}}">
                                Send Broadcast
                            </button>
                            <a href="{{url('/users')}}" class="btn btn-primary rounded-0">
                                <img src="{{asset('assets/images/icons/user-plus-light.svg')}}" />
                                Users
                            </a>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6">
                            <div class="bg-primary p-3">
                                <span class="text-primary text-white">Total Transactions</span>
                                <h4 class="text-white" id="transactions"></h4>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 mt-3 mt-xl-0 mt-lg-0 mt-md-0 mt-sm-0">
                            <div class="bg-secondary p-3">
                                <span class="text-primary">Doctors</span>
                                <h4 id="doctors"></h4>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 mt-3 mt-xl-0 mt-lg-0 mt-md-0">
                            <div class="bg-secondary p-3">
                                <span class="text-primary">Users</span>
                                <h4 id="users"></h4>
                            </div>
                        </div>
                         <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 mt-3 mt-xl-0 mt-lg-0 mt-md-0">
                            <div class="bg-secondary p-3">
                                <span class="text-primary">Children</span>
                                <h4 id="children"></h4>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <!-- Start Of Data Table -->
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Transaction History</span>
                                <span class="fw-bolder">view</span>
                            </div>
                            <table class="transactions-table table table-bordered table-responsive bg-white text-nowrap">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Date</th>
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
                                        <span class="card-title">Total Transactions</span>
                                        <h3 class="fw-semibold text-primary" id="chart-transactions"></h3>
                                      </div>
                                      <div>
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
                                      </div>
                                    </div>
                                    <div id="chart"></div>
                                </div>
                            </div>
                        </div>
                        <!-- End Of Chart -->
                    </div>

                    <div class="d-none">
                        <audio id="mySound" controls>
                            <source src="{{asset('assets/tunes/possuccess.mp3')}}" type="audio/mp3">
                        </audio>
                    </div>

                    @include('admin.modals.broadcast-modal')
                    @include('admin.modals.change-password-modal')
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
<script src="{{asset('assets/libs/sweetalert2/sweetalert2.all.js')}}"></script>
<script>
    let token = $("meta[name='csrf-token']").attr("content");
    let baseUrl = $("meta[name='base-url']").attr("content");
    var authToken = localStorage.getItem('adminToken');

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
        axios.get(`${baseUrl}/api/chart-data`)
        .then((res) => {
            let revenues = res.data.results;
            chart.updateSeries([{ 
                name: "Subscriptions", 
                data: revenues
            }]);
        });
    }
    fetchChartData();

    function fetchStatistics(){
        axios.get(`${baseUrl}/api/statistics`)
        .then((res) => {
            let data = res.data.results;
            $("#users").text(data.users.toLocaleString());
            $("#doctors").text(data.doctors.toLocaleString());
            $("#children").text(data.children.toLocaleString());
            $("#transactions").text("₦"+parseInt(data.transactions).toLocaleString());
            $("#chart-transactions").text("₦"+parseInt(data.transactions).toLocaleString());
        });
    };
    fetchStatistics();

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

    function fetchAllTransactions(){
        axios.get(`${baseUrl}/api/admin/transactions`)
        .then((res) => {
            let transactions = res.data.results.slice(0, 5);

            $(".transactions-table tbody").empty();
            transactions.forEach(function(transaction, index){
                const userCard = (transaction.user.profile.photo == null ) ? `
                    <td scope="row">
                        <div class="user-card">
                            <div class="user-avatar sm bg-success-dim">
                                <span>${getInitials(transaction.user.name)}</span>
                            </div>
                            <div class="user-name">
                                <h6 class="fw-semibold mb-1">${transaction.user.name}</h6>
                            </div>
                        </div>
                    </td>
                ` : `
                    <td scope="row">
                        <div class="user-card">
                            <div class="user-avatar sm">
                                <img src="${transaction.user.profile.photo}" class="w-100 h-100">
                            </div>
                            <div class="user-name">
                                <h6 class="fw-semibold mb-1">${transaction.user.name}</h6>                        
                            </div>
                        </div> 
                    </td>
                `;

                $(".transactions-table tbody").append(`
                    <tr>
                        ${userCard}
                        <td scope="row">₦${transaction.amount.toLocaleString()}</td>
                        <td scope="row">${transaction.created_at}</td>
                    </tr>  
                `);
            })
        });
    };
    fetchAllTransactions();

    function fetchAllUsers(){
        axios.get(`${baseUrl}/api/admin/get-all-users`)
        .then((res) => {
            let users = res.data.results;
            users.forEach(function(user, index){
                $("select[name='recipient']").append(`
                    <option value=${user.id}>${user.name}</option>
                `);
            });
        });
    };
    fetchAllUsers();

    function sound() {
        let audio = document.getElementById("mySound");
        if(audio.paused || audio.ended){
            audio.play();
        }
    };
    sound();

    $(".reload-data").on("click", function(event){
        event.preventDefault();
        fetchAllTransactions();
        fetchStatistics();
        fetchChartData();
        sound();
    });
</script>
<script src="{{asset('assets/js/api/dashboard.js')}}"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('b216faf6b05a7c1c2697', {
        cluster: 'mt1'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
        alert(JSON.stringify(data));
        fetchAllTransactions();
        fetchStatistics();
        fetchChartData();
    });
</script>
<script>
    $(function() {
        $('.dropdown-toggle').each(function() {
            $(this).find('.caret').remove();
        });
    });
</script>
@include("admin.layouts.footer")