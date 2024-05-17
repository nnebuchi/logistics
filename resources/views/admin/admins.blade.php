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
                                    <form action="<?=route('subadmin.create')?>" method="POST">
                                        <div class="mt-2">
                                            <input type="text" name="firstname"
                                            placeholder="Firstname" class="w-100 form-control rounded-0">
                                            <span class="error"> </span>
                                        </div>
                                        <div class="mt-2">
                                            <input type="text" name="lastname"
                                            placeholder="Lastname" class="w-100 form-control rounded-0">
                                            <span class="error"> </span>
                                        </div>
                                        <div class="mt-2">
                                            <input type="email" name="email"
                                            placeholder="Email" class="w-100 form-control rounded-0">
                                            <span class="error"> </span>
                                        </div>
                                        <div class="mt-2">
                                            <input type="number" name="phone"
                                            placeholder="phone" class="w-100 form-control rounded-0">
                                            <span class="error"> </span>
                                        </div>
                                        <div class="mt-2">
                                            <select class="w-100 form-control rounded-0" name="role">
                                                <option value="">Choose...</option>
                                                @foreach($roles as $role)
                                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="error"> </span>
                                        </div>
                                        <div class="mt-2">
                                            <input type="text" name="password"
                                            placeholder="Password" class="w-100 form-control rounded-0">
                                            <span class="error"> </span>
                                        </div>
                                        <div class="d-flex justify-content-center mt-3">
                                            <button 
                                            type="button"
                                            id="createAdmin"
                                            class="custom-btn fs-4 fw-bold">
                                            Submit
                                            <img src="{{asset('assets/images/icons/auth/cil_arrow-right.svg')}}" width="20" class="mr-2" alt="">
                                            </button>
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

    (function(length = 15) {
        const lowercaseCharacters = 'abcdefghijklmnopqrstuvwxyz';
        const uppercaseCharacters = lowercaseCharacters.toUpperCase();
        const numbers = '0123456789';
        const symbols = '!@#$%^&*()-_=+[]{}\|;:,<.>/?'

        let password = '';
        let characterPool = lowercaseCharacters;
        characterPool += numbers;
        characterPool += symbols;

        for(let i = 0; i < length; i++){
            const randomIndex = Math.floor(Math.random() * characterPool.length);
            const randomCharacter = characterPool[randomIndex];
            password += randomCharacter;
        }

        $("input[name='password']").val(password);
    })();

    function getUsers(users){
        $(".users-table tbody").empty();
        if(users.length == 0){
            $(".users-table tbody").append(`
                <tr class="">
                    <td scope="row">No data available...</td>
                </tr> 
            `);
        }else{
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
    }
    getUsers(@json($admins));

    $(document).on("click", ".edit-user", function(event){
        event.preventDefault();
        const userId = $(this).data("id");
        const config = {
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
                "X-Requested-With": "XMLHttpRequest"
            }
        };
        axios.get(`${baseUrl}/admin/${userId}`, config)
        .then((res) => {
            let user = res.data.results;

            let userData = $("#userModal input");
            userData.eq(0).val(user?.firstname);
            userData.eq(1).val(user?.lastname);
            userData.eq(2).val(user?.email);
            userData.eq(3).val(user?.phone);
            userData.eq(4).val(userId);
            $("#userModal select[name='role']").val(user?.roles[0]["id"] ?? 1);
            $("#userModal").modal("show");
        });
    });

    $("#userModal .close").on("click", function(){
        $("#userModal").modal("hide");
    });
    $('#userModal').on('hidden.bs.modal', function (e) {
        $("#userModal").modal("hide");
    });

    $("#editAdmin").on("click", function(event){
        event.preventDefault();
        let btn = $(this);
        btn.html(`<img src="{{asset('assets/images/loader.gif')}}" id="loader-gif">`);
        btn.attr("disabled", true);
        let userId;
        let $form = $(this).closest("form");
        let inputs = {};
        $form.find("input, select").each(function(){
            var fieldName = $(this).attr("name");
            var fieldType = $(this).prop("tagName").toLowerCase();
            if(fieldType === "input" || fieldType === "select") {
                if(fieldName != "id"){
                    inputs[fieldName] = $(this).val();
                }else{
                    userId = $(this).val();
                }
            }
        });
        let url = $form.attr("action")+"/"+userId;
        let errorEl = $form.find('.error');
        errorEl.text('');
        // Append loader immediately
        setTimeout(() => {
            saveData(btn, url, inputs, errorEl)
        }, 100); // Delay submission by 100 milliseconds
    });

    $("#createAdmin").on("click", function(event){
        event.preventDefault();
        let btn = $(this);
        let $form = $(this).closest("form");
        url = $form.attr("action");
        btn.html(`<img src="{{asset('assets/images/loader.gif')}}" id="loader-gif">`);
        btn.attr("disabled", true);
        let inputs = {};
        $form.find("input, select").each(function(){
            var fieldName = $(this).attr("name");
            var fieldType = $(this).prop("tagName").toLowerCase();
            if(fieldType === "input" || fieldType === "select") {
                inputs[fieldName] = $(this).val();
            }
        });
        let errorEl = $form.find('.error');
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
            getUsers(response.data.results);
        }).catch(function(error){
            let errors = error.response.data.error;
            if(errors.firstname){
                errorEl.eq(0).text(errors.firstname);
            }
            if(errors.lastname){
                errorEl.eq(1).text(errors.lastname);
            }
            if(errors.email){
                errorEl.eq(2).text(errors.email);
            }
            if(errors.phone){
                errorEl.eq(3).text(errors.phone);
            }
            if(errors.role){
                errorEl.eq(4).text(errors.role);
            }
            if(errors.password){
                errorEl.eq(5).text(errors.password);
            }
            btn.attr("disabled", false).text("Submit");
        });
    }
</script>
@include("admin.layouts.footer")