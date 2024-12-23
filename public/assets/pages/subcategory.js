$(function(){
    $('#subcategoryForm').validate({
        rules: {
            subcategory_name: "required",
            category: "required",
            subcategory_name: {
                required: true,
                minlength: 2
            },
        },
        messages: {
            subcategory_name: "Please enter a subcategory name.",
            subcategory_name: {
                required: "This field is required.",
                minlength: "Your subcategory must consist of at least 2 characters"
            },
        }
    });
})


