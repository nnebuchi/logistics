@include("admin.layouts.header")
        <div class="container-fluid" style="background-color:#F6F6F7;">
            <!--  Row 1 -->
            <div class="row">
                <div class="col">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title fw-normal bg-white py-2 px-3 rounded-pill">Dashboard > Accounts</h5>
                    </div>

                    <div class="row mt-3 justify-content-center">
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">
                            <div class="card">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table data-order="false" class="accounts-table table table-borderless text-nowrap mb-0 align-middle">
                                            <thead class="text-dark fs-4">
                                                <tr>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold">S/N</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold">Name</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold">Percent</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold">Edit</h6>
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
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-8">
                            <div class="card">
                                <div class="card-body" style="">
                                    <form action="<?=route('account.create')?>" method="POST" id="createAccountForm">
                                        <div class="mt-2">
                                            <label for="" class="fw-semibold">Name</label>
                                            <input type="text" name="name"
                                            placeholder="name" class="w-100 custom-input rounded-0">
                                            <span class="error"> </span>
                                        </div>
                                        <div class="mt-2">
                                            <label for="" class="fw-semibold"> Percent</label>
                                            <input type="number" name="price"
                                            placeholder="percent" class="w-100 custom-input rounded-0">
                                            <span class="error"> </span>
                                        </div>
                                        <div class="d-flex justify-content-center mt-3">
                                            <button 
                                            type="button"
                                            id="createAccount"
                                            class="custom-btn fs-4 fw-bold">
                                            Submit
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="accountModal" tabindex="-1" role="dialog" aria-labelledby="accountModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-semibold" id="accountModalLabel">Accounts</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="<?=route('account.create')?>" method="POST">
                                        <div class="">
                                            <label for="" class="fw-semibold">Name</label>
                                            <input type="text" id="name"
                                            placeholder="name" class="w-100 form-control rounded-0">
                                            <span class="error"> </span>
                                        </div>
                                        <input type="hidden" id="id"
                                        placeholder="price" class="w-100 form-control rounded-0">
                                        <div class="mt-3">
                                            <label for="" class="fw-semibold">Percent</label>
                                            <input type="number" id="price"
                                            placeholder="price" class="w-100 form-control rounded-0">
                                            <span class="error"> </span>
                                        </div>
                                        <div class="d-flex justify-content-center mt-3">
                                            <button 
                                            type="button"
                                            id="editAccount"
                                            class="custom-btn fs-4 fw-bold">
                                            Submit
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    
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

    function getAccounts(accounts){
        $(".accounts-table tbody").empty();
        if(accounts.length == 0){
            $(".accounts-table tbody").append(`
                <tr class="">
                    <td scope="row">No data available...</td>
                </tr> 
            `);
        }else{
            accounts.forEach(function(account, index){
                $(".accounts-table tbody").append(`
                    <tr style="">
                        <td scope="row">${index + 1}</td>
                        <td scope="row">${account.name}</td>
                        <td scope="row">${account.markup_price}%</td>
                        <td scope="row">
                            <a class="edit-account m-0 p-0" data-id="${account.id}" data-name="${account.name}" data-price="${account.markup_price}" type="button">
                                <img width="20" height="20" src="{{asset('assets/images/icons/file-edit.svg')}}" />
                            </a>
                        </td>
                    </tr>  
                `);
            })
        }
    }
    getAccounts(@json($accounts));

    $(document).on("click", ".edit-account", function(event){
        event.preventDefault();
        const accountId = $(this).data("id");
        const name = $(this).data("name");
        const price = $(this).data("price");
        $("#accountModal #id").val(accountId);
        $("#accountModal #name").val(name);
        $("#accountModal #price").val(price);
        $("#accountModal").modal("show");
    });

    $("#accountModal .close").on("click", function(){
        $("#accountModal").modal("hide");
    });
    $('#accountModal').on('hidden.bs.modal', function (e) {
        $("#accountModal").modal("hide");
    });

    $("#editAccount").on("click", function(event){
        event.preventDefault();
        let btn = $(this);
        btn.html(`<img src="{{asset('assets/images/loader.gif')}}" id="loader-gif">`);
        btn.attr("disabled", true);
        const accountId = $("#id").val();
        let url = $(this).closest("form").attr("action")+"/"+accountId;
        const inputs = {
            name: $("#name").val(),
            price: $("#price").val()
        };
        let errorEl = $('#accountModal .error');
        errorEl.text('');
        // Append loader immediately
        setTimeout(() => {
            saveData(btn, url, inputs, errorEl)
        }, 100); // Delay submission by 100 milliseconds
    });

    $("#createAccount").on("click", function(event){
        event.preventDefault();
        let btn = $(this);
        let url = $(this).closest("form").attr("action");
        btn.html(`<img src="{{asset('assets/images/loader.gif')}}" id="loader-gif">`);
        btn.attr("disabled", true);
        const inputs = {
            name: $("#createAccountForm input[name='name']").val(),
            price: $("#createAccountForm input[name='price']").val()
        };
        let errorEl = $('#createAccountForm .error');
        errorEl.text('');
        // Append loader immediately
        setTimeout(() => {
            saveData(btn, url, inputs, errorEl);
        }, 100); // Delay submission by 100 milliseconds
    });

    function saveData(btn, url, inputs, errorEl){
        const config = {
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
                "X-Requested-With": "XMLHttpRequest"
            }
        };
        axios.post(url, inputs, config)
        .then(function(response){
            let message = response.data.message;
            //msg.css("color", "green").text(message);
            btn.attr("disabled", false).text("Submit");
            console.log(response.data.results);
            getAccounts(response.data.results);
        }).catch(function(error){
            let errors = error.response.data.error;
            if(errors.name){
                errorEl.eq(0).text(errors.name);
            }
            if(errors.price){
                errorEl.eq(1).text(errors.price);
            }
            btn.attr("disabled", false).text("Submit");
        });
    }
</script>
@include("admin.layouts.footer")