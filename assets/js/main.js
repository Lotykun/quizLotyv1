/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

$(document).ready(function() {
    console.log( "document loaded" );
    $( "#questresult button" ).click(function() {
        $( "#totalresults" ).hide();
        $( "#questionresults" ).show();
    });
    $( "#totresult button" ).click(function() {
        $( "#questionresults" ).hide();
        $( "#totalresults" ).show();
    });
    $( "button.closePOPUP" ).click(function() {
       $(this).parent().parent().hide();
    });
    $("#action button").click(function() {
        if ($('.question').css('display') == 'none' ){
            $('.question').fadeIn();
        }else if($('#response1').css('display') == 'none' ){
            $('#response1').fadeIn();
        }else if($('#response2').css('display') == 'none' ){
            $('#response2').fadeIn();
        }else if($('#response3').css('display') == 'none' ){
            $('#response3').fadeIn();
        }else if($('#response4').css('display') == 'none' ){
            $('#response4').fadeIn();
        }else{
            setTimeout(function(){
                //window.location.replace("http://stackoverflow.com");
                var data = new FormData();
                var question_id = getUrlParameter('question');
                
                alert("TIEMPO ACABADO");

                data.append('question_id',question_id);
                
                jQuery.ajax({
                    url:'ajax.php',
                    type:'POST',
                    data:data,
                    contentType:false,
                    processData:false,
                    cache:false,
                    dataType:'json',
                    success:function(response){
                        if (response == "OK - PROCESO COMPLETADO"){
                            alert("DATOS GUARDADOS");
                            window.location.href = window.location.href + "&true";
                        } else {
                            alert("ERROR - HA HABIDO ALGUN ERROR");
                        }
                    }
                });
            },20000);
        }
    });
});


