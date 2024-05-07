@include("admin.layouts.header")
        <div class="container-fluid" style="background-color:#F6F6F7;">
            <!--  Row 1 -->
            <div class="row">
                <div class="col">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title fw-normal bg-white py-2 px-3 rounded-pill">Dashboard > Transactions</h5>
                    </div>
                    

                    <div class="row mt-3">
                        <div class="col-12 d-flex align-items-stretch">
                            <div class="card w-100">
                                <div class="card-body p-0">
                                    <div class="my-3 px-2" style="">
                                        <div class="">
                                            <input type="text"
                                            placeholder="Search by email, reference" 
                                            class="form-control w-auto" id="filterInput">
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table data-order="false" class="trx-table table table-borderless text-nowrap mb-0 align-middle">
                                            <thead class="text-dark fs-4">
                                                <tr>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-0">S/N</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-0">Email</h6>
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

                    <!--  Pagination Starts -->
                    <div class="d-flex justify-content-center my-2 pr-2">
                        <button class="btn btn-light fs-4 fw-bold mr-2 paginate" data-page="" type="button">
                            <img src="{{asset('assets/images/icons/auth/cil_arrow-left.svg')}}" width="20" class="mr-2" alt="">
                            Previous
                        </button>
                        <button class="custom-btn fs-4 fw-bold paginate" data-page="" type="button">
                            Next
                            <img src="{{asset('assets/images/icons/auth/cil_arrow-right.svg')}}" width="20" class="mr-2" alt="">
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
        success: "custom-bg-success",
        failed: "custom-bg-danger"
    };

    const rowColors = {failed: "#ffffff", pending: "#233E830D", success: "#ffffff"};

    function getIndex(per_page, current_page, index){
        if(current_page == 1){
            return index + 1
        }else{
            return (per_page * current_page) - per_page + 1 + index
        }
    }
    
    function getTransactions(page){
        const config = {
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                Authorization: "Bearer "+ userToken
            }
        };
        axios.get(`${baseUrl}/api/v1/transactions?page=${page}`, config)
        .then((res) => {
            let results = res.data.results;
            let transactions = results.data;
        
            $(".trx-table tbody").empty();
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


                $(".trx-table tbody").append(`
                    <tr style="cursor:pointer">
                        <td scope="row">${getIndex(results.per_page, results.current_page, index)}</td>
                        <td scope="row"><b>${transaction.wallet.user.email}</b></td>
                        <td scope="row">${transaction.reference}</td>
                        <td scope="row"><b>₦</b>${transaction.amount.toLocaleString()}</td>
                        <td scope="row">${transaction.created_at}</td>
                        <td scope="row">${transaction.purpose}</td>
                        <td scope="row">${transaction.type}</td>
                        <td scope="row">
                            <span class="py-2 badge rounded-2 fw-semibold ${status[transaction.status]}">
                            ${transaction.status.charAt(0).toUpperCase() + transaction.status.slice(1)}
                            </span>
                        </td>
                    </tr>  
                `);
            })

            // Enable or disable the button based on the condition
            $(".paginate").eq(0).prop('disabled', results.current_page === 1);
            $(".paginate").eq(1).prop('disabled', results.current_page === results.last_page);

            $(".paginate").eq(0).data("page", results.current_page - 1);
            $(".paginate").eq(1).data("page", results.current_page + 1);

            $(".entries").eq(0).text((results.current_page - 1) * results.per_page + 1);
            $(".entries").eq(1).text((results.current_page - 1) * results.per_page + transactions.length);
            $(".entries").eq(2).text(results.total);
        });
    }
    getTransactions(page = 1);
    
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
            getTransactions(page);
        });
    });
</script>
@include("admin.layouts.footer")