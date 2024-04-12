@include("customer.layouts.header")
        <div class="container-fluid" style="background-color:#F6F6F7;">
            <!--  Row 1 -->
            <div class="row">
                <div class="col">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="card-title fw-normal bg-white py-2 px-3 rounded-pill">Dashboard > Wallet</h6>
                        <button class="btn btn-dark mr-2 rounded-0" type="button" data-toggle="modal" data-target="#paymentModal">
                            <img src="{{asset('assets/images/icons/broadcast-light.svg')}}">
                            Fund
                        </button>
                    </div>

                    <div class="row mt-3">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-5" style="height:161px">
                            <div class="h-100 pl-3 pt-3 bg-white position-relative d-flex align-items-center justify-content-between" style="border-radius:20px;">
                                <div class="">
                                    <div class="mb-2 reload-wallet" type="button" data-type="balance">
                                        <img src="{{asset('assets/images/icons/reload.svg')}}">
                                    </div>
                                    <span>Curent Wallet Balance</span>
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
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-6 mt-xl-0 mt-lg-0 mt-md-0 mt-sm-0 mt-3" style="height:161px">
                            <div class="h-100 px-3 pt-3 bg-primary" style="border-radius:20px;">
                                <div class="d-flex flex-column align-items-center">
                                    <h4 class="text-white">Fund Your Wallet</h4>
                                    <span class="text-white mb-2">Your transactions are secure with </span>
                                    <img src="{{asset('assets/images/icons/paystack.svg')}}">
                                </div>
                                <div class="d-flex justify-content-end">
                                    <img src="{{asset('assets/images/logos/ziga-yellow.svg')}}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-12 d-flex align-items-stretch">
                            <div class="card w-100">
                                <div class="card-body p-0">
                                    <div class="p-3 d-flex flex-wrap justify-content-between align-items-center mb-4">
                                        <h5 class="card-title fw-semibold">Transaction History</h5>
                                        <div class="" style="border:2px solid transparent;">
                                            <div class="dropdown">
                                                <button class="dropdown-toggle trx-filter d-flex justify-content-between align-items-center" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div>
                                                        Filter by: <span></span>
                                                    </div>
                                                    <img src="{{asset('assets/images/icons/reload.svg')}}">
                                                </button>
                                                <div class="dropdown-menu trx-filter-dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" data-key="date" data-value="Date">Date</a>
                                                    <a class="dropdown-item" data-key="type" data-value="Debit">Debit</a>
                                                    <a class="dropdown-item" data-key="type" data-value="Credit">Credit</a>
                                                    <a class="dropdown-item status-dropdown-toggle" data-key="status" data-value="Status">Status</a>
                                                    <div class="dropdown-menu status-dropdown-menu">
                                                        <a class="dropdown-item" data-key="status" data-value="Pending">Pending</a>
                                                        <a class="dropdown-item" data-key="status" data-value="Completed">Completed</a>
                                                        <a class="dropdown-item" data-key="status" data-value="Failed">Failed</a>
                                                    </div>
                                                </div> 
                                            </div>
                                            <div class="mt-3">
                                                <select name="status" id="trx-status">
                                                    <option value="success">Successful</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="failed">Failed</option>
                                                </select>
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
                                                        <h6 class="fw-semibold mb-0">Payment ID</h6>
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

                    @include('customer.modals.payment-modal')
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

    function fetchWallet(){
        const config = {
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                Authorization: "Bearer "+ userToken
            }
        };
        axios.get(`${baseUrl}/api/v1/user/wallet`, config)
        .then((res) => {
            let data = res.data.results;
            $(".balance").eq(0).text("₦"+parseInt(data.wallet?.balance).toLocaleString());
            $(".balance").eq(0).next("span.text-sec").text("Last updated: "+data?.wallet.updated_at);
            fetchAllTransactions(data?.transactions);
        });
    };
    fetchWallet();

    const status = {
        pending: "bg-warning",
        success: "bg-success",
        failed: "bg-danger"
    };

    const rowColors = {failed: "#ffffff", success: "#233E830D", pending: "#ffffff"};

    function fetchAllTransactions(transactions){
        //let transactions = data.slice(0, 10);
        $(".transactions-table tbody").empty();
        transactions.forEach(function(transaction, index){
            $(".transactions-table tbody").append(`
                <tr style="background-color:${rowColors[transaction?.status]}">
                    <td class="border-bottom-0">
                        <span class="fw-normal mb-0">${index + 1}.</span>
                    </td>
                    <td class="border-bottom-0">
                        <span class="fw-normal mb-1">${transaction?.reference}</span>                        
                    </td>
                    <td class="border-bottom-0">
                        <span class="mb-0 fw-normal">₦${transaction?.amount}</span>
                    </td>
                    <td class="border-bottom-0">
                        <span class="mb-0 fw-normal">${transaction?.created_at}</span>
                    </td>
                    <td class="border-bottom-0">
                        <span class="fw-normal mb-0">${transaction?.purpose}</span>
                    </td>
                    <td class="border-bottom-0">
                        <span class="fw-normal mb-0">${transaction?.type}</span>
                    </td>
                    <td class="border-bottom-0">
                        <div class="d-flex align-items-center gap-2">
                            <span class="py-2 badge rounded-3 fw-semibold ${status[transaction.status]}">
                            ${transaction.status.charAt(0).toUpperCase() + transaction.status.slice(1)}
                            </span>
                        </div>
                    </td>
                </tr> 
            `);
        })
    };


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
            const response = await axios.post(`${baseUrl}/wallet/create-transaction`, inputs, config);
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

    $(".trx-filter-dropdown-menu .dropdown-item").click(function(){
        var value = $(this).data("value");
        var key = $(this).data("key");
        $(".trx-filter div span").text(value);
        //$(".dropdown-menu").removeClass("show");  //Hide the dropdown menu
        const config = {
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                Authorization: "Bearer "+ userToken
            }
        };
        axios.get(
            `${baseUrl}/api/v1/transactions?${key}=${value}`, 
            config
        ).then((res) => {
            let transactions = res.data.results;
            console.log(transactions);
            fetchAllTransactions(transactions);
        });
    })

    $(document).ready(function() {
        $('.dropdown-menu .dropdown-item').click(function(e) {
            //e.stopPropagation(); // Prevent event from bubbling up to parent dropdown
        });

        $('.status-dropdown-toggle').click(function() {
            //$('.status-dropdown-menu').toggle();
        });
    });
</script>
@include("customer.layouts.footer")