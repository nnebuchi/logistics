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
                                    <form action="" method="POST">
                                        <div class="mt-2">
                                            <input type="text"
                                            placeholder="name" class="w-100 custom-input rounded-0">
                                        </div>
                                        <div class="mt-2">
                                            <input type="number"
                                            placeholder="price" class="w-100 custom-input rounded-0">
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
                                    <div class="">
                                        <input type="text"
                                        placeholder="name" class="w-100 form-control rounded-0">
                                    </div>
                                    <div class="mt-2">
                                        <input type="text"
                                        placeholder="price" class="w-100 form-control rounded-0">
                                    </div>

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
        accounts.forEach(function(account, index){
            $(".accounts-table tbody").append(`
                <tr style="">
                    <td scope="row">${index + 1}</td>
                    <td scope="row">${account.name}</td>
                    <td scope="row">${account.markup_price}%</td>
                    <td scope="row">
                        <a class="edit-account m-0 p-0" data-id="${account.id}" type="button">
                            <img width="20" height="20" src="{{asset('assets/images/icons/file-edit.svg')}}" />
                        </a>
                    </td>
                </tr>  
            `);
        })
    }
    getAccounts(@json($accounts));

    $(document).on("click", ".edit-account", function(event){
        event.preventDefault();
        const accountId = $(this).data("id");
        /*const config = {
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                Authorization: "Bearer "+ userToken
            }
        };
        axios.get(`${baseUrl}/api/v1/admin/${userId}`, config)
        .then((res) => {
            let user = res.data.results;

            let userData = $("#accountModal input");
            userData.eq(0).val(user?.firstname);
            userData.eq(1).val(user?.lastname);
            userData.eq(2).val(user?.email);
            userData.eq(3).val(user?.phone);
            //$("#accountModal select[name='account']").val(user?.account.id);
            $("#accountModal").modal("show");
        });*/
        $("#accountModal").modal("show");
    });

    $("#accountModal .close").on("click", function(){
        $("#accountModal").modal("hide");
    });
    $('#accountModal').on('hidden.bs.modal', function (e) {
        $("#accountModal").modal("hide");
    })
</script>
@include("admin.layouts.footer")