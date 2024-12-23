$(function(){
    $('#categoryForm').validate({
        rules: {
            category_name: "required",
            category_name: {
                required: true,
                minlength: 2
            },
        },
        messages: {
            category_name: "Please enter a category name",
            category_name: {
                required: "Please enter a category name",
                minlength: "Your category must consist of at least 2 characters"
            },
        }
    });
})


