const getOriginalWordFromCompoundWord = (compound_word) => {
    
    return compound_word?.replaceAll('_', ' ').replaceAll('-', ' ')
}

const buchi_validate =  (input, constraints, alias=null) => {

    // Remove existing validation message
    $('.'+input?.getAttribute('id')+'-validation-message')?.remove();
    $('#'+input?.getAttribute('id'))?.css('border-color', '#89ABD9')
    // console.log()
    
    // $('#'+response.targetId).css('border-color', 'red');
    // $('#'+input.getAttribute('id')
    // REGEX for valid email fields
    const email_pattern = new RegExp('[a-z0-9]+@[a-z]+\.[a-z]{2,3}');
    
    // REGEX for special character fields
    const specialCharsRegex = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;

    const number = /[0-9]/g;
    
    // Rules Definition
    const rules = {
        required:{
            pass:constraints.required === true ? (input.getAttribute('type') != 'file' ? (input?.value?.length > 0): input.files.length > 0) : true,
            message:alias ===null ? getOriginalWordFromCompoundWord(input.getAttribute('id'))+" is required" : alias +" is required"
        },
        min_length:{
            pass:input.value.length > 0 ? input.value.length >= constraints.min_length : true,
            message:alias ===null ? getOriginalWordFromCompoundWord(input.getAttribute('id'))+" must have up to "+constraints.min_length+" characters" : alias +" must have up to "+constraints.min_length+" characters"
        },
        max_length:{
            pass:input.value.length > 0 ? input.value.length <= constraints.max_length : true,
            message:alias ===null ? getOriginalWordFromCompoundWord(input.getAttribute('id'))+" must not exceed "+constraints.max_length+" characters" : alias+" must not exceed "+constraints.max_length+" characters"
        },
        email:{
            pass: constraints.email === true && input.value.length > 0 ? email_pattern.test(input.value): true,
            message:alias ===null ? getOriginalWordFromCompoundWord(input.getAttribute('id'))+" must be a valid email" : alias+" must be a valid email"
        },
        has_special_character:{
            pass: constraints.has_special_character === true && input.value.length > 0 ? specialCharsRegex.test(input.value) : true,
            message:alias ===null ?  getOriginalWordFromCompoundWord(input.getAttribute('id'))+" must have special character" : alias+" must have special character"
        },
        must_have_number:{
            pass: input.value.length > 0 ? (constraints.must_have_number === true ? number.test(input.value) : true): true,
            message:alias ===null ?  getOriginalWordFromCompoundWord(input.getAttribute('id'))+" must have a number" : alias+" must have a number"
        },
        max_size:{
            pass:input.getAttribute('type') == 'file' ? (input.files.length > 0 ? input.files[0].size <= constraints.max_size : true): true,
            message:alias === null ? getOriginalWordFromCompoundWord(input.getAttribute('id'))+" must not exceed "+constraints.max_size+" kb" : alias+" must not exceed "+constraints.max_size+" kb"
        },
        match:{
            pass:constraints.hasOwnProperty('match') ? (input.value === document.querySelector(`#${constraints.match}`).value) : true,
            message:alias === null ? getOriginalWordFromCompoundWord(input.getAttribute('id'))+" does not match the "+getOriginalWordFromCompoundWord(constraints?.match)+" field" : alias+" does not match the "+getOriginalWordFromCompoundWord(constraints?.match)+" field"
        }
        // file_formats:{
        //     pass:input.getAttribute('type') == 'file' &&  input.files.length > 0 ?  constraints.file_formats.includes(input.files.ext): true,
        //     // message:alias === null ? input.getAttribute('id').replace('_', ' ') +" format is invalid" : alias+" format is invalid"
        //     message:alias === null ? input.getAttribute('id').replace('_', ' ') +" must be either of these formats: "+constraints.file_formats.toString() : alias+" must be either of these formats: "+constraints.file_formats.toString()
        // }
    }

    const feedback = [];
    
    for (let constraint in constraints){
        
        if(rules.hasOwnProperty(constraint)){
            
            if(rules[constraint].pass === false){
                feedback.push({
                    message:rules[constraint],
                    targetId:input.getAttribute('id')
                })
            }

        }else{
            
            alert('invalid rule '+constraint);
            return {
                status: 'fail',
                error: 'invalid rule '+constraint
            }
        }
       
    }

    feedback.forEach(function(response, index){
        $('#'+response.targetId).css('border-color', 'red');
        if($('#'+response.targetId).parent().hasClass('input-group')){
            $('#'+response.targetId).parent().after(`<p class="text-danger ${response.targetId}-validation-message">${response.message.message}</p>`);
        }else{
            $('#'+response.targetId).parent().after(`<p class="text-danger ${response.targetId}-validation-message">${response.message.message}</p>`);
        }
        
    })


    if(feedback.length === 0){
        
        return 'success';
    }else{
        return 'fail';
    }
    
}


const runValidation = (fields) =>{
   
    const negatives = []
    fields.forEach(function(field, index){
        const result = buchi_validate(document.querySelector("#"+field.id), field.rules, field.alias);
        console.log(result)
        if(typeof(result) == 'object' ){
            // showAlert('danger', result.error)
            alert(result.error)
            negatives.push(false);
            return;
        }
        else if(typeof(result) == 'string' && result === 'success'){
            negatives.push(true);
        }else{
            negatives.push(false);
        }
    });
  
    if(negatives.includes(false)){
        return false
    }else{
        return true;
    }
}


const setBtnLoading = (btn) => {
    btn.setAttribute('disabled', 'true');
    btn.innerHTML = `<i class="fa fa-spinner fa-spin"></i>`;
}

const setBtnNotLoading = (btn, html) => {
    btn.innerHTML = html
    btn.removeAttribute('disabled');
}

const showAlert = (color, message) => {
    const alert = `<div class="alert alert-${color} alert-dismissible fade show" role="alert" id="alert-div">
        <strong>Alert!</strong> <span id="alert-message">${message}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>`

    const clearAlert = () => {
        document.querySelector('.alert-holder').innerHTML = '';
    }

    document.querySelector('.alert-holder').innerHTML = alert;
    window.scrollTo({
        top: 0,
        left: 0,
        behavior: 'smooth'
    });
    setTimeout(clearAlert, 10000);
}

const togglePasswordReveal = (revealIconId, passwordFieldId) => {

    const passwordInput = $("#"+passwordFieldId);
  
    if(passwordInput.attr("type") === 'text'){
        passwordInput.attr("type", "password");
        $("#"+revealIconId).html("<i class='bi-eye'></i>");
    }else{
        passwordInput.attr("type", "text");
        $("#"+revealIconId).html("<i class='bi-eye-slash'></i>");
    }
}