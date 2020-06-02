$(document).ready(function () {
    'use strict';
    $('#form_titre').autocompleter({
        url_list: 'location/search-location',
        url_get: '/?term='
    });


    $("#ui-id-1").click(function(){
        var id = $("#form_titre").val();

        if(id.toString().length > 0){
            $(location).attr('href', '/location/'+id.toString());
        }
    })

});