$(function () 
{
    let token = $("meta[name='csrf-token']").attr("content");
    let baseUrl = $("meta[name='base-url']").attr("content");
    var authToken = localStorage.getItem('adminToken');

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

    const statusClasses = {
        pending: "bg-warning",
        verified: "bg-success",
        suspended: "bg-danger",
        rejected: "bg-danger"
    };

    function getAllDoctors(doctors = doctorsJson, currentPage=0)
    {
        $('.doctors-table').DataTable().destroy();
        $('.doctors-table').DataTable({
            data: doctors,
            columns: [
                { 
                    data: null,
                    render: function(data, type, row){
                        let photo = data["profile"]["photo"];
                        if(photo != null){
                            return `<div class="user-card">
                                <div class="user-avatar sm">
                                    <img src="${photo}" class="w-100 h-100">
                                </div>
                                <div class="user-name">
                                    <h6 class="fw-semibold mb-1">${data["name"]}</h6>                        
                                </div>
                            </div> 
                            `;
                        }else{
                            return `<div class="user-card">
                                <div class="user-avatar sm" style="background-color:${getRandomColor()}">
                                    <span>${getInitials(data["name"])}</span>
                                </div>
                                <div class="user-name">
                                    <h6 class="fw-semibold mb-1">${data["name"]}</h6>                        
                                </div>
                            </div> `
                        }
                    }
                },
                { data: "email"},
                { data: "phone"},
                { 
                    data: null,
                    render: function(data, type, row){
                        let image = data["profile"]["photo"];
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
                        let image = data["profile"]["license"];
                        if(image == null){
                            return "";
                        }else{
                            return `<a href=${image} class="rounded-0 license">
                                <img src="${image}" style="width:50px;height:30px;" />
                            </a>`
                        }
                    }
                },
                { 
                    data: null,
                    render: function(data, type, row){
                        let image = data["profile"]["certificate"];
                        if(image == null){
                            return "";
                        }else{
                            return `<a href=${image} class="rounded-0 certificate">
                                <img src="${image}" style="width:50px;height:30px;" />
                            </a>`
                        }
                    }
                },
                { 
                    data: null,
                    render: function(data, type, row){
                        var status = data["status"];
                        return '<span class="badge rounded-3 fw-semibold '+statusClasses[status]+'">'+status+'</span>'
                    }
                },
                { 
                    data: null,
                    render: function(data, type, row){
                        return `
                        <a class="send-mail" data-id="${data['id']}" type="button">
                            <img src="{{asset('assets/images/icons/mail.svg')}}" />
                        </a>`;
                    }
                },
                { 
                    data: null,
                    render: function(data, type, row){
                        return `
                        <a class="view-user" data-id="${data['id']}" type="button">
                            <img src="{{asset('assets/images/icons/eye.svg')}}" />
                        </a>`;
                    }
                },
                { 
                    data: null,
                    render: function(data, type, row){
                        return `
                        <a class="view-schedules" data-id="${data['id']}" type="button">
                            <img src="{{asset('assets/images/icons/calendar.svg')}}" />
                        </a>`;
                    }
                }
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
            //"page": currentPage,
            "displayStart": currentPage,
            //"pagingType": "full_numbers",
            "createdRow": function(row, data, index){
                console.log("Column 10 Data:", data["status"]);
                if(data["status"] == "verified"){
                    $(row).addClass("bg-secondary");
                }else if (data["status"] == "suspended") {
                    $(row).addClass("bg-white");
                }else{
                    $(row).addClass("bg-white");
                }
            }
        });
    }
    getAllDoctors();
})