$(document).ready(function() {


    $('.datepicker').datepicker();
    $('[data-toggle="popover"]').popover();

    if(localStorage.getItem('offer') === undefined || localStorage.getItem('offer') === null) {
        $('#offerModal').modal();
    }


    $('.btn-refuse').click(function () {
        localStorage.setItem('offer', 'refuse');
    });

    $('.btn-accept').click(function () {
        localStorage.setItem('offer', 'accept');
    });
    /*
    Меняем цену за услугу в модальном окне, при изменении даты курса
     */
    $('select[name="whenStart"]').change(function () {
        $('#whenStartHelp b').text($(this).find('option:selected').data('price'));
    })

    /*
    Отправка формы ajax
     */
    $('#register-form').submit(function(e) {

        var msg   = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: msg,
            success: function(data) {

                $.notify("Sign in...", "success");
                $.notify("Registration completed successfully", "success");

                setTimeout(function () {
                   window.location.href = '/mycourses';
                }, 1000);



            },
            error:  function(xhr, str){
                var errors = $.parseJSON(xhr.responseText);
                var errorsArray = Object.values(errors);


                errorsArray.forEach(function(element) {
                    $.notify(element, "error");
                    $('.btn-register').prop('disabled','disabled');
                });


            }
        });
        e.preventDefault();
    });

    $('#register-client-form').submit(function(e) {

        var msg   = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: msg,
            success: function(data) {

                $.notify("Registration completed successfully", "success");

                setTimeout(function () {
                    window.location.href = '/mycourses';
                }, 1000);



            },
            error:  function(xhr, str){
                var errors = $.parseJSON(xhr.responseText);
                var errorsArray = Object.values(errors);


                errorsArray.forEach(function(element) {
                    $.notify(element, "error");
                    $('.btn-register').prop('disabled','disabled');
                });


            }
        });
        e.preventDefault();
    });


    $('#register-form').keyup(function () {
        $('.btn-register').prop('disabled',false);
    });

    $('select.form-control').change(function () {
        $('.btn-register').prop('disabled',false);
    });

    $('#rulesModal, #confModal').on('hidden.bs.modal', function () {
        $('#registerModal').show();
    })

    $('#showRules,#showConf').click(function () {
        $('#registerModal').hide();
    });

})