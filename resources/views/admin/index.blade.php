@include("admin.layouts.header")
        <div class="container-fluid" style="background-color:#F6F6F7;">
            <!--  Row 1 -->
            <div class="row">
                <div class="col">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title fw-normal bg-white py-2 px-3 rounded-pill">Dashboard > Dashboard</h5>
                        <div class="d-flex">
                            <a href="{{url('/users')}}" class="d-flex align-items-center btn btn-primary mr-2">
                                <img src="{{asset('assets/images/icons/plus.svg')}}" class="mr-1" width="20" height="20" />
                                Book Shipment
                            </a>
                            <a href="{{url('/users')}}" class="d-flex align-items-center btn btn-primary">
                                <img src="{{asset('assets/images/icons/track.svg')}}" class="mr-1" width="20" height="20" />
                                Track Shipment
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

                    @include('customer.modals.broadcast-modal')
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
    var userToken = localStorage.getItem('token');

    function fetchStats(){
        const config = {
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                Authorization: "Bearer "+ userToken
            }
        };
        axios.get(`${baseUrl}/api/v1/statistics`, config)
        .then((res) => {
            let results = res.data.results;
            $(".stats").eq(0).text(results?.customers_count);
            $(".stats").eq(1).text(results?.customers_last_week[0]);
            $(".stats").eq(2).text("₦"+parseInt(results?.transactions_cost_last_week[0]).toLocaleString());
            $(".stats").eq(3).text("₦"+parseInt(results?.transactions_cost_last_month[0]).toLocaleString());
            $(".stat-percent").eq(0).text("+"+results?.customers_last_week[1].toFixed(0)+"%").css("color", "#128807");
            $(".stat-percent").eq(1).text("+"+results?.transactions_cost_last_week[1].toFixed(0)+"%").css("color", "#128807");
            $(".stat-percent").eq(2).text("+"+results?.transactions_cost_last_month[1].toFixed(0)+"%").css("color", "#128807");
        });
    };
    fetchStats();

    const status = {
        pending: "custom-bg-warning",
        success: "custom-bg-success",
        failed: "custom-bg-danger"
    };

    const rowColors = {
        pending: "#ffffff",
        success: "#233E830D",
        failed: "#ffffff"
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

    function fetchAllTransactions(data){
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
                <tr style="background-color:${rowColors[transaction.status]}">
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
    fetchAllTransactions(@json($transactions));
</script>
@include("admin.layouts.footer")