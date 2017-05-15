$(document).ready(function () {



    $( "#addFormComment" ).on( "submit", function(event ) {
        event.preventDefault();
        var data = $(this).serialize();
        var urll = $(this).attr('action');

        $("#exText").val("");

        $.post(urll, data, function (html) {
            $("#getAll").html(html);
        });


    });

    $("body").on("click","#btn_pagenation",function (e) {
        e.preventDefault();

        var go_btn = $(this).attr("data-item");

        $.post(url+"/comment/ajaxPagination",{"page":go_btn}, function (html) {
            $("#getAll").html(html);
        });

    });


    $("body").on("click","#btn_your_pagenation", function (e) {
        e.preventDefault();

        var go_btn = $(this).attr("data-itemTwo");

        $.post(url+"/comment/ajaxYourPagination",{"pages":go_btn}, function (html) {

            $("#getOne").html(html);
        });

    });

    $("body").on("click","#btnDel", function (e) {
        e.preventDefault();

        var go_btn = $(this).attr("data-itemDel");

        $.post(url+"/comment/getAjYour",{"itemDel":go_btn}, function (html) {

            $("#getOne").html(html);
        });

    });




    $("body").on("click",".btn_hidden_id" ,function (e) {
        e.preventDefault();
        var me = $(this);
        var id = me.attr("id");

        $("input#idUses").val(id);

    });



    $(".butT").on("click", function (el) {

        $("#mySMethod").collapse('toggle');



    });

    $(".butD").on("click", function () {
        $("#myFMethod").collapse('toggle');

    });


});































