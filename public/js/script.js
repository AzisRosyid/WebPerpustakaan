window.onload = () => {
    if(errors != ''){
        $('#loginModal').modal('show');
    }
    if(messages != ''){
        $('#messagesModal').modal('show');
    }
    if(books != []){
        books.forEach(st => {
            $('#contentBook' + st).css('height', $('#imageBook' + st).height() - 20);
            $('#contentBook' + st).css('display', 'block');
        });
    }
    if(users != []){
        users.forEach(st => {
            $('#contentUser' + st).css('height', $('#imageUser' + st).height() - 20);
            $('#contentUser' + st).css('display', 'block');
        });
    }
}

window.onresize = () => {
    if(books != []){
        books.forEach(st => {
            $('#contentBook' + st).css('height', $('#imageBook' + st).height() - 20);
        });
    }
    if(users != []){
        users.forEach(st => {
            $('#contentUser' + st).css('height', $('#imageUser' + st).height() - 20);
        });
    }
}

$('#image').change(function(event) {
	$('#imgProfile').attr('src', URL.createObjectURL(event.target.files[0]));
    $('#imgProfileModal').attr('src', URL.createObjectURL(event.target.files[0]));
});


