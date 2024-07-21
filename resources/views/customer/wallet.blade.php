@include("customer.layouts.header")
        <div class="container-fluid" style="background-color:#F6F6F7;">
            <!--  Row 1 -->
            <div class="row">
                <div class="col">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="card-title fw-normal bg-white py-2 px-3 rounded-pill">Dashboard > Wallet</h6>
                       
                    </div>

                    <div class="row mt-3">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-5" style="height:161px">
                            <div class="h-100 pl-3 pt-3 bg-white position-relative d-flex align-items-center justify-content-between" style="border-radius:20px;">
                                <div class="">
                                    <div class="mb-2 reload-wallet" type="button" data-type="balance">
                                        <img src="{{asset('assets/images/icons/reload.svg')}}">
                                    </div>
                                    <span>Current Wallet Balance</span>
                                    <h2 class="balance"></h2>
                                    <span class="text-sec"></span>
                                    <div class="position-absolute d-flex align-items-center" style="top:0;right:0;height:100%">
                                        <img height="120" src="{{asset('assets/images/icons/ellipse7.svg')}}">
                                    </div>
                                </div>
                                <div class=" pr-2">
                                    <img src="{{asset('assets/images/icons/wallet2.svg')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-6 mt-xl-0 mt-lg-0 mt-md-0 mt-sm-0 mt-3" style="min-height:161px">
                            <div class="h-100 px-3 pt-3 bg-primary" style="border-radius:20px;">
                                <div class="text-white">
                                    <h5 class="text-white m-0">Your Account Details</h5>
                                    <h6 style="color:#FFFFFFB2" class="m-0">Account Name: <span class="text-white"><?=$wallet?->account_name?></span></h6>
                                    <h6 style="color:#FFFFFFB2" class="m-0">Account Number: <span class="text-white"><?=$wallet?->account_number?></span></h6>
                                    <h6 style="color:#FFFFFFB2" class="m-0">Bank Name: <span class="text-white"><?=$wallet?->bank_name?></span></h6>
                                </div>
                                <div class="bg-white p-2 mt-1" style="border-radius:10px;">
                                    <h6 style="color:#CC841D;font-size:12px;margin:0" class="d-flex align-items-center"><span>How to Fund Your Wallet</span><img class="ml-2" src="{{asset('assets/images/icons/wallet5.svg')}}"></h6>
                                    <p style="font-size:11px;margin:0">Transfer money from your bank account
