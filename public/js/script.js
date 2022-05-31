window.onload = () => {
    if(errors != ''){
        $('#loginModal').modal('show');
    }
    if(messages != ''){
        $('#messagesModal').modal('show');
    }
    if(books.length > 0){
        books.forEach(st => {
            $('#contentBook' + st).css('height', $('#imageBook' + st).height() - 20);
            $('#contentBook' + st).css('display', 'block');
        });
    }
    if(users.length > 0){
        users.forEach(st => {
            $('#contentUser' + st).css('height', $('#imageUser' + st).height() - 20);
            $('#contentUser' + st).css('display', 'block');
        });
    }
}

window.onresize = () => {
    if(books.length > 0){
        books.forEach(st => {
            $('#contentBook' + st).css('height', $('#imageBook' + st).height() - 20);
        });
    }
    if(users.length > 0){
        users.forEach(st => {
            $('#contentUser' + st).css('height', $('#imageUser' + st).height() - 20);
        });
    }
}

$('#image').change(function(event) {
    if(event.target.files.length > 0){
        $('#imgProfile').attr('src', URL.createObjectURL(event.target.files[0]));
        $('#imgProfileModal').attr('src', URL.createObjectURL(event.target.files[0]));
    } else {
        $('#imgProfile').attr('src', defaultImg);
        $('#imgProfileModal').attr('src', defaultImg);
    }
});

$('#btnFavorite').click(function(){
    getFavorite();
});

function getFavorite(){
    $.post(favoriteUrl, {_token: token, id: favoriteBook}, function(data){
        if(data){
            $('#btnFavorite').attr('class', 'btn btn-danger mt-6');
            $('#btnFavorite').text('Delete Favorite');
        } else {
            $('#btnFavorite').attr('class', 'btn btn-primary mt-6');
            $('#btnFavorite').text('Favorite');
        }
    });
}

var userPage = 1;

$('#searchUserModal').change(function() {
    userPage = 1;
    getUser();
});

$('#searchUserModal').keyup(function() {
    userPage = 1;
    getUser();
});

$('#btn-user').click(function(){
    $('#searchUserModal').focus();
    getUser();
});

$('#closeUserModal').click(function(){
    $('#userId').attr('value', '');
    $('#user-label').text('Click to Select User');
});

function getUser(){
    const value = $('#searchUserModal').val();
    const p = userPage; const pc = 8;
    $.get(`${usersUrl}?modal=true&s=${value}&p=${p}&pc=${pc}`, function(data){
        var data = JSON.parse(data);
        let content = '<main class="py-4"><div class="container">';
        const btnPage = [];
        if(Array.isArray(data.users)){
            content += `<div class="mt-1"></div>`;
            data.users.forEach(function(st, i) {
                num = 0;
                if(p == 1) num = i + 1;
                else num = i + 1 + ((p - 1) * pc);
                content += `<div class="card mt-2" ><div class="row ps-3 g-0"> <div class="col-md-2 align-self-center"><div class="row"><p class="align-middle" style="position: relative; bottom: -8px; padding-left: 20px; font-size: 18px;">${num}.</p></div></div><div class="col-md-6 align-self-center" ><div class="row row-cols-auto"><p class="align-middle align-self-center col overflow-auto" style="position: relative; margin-left: 10px; bottom: -8px;font-size: 18px; width: 60%;" >${st.name}</p><p class="align-middle align-self-center col" style="position: relative; margin-left: 10px; bottom: -8px; font-size: 18px; width: 30%" >Level : ${st.role}</p></div></div><div class="col-md-2 align-self-center"><div class="d-grid gap-2 m-2"><a class="btn btn-primary text-white" href="${userUrl}/${st.id}" target="_blank" aria-controls="Show User Modal">Show</a></div></div><div class="col-md-2 align-self-center pe-2"><div class="d-grid gap-2 m-2"><button class="btn btn-success" id="selectUserModal${st.id}" aria-controls="Select User Modal" data-bs-dismiss="modal">Select</button></div></div></div></div>`;
            });
            const tp = data.totalPages;
            content += `<div class="card mt-3"><div class="card-body"><nav aria-label="Page navigation example"><ul class="pagination justify-content-end">
            <li class="page-item `;
            if(p <= 1){ content += `disabled`; }
            content += `"><button class="page-link" id="pageControlUserModal${p-1}" tabindex="-1"`;
            if(p <= 1){ content += `aria-disabled="true";` }
                content += `>Previous</button></li>`;
            if(p <= 1){
                content += `<li class="page-item active"><button class="page-link" id="pageUserModal${p}">${p}</button></li>`; btnPage.push(p);
            }else if(p > 1 && (p < tp || tp <= 2)) {
                content += `<li class="page-item"><button class="page-link" id="pageUserModal${p-1}">${p-1}</button></li>`; btnPage.push(p-1);
            }else{
                content += `<li class="page-item"><button class="page-link" id="pageUserModal${p-2}">${p-2}</button></li>`; btnPage.push(p-2);
            }
            if(tp >= 2){
                if(p > 1 && (p < tp || tp <= 2)){
                    content += `<li class="page-item active"><button class="page-link" id="pageUserModal${p}">${p}</button></li>`; btnPage.push(p);
                }else if(p <= 1){
                    content += `<li class="page-item"><button class="page-link" id="pageUserModal${p+1}">${p+1}</button></li>`; btnPage.push(p+1);
                }else{
                    content += `<li class="page-item"><button class="page-link" id="pageUserModal${p-1}">${p-1}</button></li>`; btnPage.push(p-1);
                }
            }
            if(tp >= 3){
                if(p <= 1){
                    content += `<li class="page-item"><button class="page-link" id="pageUserModal${p+2}">${p+2}</button></li>`; btnPage.push(p+2);
                }else if(p > 1 && p < tp){
                    content += `<li class="page-item"><button class="page-link" id="pageUserModal${p+1}">${p+1}</button></li>`; btnPage.push(p+1);
                }else{
                    content += `<li class="page-item active"><button class="page-link" id="pageUserModal${p}">${p}</button></li>`; btnPage.push(p);
                }
            }
            content += `<li class="page-item `;
            if(p >= tp){ content += `disabled`; }
            content += `"><button class="page-link" id="pageControlUserModal${p+1}">Next</button></li></ul></nav></div></div>`;
        } else {
            content += `<div class="card mt-1"><div class="card-body" style="font-size: 18px;">Status Code 404 : Users Not Found!</div></div>`;
        }
        content += `</div></main><div style="margin-top: 200px;"></div>`;
        $('#userModalContent').html(content);
        if(Array.isArray(data.users)){
            data.users.forEach(function(st){
                $(`#selectUserModal${st.id}`).click(function() {
                    $('#userId').attr('value', st.id);
                    $('#userName').attr('value', st.name);
                    $('#userLabel').text(st.name);
                });
            });
        }
        btnPage.forEach(function(st){
            $(`#pageUserModal${st}`).click(function(){
                userPage = st;
                getUser();
            });
            $(`#pageControlUserModal${st}`).click(function(){
                userPage = st;
                getUser();
            });
        });
    });
}


