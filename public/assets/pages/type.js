$(function(){
    $('#typeForm').validate({
        rules: {
            type_name: "required",
            type_name: {
                required: true,
                minlength: 2
            },
        },
        messages: {
            type_name: "Please enter a type name",
            type_name: {
                required: "Please enter a type name",
                minlength: "Your type must consist of at least 2 characters"
            },
        }
    });
})