to your wallet using the account details above</p>
                                </div>
                                <div class="d-flex justify-content-end my-2">
                                    <img src="{{asset('assets/images/logos/ziga-yellow.svg')}}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--<div class="mt-5 px-2" style="">
                        <div class="d-flex">
                            <select name="status" id="filterInput"
                                class="form-control w-auto rounded-0 bg-white mr-2" style="height:50px">
                                <option value="Debit">Debit</option>
                                <option value="Credit">Credit</option>
                            </select>
                            <select name="status" id="filterInput"
                                class="form-control w-auto rounded-0 bg-white" style="height:50px">
                                <option value="Pending">Pending</option>
                                <option value="Successful">Successful</option>
                                <option value="Failed">Failed</option>
                            </select>
                        </div>
                        <div class="d-flex mt-2 flex-wrap">
                            <input type="text"
                            placeholder="Sort by date(from)" 
                            class="form-control w-auto rounded-0 p-4 mr-2 bg-white" id="startDate">
                            <input type="text"
                            placeholder="Sort by date(to)" 
                            class="form-control w-auto rounded-0 p-4 bg-white" id="endDate">
                        </div>
                    </div>-->

                    <div class="row mt-5">
                        <div class="col-12 d-flex align-items-stretch">
                            <div class="card w-100">
                                <div class="card-body p-0">
                                    <div class="p-3 d-flex flex-wrap justify-content-between align-items-center mb-4">
                                        <h5 class="card-title fw-semibold">Transaction History</h5>
                                        <div class="d-flex flex-column align-items-center" style="flex:1">
                                            
                                            <div class="dropdown trx-filter-box">
                                                <button class="dropdown-toggle trx-filter d-flex justify-content-between align-items-center" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div>
                                                        Filter by: <span></span>
                                                    </div>
                                                    <img src="{{asset('assets/images/icons/reload.svg')}}">
                                                </button>
                                                <div class="dropdown-menu main-menu" aria-labelledby="dropdownMenuButton">
                                                    <div class="dropdown-submenu dropup">
                                                        <button class="dropdown-item dropdown-toggle" type="button" id="dropdownSubMenuButton1" aria-haspopup="true" aria-expanded="false">Date</button>
                                                        <div class="dropdown-menu px-2 py-3" aria-labelledby="dropdownSubMenuButton1">
                                                            <div class="mb-2">
                                                                <label for="startDate" class="fw-semibold">Start Date</label>
                                                                <input 
                                                                min="0"
                                                                data-key="date"
                                                                type="number"
                                                                class="w-100 custom-input" 
                                                                name="startDate"
                                                                id="startDate" placeholder="Select Date and Time">
                                                            </div>
                                                            <div class="">
                                                                <label for="endDate" class="fw-semibold">End Date</label>
                                                                <input 
                                                                min="0"
                                                                data-key="date"
                                                                type="number"
                                                                class="w-100 custom-input" 
                                                                name="endDate"
                                                                id="endDate" placeholder="Select Date and Time">
                                                            </div>
                                                            <button 
                                                                type="submit" 
                                                                data-key="date"
                                                                class="custom-btn fs-4 mt-3 fw-bold w-100 filter-btn">
                                                                Apply Filter <img src="{{asset('assets/images/icons/filter.svg')}}" width="20" class="ml-1">
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <a class="dropdown-item filter-btn" data-key="type" data-value="Debit">Debit</a>
                                                    <a class="dropdown-item filter-btn" data-key="type" data-value="Credit">Credit</a>
                                                    <div class="dropdown-submenu dropdown">
                                                        <button class="dropdown-item dropdown-toggle" type="button" id="dropdownSubMenuButton2" aria-haspopup="true" aria-expanded="false">Status</button>
                                                        <div class="dropdown-menu py-0" aria-labelledby="dropdownSubMenuButton2">
                                                        <a class="dropdown-item filter-btn" data-key="status" data-value="success">Successful</a>
                                                            <a class="dropdown-item filter-btn" data-key="status" data-value="pending">Pending</a>
                                                            <a class="dropdown-item filter-btn" data-key="status" data-value="failed">Failed</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="transactions-table table text-nowrap mb-0 align-middle">
                                            <thead class="text-dark fs-4">
                                                <tr>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-0">S/N</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-0">Amount</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-0">Date</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-0">Purpose</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-0">Type</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-0">Status</h6>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>   
                                                                      
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center mt-2">
                        <div class="mr-3">
                            <button 
                            type="button"
                            disabled
                            data-page=""
                            class="btn btn-light fs-4 fw-bold paginate">
                            <img src="{{asset('assets/images/icons/auth/cil_arrow-left.svg')}}" width="20" class="mr-2" alt="">
                            Previous
                            </button>
                        </div>
                        <div class="">
                            <button 
                            type="button"
                            data-page=""
                            class="custom-btn fs-4 fw-bold paginate">
                            Next
                            <img src="{{asset('assets/images/icons/auth/cil_arrow-right.svg')}}" width="20" class="mr-2" alt="">
                            </button>
                        </div>
                    </div>
                    <!--  Pagination Starts -->
                    <div class="my-2 pl-2">
                        Showing
                        <span class="entries fw-semibold">. </span> to
                        <span class="entries fw-semibold">. </span> of
                        <span class="entries fw-semibold">. </span>
                        shipments
                    </div>
                    <!--  Pagination Ends -->



                    @include('customer.modals.payment-modal')
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
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    let token = $("meta[name='csrf-token']").attr("content");
    let baseUrl = $("meta[name='base-url']").attr("content");
    const user_id = "{{$user->id}}"

    flatpickr('#startDate', {
        enableTime: false,
        dateFormat: "Y-m-d H:i"
    });

    flatpickr('#endDate', {
        enableTime: false,
        dateFormat: "Y-m-d H:i"
    });

    function fetchWallet(){
        const config = {
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
                "X-Requested-With": "XMLHttpRequest"
            }
        };
        axios.get(`${baseUrl}/user/${user_id}/wallet`, config)
        .then((res) => {
            let data = res.data.results;
            console.log(data);
            $(".balance").eq(0).text("₦"+parseInt(data.wallet?.balance).toLocaleString());
            $(".balance").eq(0).next("span.text-sec").text("Last updated: "+data?.wallet.updated_at);
            getTransactions(data?.transactions);
        });
    };
    fetchWallet();

    const status = {
        pending: "custom-bg-warning",
        success: "custom-bg-success",
        failed: "custom-bg-danger"
    };

    function getIndex(per_page, current_page, index)
    {
        if(current_page == 1){
            return index + 1
        }else{
            return (per_page * current_page) - per_page + 1 + index
        }
    }

    const per_page = 10;
    let current_page = 1;
    let data = [];
    function getTransactions(transactions){
        data = transactions;
        renderData();
    };

    function renderData(){
        $(".transactions-table tbody").empty();
        const startIndex = (current_page - 1) * per_page;
        const endIndex = startIndex + per_page;
        transactions = data.slice(startIndex, endIndex);
        if(transactions.length == 0){
            $(".transactions-table tbody").append(`
                <tr class="">
                    <td scope="row">No data available...</td>
                </tr> 
            `);
        }else{
            transactions.forEach(function(transaction, index){
                const status_color = transaction?.type === "credit" || transaction?.type === "Credit" ? "success":"danger"
                $(".transactions-table tbody").append(`
                    <tr style="cursor:pointer">
                        <td scope="row">${getIndex(per_page, current_page, index)}.</td>
                        <td scope="row"><b>₦</b>${formatCurrency(transaction?.amount, 2)}</td>
                        <td scope="row">${transaction?.created_at}</td>
                        <td scope="row">${transaction?.purpose}</td>
                        <td scope="row"><span class="badge badge-${status_color}">${transaction?.type}</span></td>
                        <td scope="row">
                            <span class="py-2 badge rounded-2 fw-semibold ${status[transaction.status]}">
                                ${transaction.status.charAt(0).toUpperCase() + transaction.status.slice(1)}
                            </span>
                        </td>
                    </tr> 
                `);
            })
        }

        // Calculate last_page
        const last_page = data.length > 0 ? Math.ceil(data.length / per_page) : 1;
        // Enable or disable the button based on the condition
        $(".paginate").eq(0).prop('disabled', current_page === 1);
        $(".paginate").eq(1).prop('disabled', current_page === last_page);

        $(".paginate").eq(0).data("page", current_page - 1);
        $(".paginate").eq(1).data("page", current_page + 1);

        $(".entries").eq(0).text((current_page - 1) * per_page + 1);
        $(".entries").eq(1).text((current_page - 1) * per_page + transactions.length);
        $(".entries").eq(2).text(data.length);
    }

    $('.paginate').on('click', function() {
        current_page = $(this).data("page");
        renderData();
    });

    $(".reload-wallet").on("click", function(event){
        event.preventDefault();
        // Append loader immediately
        //setTimeout(() => {
            //$(this).find("img").addClass("reload-wallet-active");
            fetchWallet();
        //}, 100); // Delay submission by 100 milliseconds
    });
