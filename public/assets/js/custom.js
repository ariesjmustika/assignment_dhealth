// ARIES
$(document).ready(function () {
    var token = localStorage.getItem('token');
    var email = localStorage.getItem('email');
    var password = localStorage.getItem('password');

    // localStorage.setItem('token', '');
    // localStorage.setItem('email', '');
    // localStorage.setItem('password', '');

    // sweetalert format
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    // setting csrf token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    locationUrlChecking();

    // Start function Login Register
    // Login validation
    $('#form-login').validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true
            },
        },
        messages: {
            email: {
                required: "Please enter a email address",
                email: "Please enter a valid email address"
            },
            password: {
                required: "Please provide a password",
                // minlength: "Your password must be at least 8 characters long"
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function (form) {
            $.ajax({
                url: form.action,
                type: form.method,
                dataType: 'json',
                data: $(form).serialize(),
                success: function (res) {
                    localStorage.setItem('token', res.access_token);
                    localStorage.setItem('email', res.email);
                    window.location.href = window.location.origin + '/api/project/project';
                },
                statusCode: {
                    401: function () {
                        Swal.fire({
                            title: 'ERROR',
                            text: "Email or password incorrect!",
                            icon: 'error',
                            showCancelButton: false,
                            showConfirmButton: false
                        })
                        // alert('email or password incorrect!');
                    }
                },

            });
        }
    });

    // Register validation
    $('#form-register').validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true
            },
            password2: {
                required: true,
                equalTo: '#password'
            },
        },
        messages: {
            name: {
                required: "Please enter a Full name",
                // string: "Please enter string only"
            },
            email: {
                required: "Please enter a email address",
                email: "Please enter a valid email address"
            },
            password: {
                required: "Please provide a password",
            },
            password2: {
                required: "Please provide a Retype-password",
                equalTo: "Password harus sama",
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function (form) {
            $.ajax({
                url: form.action,
                type: form.method,
                dataType: 'json',
                data: $(form).serialize(),
                success: function (res) {
                    localStorage.setItem('email', $('#email').val());
                    localStorage.setItem('password', $('#password').val());
                    window.location.href = window.location.origin + '/login';
                    Toast.fire({
                        icon: 'success',
                        title: 'Akun berhasil di buat!'
                    });
                },

            });
        }
    });
    // End function Login Register



    // Start function admin
    // Initialization
    function init() {
        // chekcingUserLoggin();
        $('.user-login-name').html(email);
        $('#table_data').empty();
        $('.client_id').find('option').not(':first').remove();
        var url = '/api/project/get-projects',
            data = '';
        getListData(url, data);
    }

    // add project
    $('#add-btn').click(function () {
        $('#form-add')[0].reset();
        var title_modal = 'Add Project',
            btn_modal = 'Save',
            url = '/api/project/create',
            toast_title = 'buat',
            toast_icon = 'success';
        createUpdateForm(title_modal, btn_modal, url, toast_title, toast_icon);
    });

    // update project
    $('#table_data').on('click', '.btn_edit', function () {
        var project_id = $(this).data('project_id')
        project_name = $(this).data('project_name'),
            client_id = $(this).data('client_id'),
            project_start = $(this).data('project_start'),
            project_end = $(this).data('project_end'),
            project_status = $(this).data('project_status');

        $('#project_id').val(project_id);
        $('#project_name').val(project_name);
        $('#client_id').val(client_id);
        $('#project_start').val(project_start);
        $('#project_end').val(project_end);
        $('#project_status').val(project_status);


        var title_modal = 'Update Project',
            btn_modal = 'Update',
            url = '/api/project/update',
            toast_title = 'ubah',
            toast_icon = 'info';
        createUpdateForm(title_modal, btn_modal, url, toast_title, toast_icon);


    });

    // delete project
    $('#delete-btn').click(function () {
        var project_name = '',
            project_id = '';

        // checking selected checkbox
        var checked = $('.check-class').filter(':checked');
        if (checked.length == 0) {
            Swal.fire({
                title: 'ERROR',
                text: "Checked one of data if you want to delete!",
                icon: 'error',
                showCancelButton: false,
                showConfirmButton: false
            })
            return 0;
        }

        checked.each(function () {
            var data = $(this).val().split(" ");
            project_id += data[0] + ' ';
            project_name += data[1] + ' ';
        });


        var title_modal = 'Delete Project',
            modal_text = 'Are you sure want to delete project ?',
            btn_text = 'Delete',
            url = '/api/project/destroy',
            method = 'post';
        // toast_title= 'ubah',
        // toast_icon= 'info';
        formDeleteLogout(title_modal, modal_text, btn_text, url, method);
        // alert(project_name);
        $('#deleted-list').html(project_name);
        $('#project_id_array').val(project_id);

        $('#modal-delete').modal('show');
        $('#form-delete').validate({
            submitHandler: function (form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    dataType: 'json',
                    headers: {
                        Authorization: 'Bearer ' + token
                    },
                    data: $(form).serialize(),
                    success: function (res, textStatus, xhr) {
                        init();
                        $('#modal-delete').modal('hide');
                        Toast.fire({
                            icon: 'error',
                            title: 'Projek ' + project_name + ' berhasil dihapus!'
                        });
                    },
                });
            }
        });
    });

    // check all checkbox
    $('.check-all').change(function () {
        (this.checked) ? $('.check-class').prop('checked', true): $('.check-class').prop('checked', false);
    });

    // search-filter
    $('#search-filter').click(function () {
        var project_name_filter = $('#project_name_filter').val();
        var client_id_filter = $('#client_id_filter').val();
        var project_status_filter = $('#project_status_filter').val();
        // alert(project_name_filter + ' ' + client_id_filter + ' ' + project_status_filter)
        localStorage.setItem('project_name_filter', project_name_filter);
        localStorage.setItem('client_id_filter', client_id_filter);
        localStorage.setItem('project_status_filter', project_status_filter);
        var url = '/api/project/get-projects',
            data = {
                project_name: project_name_filter,
                client_id: client_id_filter,
                project_status: project_status_filter,
            };
        // get projects  and clients datas
        $('#table_data').empty();
        $('.client_id').find('option').not(':first').remove();
        getListData(url, data);
    });

    // clear search filter
    $('#clear-filter').click(function () {
        $('#form-search')[0].reset();
        localStorage.setItem('project_name_filter', '');
        localStorage.setItem('client_id_filter', '');
        localStorage.setItem('project_status_filter', '');
        init();
    });

    // logout button
    $('#logout-btn').click(function (e) {
        $('#modal-delete').modal('show');
        var title_modal = 'Logout',
            modal_text = 'Are you sure want to logout?',
            btn_text = 'Yes',
            url = '/api/auth/logout',
            method = 'post';
        formDeleteLogout(title_modal, modal_text, btn_text, url, method);
        $('#form-delete').validate({
            submitHandler: function (form) {
                $.ajax({
                    url: window.location.origin + url,
                    type: form.method,
                    dataType: 'json',
                    headers: {
                        Authorization: 'Bearer ' + token
                    },
                    data: $(form).serialize(),
                    success: function (res, textStatus, xhr) {
                        localStorage.setItem('token', '');
                        localStorage.setItem('email', '');
                        window.location.href = window.location.origin + '/login';
                    },
                });
            }
        });


    });

    $('#refresh-btn').click(function () {
        token = localStorage.getItem('token');
        $.ajax({
            url: window.location.origin + '/api/auth/refresh',
            method: 'post',
            headers: {
                Authorization: 'Bearer ' + token
            },
            success: function (res) {
                console.log(res.access_token);
                localStorage.setItem('token', res.access_token);
            }
        });

    });

    $('#check-btn').click(function () {
        token = localStorage.getItem('token');
        alert(token);
    });


    // form create and update
    function createUpdateForm(title_modal, btn_modal, url, toast_title, toast_icon) {
        token = localStorage.getItem('token');
        $('#modal-storeUpdate').modal('show');
        $('#title-modal').html(title_modal);
        $('#btn-modal').html(btn_modal);
        $("#form-add").attr("action", window.location.origin + url);

        $('#form-add').validate({
            rules: {
                project_name: {
                    required: true
                },
                client_id: {
                    required: true
                },
                project_start: {
                    required: true
                },
                project_end: {
                    required: true
                },
                project_status: {
                    required: true
                },
            },
            messages: {
                project_name: {
                    required: "Project Name is required"
                },
                client_id: {
                    required: "Client Name is required"
                },
                project_start: {
                    required: "Project Start is required"
                },
                project_end: {
                    required: "Project End is required"
                },
                project_status: {
                    required: "Project Status is required"
                },

            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function (form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    dataType: 'json',
                    headers: {
                        Authorization: 'Bearer ' + token
                    },
                    data: $(form).serialize(),
                    success: function (res, textStatus, xhr) {
                        console.log(res);
                        var project_name = $('#project_name').val();
                        init();
                        $('#form-add')[0].reset();
                        $('#modal-storeUpdate').modal('hide');
                        Toast.fire({
                            icon: toast_icon,
                            title: 'Projek ' + project_name + ' berhasil di ' + toast_title + '!'
                        });
                    },

                    statusCode: {
                        401: function () {
                            $.ajax({
                                url: window.location.origin,
                                type: 'post',
                                dataType: 'json',
                                data: [{
                                    token: token
                                }],
                                success: function (res, textStatus, xhr) {
                                    localStorage.setItem('token', res.access_token);
                                }
                            });
                        }
                    },
                });
            }
        });
    }

    // get projects, clients datas
    function getListData(url, data) {
        token = localStorage.getItem('token');
        $.ajax({
            url: url,
            method: 'get',
            headers: {
                Authorization: 'Bearer ' + token
            },
            data: data,
            success: function (res) {
                var html = '';
                var i;
                for (i = 0; i < res.data.length; i++) {
                    debugger
                    var project_start = changeDateFormat(res.data[i].project_start),
                        project_end = changeDateFormat(res.data[i].project_end);
                    html += '<tr>' +
                        '<td><input type="checkbox" value="' + res.data[i].project_id + " " + res.data[i].project_name +
                        '" class="check-class selected-' + i + '">' +
                        '<td style="text-align:center;">' +

                        '<a  class=" btn btn_edit" data-project_id="' + res.data[i].project_id + '"data-project_name="' + res.data[i].project_name +
                        '"data-client_id="' + res.data[i].client_id + '"data-project_start="' + res.data[i].project_start +
                        '"data-project_end="' + res.data[i].project_end + '"data-project_status="' + res.data[i].project_status +
                        '"><i class="fas fa-edit" style="color:green;"></i></a>' +
                        '</td>' +
                        '<td>' + res.data[i].project_name + '</td>' +
                        '<td>' + res.data[i].client_name + '</td>' +
                        '<td>' + project_start + '</td>' +
                        '<td>' + project_end + '</td>' +
                        '<td>' + res.data[i].project_status + '</td>' +
                        '</tr>';
                }
                $('#table_data').append(html);
                // $('#table-project').DataTable().destroy();
                var table = $('#table-project').DataTable({
                    retrieve: true,
                    responsive: true,
                    // // stateSave: true,
                    // // select: true,
                    // // destroy: true,
                    // processing: true,
                    searching: false,
                    lengthChange: false,
                    // paginationType: "full_numbers",
                    pageLength: 5,
                    // order:[4, 'asc'],
                    // columnDefs: [{
                    //     orderable: false,
                    //     targets: 0
                    // }, {
                    //     orderable: false,
                    //     targets: 1
                    // }]
                });
                // table.draw();
            },
            statusCode: {
                401: function () {
                    refreshToken();
                },
            },
        });
        // get client list

        $.ajax({
            url: window.location.origin + '/api/client/get-clients',
            method: 'get',
            headers: {
                Authorization: 'Bearer ' + token
            },
            success: function (res) {
                var html = '';
                var i;
                debugger;
                for (i = 0; i < res.data.length; i++) {
                    html += '<option value=' + +res.data[i].client_id + '>' + res.data[i].client_name + '</option>';
                    debugger
                }
                $('.client_id').append(html);
            },
            statusCode: {
                401: function () {
                    refreshToken();
                },
            },

        });

        var project_name_filter = localStorage.getItem('project_name_filter');
        var client_id_filter = localStorage.getItem('client_id_filter');
        var project_status_filter = localStorage.getItem('project_status_filter');
        $('#project_name_filter').val(project_name_filter);
        $('#client_id_filter').val(client_id_filter);
        $('#project_status_filter').val(project_status_filter);
    }

    // refresh token
    function refreshToken() {
        token = localStorage.getItem('token');
        $.ajax({
            url: window.location.origin + '/api/auth/refresh',
            method: 'post',
            headers: {
                Authorization: 'Bearer ' + token
            },
            success: function (res) {
                console.log(res.access_token);
                localStorage.setItem('token', res.access_token);
            }
        });
    }

    // checking authenticated or not
    function isNotLogin() {
        token = localStorage.getItem('token');
        if (token == '' || token == null) {
            window.location.href = window.location.origin + '/login';
            return 0;
        }
    }

    function isLogin() {
        token = localStorage.getItem('token');
        if (token) {
            window.location.href = window.location.origin + '/api/project/project';
            return 0;
        }
    }

    // form delete logout text, btn, url changes
    function formDeleteLogout(title_modal, modal_text, btn_text, url, method) {
        token = localStorage.getItem('token');
        $('#title-modal-delete').html(title_modal);
        $('#modal-text').html(modal_text);
        $('#btn-text').html(btn_text);
        $("#form-delete").attr("action", window.location.origin + url);
        $("#form-delete").attr("method", method);
    }
    // End function admin


    // checking current url
    function locationUrlChecking() {
        var location = window.location.href;
        if (location.indexOf('login') != -1) {
            var email = localStorage.getItem('email');
            var password = localStorage.getItem('password');
            $('#email').val(email);
            $('#password').val(password);
            isLogin();
        } else if (location.indexOf('register') != -1) {

        } else {
            isNotLogin();
            init();
            setInterval(() => {
                if (token != '' || token != null) {
                    refreshToken();
                }
            }, 150000);

        }
    }

    // change month to bahasa
    function changeDateFormat(d) {
        var date = new Date(d);
        var dd = date.getDate();
        var yy = date.getFullYear();
        var mm = date.getMonth();
        const month = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
        return dd + ' ' + month[mm - 1] + ' ' + yy;
    }


});
