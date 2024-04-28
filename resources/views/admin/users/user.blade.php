@include("admin.layouts.header")
        <div class="container-fluid" style="background-color:#F6F6F7;">
            <!--  Row 1 -->
            <div class="row">
                <div class="col">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title fw-normal bg-white py-2 px-3 rounded-pill">Dashboard > Customers</h5>
                        <!--<div class="d-flex">
                            <a href="{{url('/users')}}" class="d-flex align-items-center btn btn-primary mr-2">
                                <img src="{{asset('assets/images/icons/plus.svg')}}" class="mr-1" width="20" height="20" />
                                Book Shipment
                            </a>
                            <a href="{{url('/users')}}" class="d-flex align-items-center btn btn-primary">
                                <img src="{{asset('assets/images/icons/track.svg')}}" class="mr-1" width="20" height="20" />
                                Track Shipment
                            </a>
                        </div>-->
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 d-flex align-items-stretch">
                            <div class="card w-100">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table data-order="false" class="users-table table table-borderless text-nowrap mb-0 align-middle">
                                            <thead class="text-dark fs-4">
                                                <tr>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold">S/N</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold">User</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold">Phone</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold">Account</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold">Country</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold">Edit</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold">Status</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold">Fund</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold">...</h6>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>   
                                                                      
                                            </tbody>
                                        </table>
                                        <!--  Pagination Starts -->
                                        <div class="d-flex justify-content-end my-2 pr-2">
                                            <button class="btn btn-primary mr-2 paginate" data-page="" type="button">
                                                Prev
                                            </button>
                                            <button class="btn btn-primary paginate" data-page="" type="button">
                                                Next
                                            </button>
                                        </div>
                                        <div class="my-2 pl-2">
                                                Showing
                                                <span class="entries fw-semibold">. </span> to
                                                <span class="entries fw-semibold">. </span> of
                                                <span class="entries fw-semibold">. </span>
                                                transactions
                                            </div>
                                        <!--  Pagination Ends -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('admin.modals.user-modal')
                    @include('admin.modals.payment-modal')
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
<script src="{{asset('assets/plugins/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/libs/apexcharts/dist/apexcharts.min.js')}}"></script>
<script src="{{asset('assets/libs/simplebar/dist/simplebar.js')}}"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script>
    let token = $("meta[name='csrf-token']").attr("content");
    let baseUrl = $("meta[name='base-url']").attr("content");
    var userToken = localStorage.getItem('token');

    function getRandomColor(){
        const r = Math.floor(Math.random() * 256);
        const g = Math.floor(Math.random() * 256);
        const b = Math.floor(Math.random() * 256);

        //Convert the RGB components to headecimal format
        const colorHex = `#${r.toString(16)}${g.toString(16)}${b.toString(16)}`;
        return colorHex;
    }

    function getInitials(name){
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

    const status = {
        pending: "custom-bg-warning",
        delivered: "custom-bg-success",
        failed: "custom-bg-danger"
    };

    const rowColors = {failed: "#ffffff", success: "#233E830D", pending: "#ffffff"};

    function getIndex(per_page, current_page, index)
    {
        if(current_page == 1){
            return index + 1
        }else{
            return (per_page * current_page) - per_page + 1 + index
        }
    }

    function getUsers(page){
        const config = {
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                Authorization: "Bearer "+ userToken
            }
        };
        axios.get(`${baseUrl}/api/v1/users?page=${page}`, config)
        .then((res) => {
            let results = res.data.results;
            let users = results.data;
        
            $(".users-table tbody").empty();
            users.forEach(function(user, index){
                const status = (user.is_verified) ? `
                    <td scope="row">
                        <img src="{{asset('assets/images/icons/auth/success-icon.svg')}}" width="20" height="20" />
                    </td>
                ` : `
                    <td scope="row">
                        <img src="{{asset('assets/images/icons/auth/warning-icon.svg')}}" width="20" height="20" />
                    </td>
                `;
                const userCard = (user.photo == null ) ? `
                <td scope="row">
                    <div class="user-card">
                        <div class="user-avatar" style='background-color:${getRandomColor()}'>
                            <span>${getInitials(user.firstname+" "+user.lastname)}</span>
                        </div>
                        <div class="">
                            <div><b>${user.firstname+" "+user.lastname}</b></div>
                            <div style="font-size:13px;">${user.email}</div>
                        </div>
                    </div>
                </td>
                ` : `
                    <td scope="row">
                        <div class="user-card">
                            <div class="user-avatar">
                                <img src="${user.photo}" class="w-100 h-100">
                            </div>
                            <div class="">
                                <div><b>${user.firstname+" "+user.lastname}</b></div>
                                <div style="font-size:13px;">${user.email}</div>                       
                            </div>
                        </div> 
                    </td>
                `;

                $(".users-table tbody").append(`
                    <tr style="background-color:${rowColors[user.is_verified ?? "success"]}">
                        <td scope="row">${getIndex(results.per_page, results.current_page, index)}</td>
                        ${userCard}
                        <td scope="row">${user.phone}</td>
                        <td scope="row">${user.account.name}</td>
                        <td scope="row">${user.country != null ? user.country: "" }</td>
                        <td scope="row">
                            <a class="edit-user" data-id="${user.id}" type="button">
                                <img src="{{asset('assets/images/icons/file-edit.svg')}}" />
                            </a>
                        </td>
                        ${status}
                        <td scope="row">
                            <button data-id="${user.id}" data-email="${user.email}" 
                            data-name="${user.firstname+" "+user.lastname}" 
                            class="btn btn-light fund-user" type="button">Fund
                            </button>
                        </td>
                        <td scope="row">...</td>
                    </tr>  
                `);
            })

            // Enable or disable the button based on the condition
            $(".paginate").eq(0).prop('disabled', results.current_page === 1);
            $(".paginate").eq(1).prop('disabled', results.current_page === results.last_page);

            $(".paginate").eq(0).data("page", results.current_page - 1);
            $(".paginate").eq(1).data("page", results.current_page + 1);

            $(".entries").eq(0).text((results.current_page - 1) * results.per_page + 1);
            $(".entries").eq(1).text((results.current_page - 1) * results.per_page + users.length);
            $(".entries").eq(2).text(results.total);
        });
    }
    getUsers(page = 1);

    function filterTable() {
        var filterValue = $('#filterInput').val().trim().toLowerCase();
        //var date = $('#date').val();

        $('.trx-table tbody tr').each(function() {
            var rowUserEmail = $(this).find('td:eq(1)').text().trim().toLowerCase();
            var rowTrxReference = $(this).find('td:eq(2)').text().trim().toLowerCase();
            //var rowDate = $(this).find('td:eq(4)').text(); // Assuming date is in the third column

            var showRow = false;
            // Show or hide row based on filtering results
            /*if(date !== '' && rowDate !== date) {
                showRow = false;
            }*/
           
            if(rowTrxReference.includes(filterValue) || rowUserEmail.includes(filterValue)) {
                showRow = true;
            }

            if (showRow) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    // jQuery code for filtering
    $(document).ready(function() {
        $('#filterInput').on('input', function() {
            filterTable();
        });

        $('.paginate').on('click', function() {
            let page = $(this).data("page");
            getUsers(page);
        });
    });


    $(document).on("click", ".edit-user", function(event){
        event.preventDefault();
        const userId = $(this).data("id");
        const config = {
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                Authorization: "Bearer "+ userToken
            }
        };
        axios.get(`${baseUrl}/api/v1/user/${userId}`, config)
        .then((res) => {
            let user = res.data.results;

            let userData = $("#userModal input");
            userData.eq(0).val(user?.firstname);
            userData.eq(1).val(user?.lastname);
            userData.eq(2).val(user?.email);
            userData.eq(3).val(user?.phone);
            userData.eq(4).val(user?.country);
            $("#userModal select[name='account']").val(user?.account.id);
            $('#userModal .avatar').attr("src", user?.photo);
            $("#userModal").modal("show");
        });
    });

    $("#userModal .close").on("click", function(){
        $("#userModal").modal("hide");
    });
    $('#userModal').on('hidden.bs.modal', function (e) {
        $("#userModal").modal("hide");
    })

    $(document).on("click", ".fund-user", function(event){
        event.preventDefault();
        const userId = $(this).data("id");
        const email = $(this).data("email");
        const name = $(this).data("name");
        $("#paymentForm .name").html("<b>"+name+"</b>");
        $("#paymentForm .email").html("<b>"+email+"</b>");
        $("#paymentForm #userId").val(userId);
        $("#paymentModal").modal("show");
    });
    $("#paymentModal .close").on("click", function(){
        $("#paymentModal").modal("hide");
    });
    $('#paymentModal').on('hidden.bs.modal', function (e) {
        $("#paymentModal").modal("hide");
    })

    $('#paymentForm #amount').on('input', function() {
        var $submitButton = $('#paymentForm #submitBtn');  // Cache the submit button
        var inputValue = $(this).val(); // Get the input value
        var sanitizedValue = inputValue.replace(/\D/g, '');  // Remove any non-numeric characters
        // Update the input value with the sanitized value
        $(this).val(sanitizedValue);

        // Check if the sanitized value is greater than 2000
        if (parseInt(sanitizedValue) > 0) {
            $submitButton.prop('disabled', false); //If the value is greater than 2000, enable the button
        } else {
            $submitButton.prop('disabled', true); //If the value is not greater than 2000, disable the button
        }
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
                Authorization: "Bearer "+ userToken
            }
        };
        const inputs = {amount: $('#paymentForm #amount').val()}
        let userId = $("#paymentForm #userId").val();
        try {
            const response = await axios.post(`${baseUrl}/api/v1/user/${userId}/transaction`, inputs, config);
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
                        alert(data.message);
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
                        alert(data.message);
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
@include("admin.layouts.footer")