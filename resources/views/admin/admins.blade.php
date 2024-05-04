@include("admin.layouts.header")
        <div class="container-fluid" style="background-color:#F6F6F7;">
            <!--  Row 1 -->
            <div class="row">
                <div class="col">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title fw-normal bg-white py-2 px-3 rounded-pill">Dashboard > Subadmins</h5>
                    </div>

                    <div class="row mt-3 justify-content-center">
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">
                            <div class="card">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table data-order="false" class="users-table table table-borderless text-nowrap mb-0 align-middle">
                                            <thead class="text-dark fs-4">
                                                <tr>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold">S/N</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold">Name</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold">Email</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold">Phone</h6>
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
                                            placeholder="Firstname" class="w-100 custom-input rounded-0">
                                        </div>
                                        <div class="mt-2">
                                            <input type="text"
                                            placeholder="Lastname" class="w-100 custom-input rounded-0">
                                        </div>
                                        <div class="mt-2">
                                            <input type="email"
                                            placeholder="Email" class="w-100 custom-input rounded-0">
                                        </div>
                                        <div class="mt-2">
                                            <input type="number"
                                            placeholder="phone" class="w-100 custom-input rounded-0">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('admin.modals.subadmin-modal')
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

    function getUsers(users){
        $(".users-table tbody").empty();
        users.forEach(function(user, index){
            $(".users-table tbody").append(`
                <tr style="">
                    <td scope="row">${index + 1}</td>
                    <td scope="row">${user.firstname+" "+user.lastname}</td>
                    <td scope="row">${user.email}</td>
                    <td scope="row">${user.phone}</td>
                    <td scope="row">
                        <a class="edit-user m-0 p-0" data-id="${user.id}" type="button">
                            <img width="20" height="20" src="{{asset('assets/images/icons/file-edit.svg')}}" />
                        </a>
                    </td>
                </tr>  
            `);
        })
    }
    getUsers(@json($admins));

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
        axios.get(`${baseUrl}/api/v1/admin/${userId}`, config)
        .then((res) => {
            let user = res.data.results;

            let userData = $("#userModal input");
            userData.eq(0).val(user?.firstname);
            userData.eq(1).val(user?.lastname);
            userData.eq(2).val(user?.email);
            userData.eq(3).val(user?.phone);
            //$("#userModal select[name='account']").val(user?.account.id);
            $("#userModal").modal("show");
        });
    });

    $("#userModal .close").on("click", function(){
        $("#userModal").modal("hide");
    });
    $('#userModal').on('hidden.bs.modal', function (e) {
        $("#userModal").modal("hide");
    })
</script>
@include("admin.layouts.footer")