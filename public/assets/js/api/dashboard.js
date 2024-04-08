$(function () 
{
    //const basUrl = document.querySelector('script[data-baseurl]').dataset.baseurl;
    //alert(basUrl);

    let token = $("meta[name='csrf-token']").attr("content");
    let baseUrl = $("meta[name='base-url']").attr("content");
    var authToken = localStorage.getItem('adminToken');
    //axios.defaults.headers.common["Authorization"] = "Bearer " + authToken;
    //axios.defaults.baseURL = baseUrl;
    //axios.defaults.headers.post["Content-Type"] = "application/json";

    
    (function() {
        const getDaysInMonth = (month, year) => {
            const date = new Date(year, month, 0);
            return date.getDate();
        };
    
        const getDaysInMonthArray = (month, year) => {
            const daysInMonth = getDaysInMonth(month, year);
            const daysArray = [];
            for (let i = 1; i <= daysInMonth; i++) {
                daysArray.push(i);
            }
            //return daysArray;
            daysArray.forEach(function(day, index){
                $("select[name='day']").append(`
                    <option value="">${day}</option>
                `)
            })
            $("input[name='year']").val(new Date().getFullYear())
        };
    
        getDaysInMonthArray(2, new Date().getFullYear());
    
        $("select[name='month']").on("change", function(){
            $("select[name='day']").empty();
            getDaysInMonthArray(parseInt($(this).val()), new Date().getFullYear());
        })
    });

    $("#broadcastModal #searchUser").on("keyup", function() {
        var searchTerm = $(this).val().toLowerCase();
        let options = $("#recipient option");
        options.each(function(index, element) {
            if ($(this).text().toLowerCase().indexOf(searchTerm) === -1) {
                //
            }else {
                $("#recipient").val($(this).val());
            }
        });
    });

    $("#change-password").on("submit", function(event){
        event.preventDefault();
        const form = event.target;
        const url = form.action;
        let btn = $(this).find("button[type='submit']");
        btn.html(`<img src="/assets/images/loader.gif" style="width:20px;height:20px;">`);
        btn.attr("disabled", true);
        let inputs = {
            current_password: $("#change-password input[name='current_password']").val(),
            password: $("#change-password input[name='password']").val(),
            confirm_password: $("#change-password input[name='confirm_password']").val(),
        }

        $('.error').text('');
        $('#change-password .message').text('');
        const config = {
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                "Authorization": "Bearer "+authToken
            }
        };
        axios.post(url, inputs, config)
        .then(function(response){
            let message = response.data.message;
            $('#change-password .message').css("color", "green");
            $('#change-password .message').text(message);
            btn.attr("disabled", false);
            btn.text("Submit");
            //window.location.href = "<?=url('/logout')?>";
        })
        .catch(function(error){
            let errors = error.response.data.error;
            if(errors.current_password){
                $('#change-password .error').eq(0).text(errors.current_password);
            }
            if(errors.password){
                $('#change-password .error').eq(1).text(errors.password);
            }
            if(errors.confirm_password){
                $('#change-password .error').eq(2).text(errors.confirm_password);
            }

            switch(error.response.status){
                case 400:
                    $("#change-password .message").text(error.response.data.message)
                break;
                case 401:
                    $("#change-password .message").text(error.response.data.message);
                break;
            }
            btn.attr("disabled", false);
            btn.text("Submit");
        });
    });

    $("#send").on("click", function(event){
        event.preventDefault();
        let url = $(this).data("url");
        let btn = $(this);
        btn.html(`<img src="/assets/images/loader.gif" style="width:20px;height:20px;">`);
        btn.attr("disabled", true);
        let inputs = {
            recipient: $("#broadcastModal select[name='recipient']").val(),
            title: $("#broadcastModal input[name='title']").val(),
            message: $("#broadcastModal textarea[name='message']").val()
        }
        let errorEl = $('#broadcastModal .error');
        
        errorEl.text('');
        $('#broadcastModal .message').text('');
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
            $("#broadcastModal .message").css("color", "green");
            $("#broadcastModal .message").text(message);
            btn.attr("disabled", true);
            btn.text("Notifications sent");
        })
        .catch(function(error){
            let errors = error.response.data.error;
            if(errors.title){
                errorEl.eq(0).text(errors.title);
            }
            if(errors.message){
                errorEl.eq(1).text(errors.message);
            }

            btn.attr("disabled", false);
            btn.text("Send Now");
        });
    });

})