</script>
<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
    var paymentForm = document.getElementById('paymentForm');
    paymentForm.addEventListener('submit', payWithPaystack, false);

    async function payWithPaystack(e) {
        e.preventDefault();
        const config = {
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
                "X-Requested-With": "XMLHttpRequest"
            }
        };
        const inputs = {amount: $('#paymentForm #amount').val()}
        try {
            const response = await axios.post(`${baseUrl}/user/${user_id}/transaction`, inputs, config);
            let results = response.data.results;
            let handler = PaystackPop.setup({
                key: results.key, 
                email: results.email,
                amount: results.amount * 100, 
                currency: 'NGN', // Use GHS for Ghana Cedis or USD for US Dollars
                ref: results.reference,
                //channels: ['card', 'bank', 'ussd', 'qr', 'mobile_money', 'bank_transfer'],
                onClose: function(){
                    offModal(); // Hide the modal
                    axios.get(
                        `${baseUrl}/api/wallet-funding/callback?reference=`+results.reference, 
                        inputs, 
                        config
                    ).then((res) => {
                        let data = res.data;
                        fetchWallet();
                    });
                },
                callback: function(response){
                    offModal();  // Hide the modal
                    axios.get(
                        `${baseUrl}/api/wallet-funding/callback?reference=`+response.reference, 
                        inputs, 
                        config
                    ).then((res) => {
                        let data = res.data;
                        fetchWallet();
                    });
                }
            });

            handler.openIframe();
        } catch (error) {
            console.error('An error occurred:', error);
        }
    }

    function offModal(){
        // Select the modal element
        var myModal = document.getElementById('paymentModal');
        myModal.classList.remove('show');
        myModal.style.display = 'none';
        document.body.classList.remove('modal-open');
        $('.modal-backdrop').remove();  // Remove the backdrop
    }
