const displayError = (formId, index, fieldName, errorMessage) => {
    $(`#${formId} .error`).eq(index).text(errorMessage);
    $(`#${formId} input[name='${fieldName}']`).css("border", "1px solid #FA150A");
};

const validate = (formId, inputsArray) => {
    const errors = {};

    inputsArray.forEach(({ inputName, inputValue, constraints }, index) => {
        const { 
            required, string, min_length, max_length, email, phone, 
            has_special_character, must_have_number, match, numeric, integer 
        } = constraints;
        const inputField = $(`#${formId} input[name='${inputName}']`);

        const specialCharsRegex = /[!@#$%^&*(),.?":{}|<>]/;
        const numberRegex = /\d/;
    
        const validationRules = {
            required: required ? !!inputValue : true,
            string: string ? typeof inputValue === 'string' || !inputValue : true,
            phone: phone ? /^\+?[0-9]+$/.test(inputValue) || !inputValue : true,
            min_length: inputValue.length >= min_length || !min_length,
            max_length: inputValue.length <= max_length || !max_length,
            email: email ? /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(inputValue) || !inputValue : true,
            has_special_character: has_special_character ? specialCharsRegex.test(inputValue) || !inputValue : true,
            must_have_number: must_have_number ? numberRegex.test(inputValue) || !inputValue : true,
            match: match ? (inputValue === match) || !inputValue : true,
            numeric: numeric ? !isNaN(parseFloat(inputValue)) && isFinite(inputValue) || !inputValue : true,
            integer: integer ? Number.isInteger(Number(inputValue)) || !inputValue : true,
        };
        
        // If underscore is present, replace it with a space
        if(inputName.includes("_")){
            inputName = inputName.replace("_", " ");
        }
        const errorMessages = {
            required: inputName+' field is required',
            string: inputName + ' must be a string',
            phone: inputName + ' must be a valid phone number',
            min_length: inputName+` must have at least ${min_length} characters`,
            max_length: inputName+` must not exceed ${max_length} characters`,
            email: inputName+' must be a valid email',
            has_special_character: inputName+' must have special characters',
            must_have_number: inputName+' must have a number',
            match: 'Does not match the specified field',
            numeric: "Please enter a valid number.",
            integer: "Please enter a valid integer."
        };
    
        /*const failedRules = Object.entries(validationRules)
        .filter(([rule, pass]) => !pass)
        .map(([rule]) => errorMessages[rule]);

        if (failedRules.length > 0) {
            errors[inputName] = failedRules;
        }*/
        
        Object.entries(validationRules)
        .filter(([rule, pass]) => !pass)
        .forEach(([rule]) => {
            if (!errors[inputName]) {
                errors[inputName] = [];
            }
            errors[inputName].push(errorMessages[rule]);
            displayError(formId, index, inputName, errorMessages[rule]);
        });
    });

    return errors;
};