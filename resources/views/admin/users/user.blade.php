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

                    <div class="row mt-5">
                        <div class="col-12 d-flex align-items-stretch">
                            <div class="card w-100">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table data-order="false" class="users-table table text-nowrap mb-0 align-middle">
                                            <thead class="text-dark fs-4">
                                                <tr>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-0">S/N</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-0">Name</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-0">Email</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-0">Phone</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-0">Account</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-0">photo</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-0">View</h6>
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

    $('.users-table').DataTable({
        data: @json($users),
        columns: [
            { 
                data: null,
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta){
                    let serial = meta.row + meta.settings._iDisplayStart + 1;
                    return serial;
                }
            },
            { 
                data: null,
                render: function(data, type, row){
                    let photo = data["photo"];
                    let name = data["firstname"]+ " "+data["lastname"]
                    return name;
                }
            },
            { data: "email"},
            { data: "phone"},
            { data: "account.name"},
            { 
                data: null,
                render: function(data, type, row){
                    let image = data["photo"];
                    if(image == null){
                        return "";
                    }else{
                        return `<a href=${image} class="rounded-0 photo">
                            <img src="${image}" style="width:50px;height:30px;" />
                        </a>`
                    }
                }
            },
            { 
                data: null,
                render: function(data, type, row){
                    return `<button data-id="${data.id}" 
                    class="btn btn-light view-user" type="button">View</button>`;
                    return `
                    <a class="view-child" data-id="${data['id']}" type="button">
                        <img src="{{asset('assets/images/icons/eye.svg')}}" />
                    </a>`;
                }
            },
            { 
                data: null,
                render: function(data, type, row){
                    var verified = data["is_verified"];
                    if(verified){
                        return `<img 
                        src="{{asset('assets/images/icons/auth/success-icon.svg')}}" 
                        width="20" height="20" />`;
                    }else{
                        return `<img 
                        src="{{asset('assets/images/icons/auth/warning-icon.svg')}}" 
                        width="20" height="20" class="mr-2" />`;
                    }
                }
            }
            /*{ 
                data: null,
                render: function(data, type, row){
                    return `
                    <a class="send-mail" data-id="${data['id']}" type="button">
                        <img src="{{asset('assets/images/icons/mail.svg')}}" />
                    </a>`;
                }
            },*/
        ],
		columnDefs: [{
			targets: "datatable-nosort",
			orderable: false,
		}],
		"language": {
			"info": "_START_-_END_ of _TOTAL_ entries",
			searchPlaceholder: "Search users",
			paginate: {
				next: '<ion-icon name="chevron-forward-outline"></ion-icon>',
                previous: '<ion-icon name="chevron-back-outline"></ion-icon>'   
			}
		},
        "pageLength": 20,
        "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
        //"page": 5,
        //"pagingType": "full_numbers",
        "createdRow": function(row, data, index){
            let verified = data["is_verified"];
            if(verified){
               $(row).css("background-color", "#233E830D");
            }else{
               //$(row).addClass("bg-white");
            }
        }
	});

    $(document).on("click", ".view-user", function(event){
        event.preventDefault();
        const userId = $(this).data("id");
        console.log("User ID:", userId);
        alert(userId);
        /*axios.get(`${baseUrl}/api/user/${userId}`)
        .then((res) => {
            let user = res.data.results;

            let userData = $(".user-data");
            userData.eq(0).text(user?.first_name+" "+user?.last_name);
            userData.eq(1).text(user?.email);
            userData.eq(2).text(user?.phone);
            userData.eq(3).text(user?.dob);
            userData.eq(4).text(user?.gender);
            userData.eq(5).text(user?.occupation);
            userData.eq(6).text(user?.state?.name);
            userData.eq(7).text(user?.city?.name);
            $('#userModal .avatar').attr("src", imageUrl+user?.profile_photo);
            $("#userModal").modal("show");
        });*/
    });
</script>
@include("admin.layouts.footer")