</script>
<script>
    $('#paymentForm #amount').on('input', function() {
        var $submitButton = $('#paymentForm #submitBtn');  // Cache the submit button
        var inputValue = $(this).val(); // Get the input value
        var sanitizedValue = inputValue.replace(/\D/g, '');  // Remove any non-numeric characters
        // Update the input value with the sanitized value
        $(this).val(sanitizedValue);

        // Check if the sanitized value is greater than 2000
        if (parseInt(sanitizedValue) >= 1000) {
            $submitButton.prop('disabled', false); //If the value is greater than 2000, enable the button
        } else {
            $submitButton.prop('disabled', true); //If the value is not greater than 2000, disable the button
        }
    });

    $(".filter-btn").click(function(){
        var key = $(this).data("key");
        switch(key){
            case "date":
                let startDate = $("#startDate").val();
                let endDate = $("#endDate").val();
                $(".trx-filter div span").text("Date");
                filterTrx(`${baseUrl}/user/${user_id}/transactions?${key}=${true}&startDate=${startDate}&endDate=${endDate}`)
                break;
            default:
                var value = $(this).data("value");
                $(".trx-filter div span").text(value);
                filterTrx(`${baseUrl}/user/${user_id}/transactions?${key}=${value}`)
        }
        //$(".dropdown-menu").removeClass("show");  //Hide the dropdown menu
        /**/
    })

    function filterTrx(url){
        const config = {
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
                "X-Requested-With": "XMLHttpRequest"
            }
        };
        axios.get(url, config)
        .then((res) => {
            let transactions = res.data.results;
            getTransactions(transactions);
        });
    }

    // Prevent default behavior of submenu button click
    document.getElementById('dropdownSubMenuButton1').addEventListener('click', function(event) {
        event.stopPropagation(); // Stop the click event from propagating
        event.preventDefault(); // Prevent the default action of the button
        $(this).next('.dropdown-menu').toggle(); // Toggle the submenu
    });

    document.getElementById('dropdownSubMenuButton2').addEventListener('click', function(event) {
        event.stopPropagation(); // Stop the click event from propagating
        event.preventDefault(); // Prevent the default action of the button
        $(this).next('.dropdown-menu').toggle(); // Toggle the submenu
    });
</script>
@include("customer.layouts.footer")