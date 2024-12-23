$(function(){
    $('#genreForm').validate({
        rules: {
            genre_name: "required",
            genre_name: {
                required: true,
                minlength: 2
            },
        },
        messages: {
            genre_name: "Please enter a genre name",
            genre_name: {
                required: "Please enter a genre name",
                minlength: "Your genre must consist of at least 2 characters"
            },
        }
    });
})


