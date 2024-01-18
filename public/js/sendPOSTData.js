//$(function(){    
//    console.log('Попытка отправки методом POST');
//    send_post();
//});
//
//function send_post() 
//{
//    $('#form_edit').submit(function(){//'button.btn.btn-primary'
//        //let content = $(this).data('contentId');
//        console.log('21111111111111111111111111111111111'); //content+
//        console.log($(this).serializeArray());
        //console.log(this.value);
        //console.log(content);
//        $.post(
//                '/user/48/edit', 
//                {user:this.value}
//        )
//        .done (function(obj){
//            console.log('Ответ получен', obj);
//            //$('.summary' + content).replaceWith(obj);
//        })
//        .fail(function(xhr, status, error){
//            console.log('Ошибка соединения с сервером (POST)');
//            console.log('ajaxError xhr:', xhr); // выводим значения переменных
//            console.log('ajaxError status:', status);
//            console.log('ajaxError error:', error);
//        });        
//        return false;        
//    });
//    $("button#send.btn.btn-primary").click(function () {
//        $("#form_edit").submit();
//    });
//}
$(document).ready(function(){     
    $("#send").click(function () {
        $("#form_edit").submit();
    });
    $("#form_edit").submit(function (event) {
        //console.log('21111111111111111111111111111111111');
        let olddata = $(this).serializeArray();
        let route = $("#send").data('route');
        let postKey = route.match(/(?<=\/)\w+/i)[0];
        console.log('Маршрут: ' + route);
        //console.log(olddata);
        let newdata = {};
        $.each(olddata, function (_, v) {
            let key = v.name.match(/(?<=\[)\w+/i)[0];
            newdata[key] = v.value;
        });
        console.log(newdata);
        event.preventDefault();
        $.post(
                route,
                {[postKey]: newdata}
        )
        .done (function(obj){
            let nextRoute = route.match(/^\/\w+\//i)[0];
            console.log('Ответ получен');//, obj
            console.log('Маршрут: ' + nextRoute);
            window.location.href = nextRoute;
        })
        .fail(function(xhr, status, error){
            let errorMessage = '<div class="alert alert-danger">Ошибка: логин ' +
                `"${newdata.login}"` + ' задействован.</div>';
            $('#unique_error').html(errorMessage);
            console.log('Ошибка соединения с сервером (POST)');
            console.log('ajaxError xhr:', xhr.responseText); // выводим значения переменных
            console.log('ajaxError status:', status);
            console.log('ajaxError error:', error);
        });
        return false;
    });

});