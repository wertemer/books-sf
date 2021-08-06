/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).on('click', '#btnAddGenre', function(e) {
    var name=$('#genre_form_name').val();
    var res=$.ajax({
        url:"/genres/addGenre",
        type:"POST",
        data:{
            name:name,
        },
        dataType:"json"
    });
    res.done(function(data){
        alert(data);        
        window.location.href = '/genres';
    });
    res.fail(function(jqXHR,textStatus){
        //console.log(textStatus);
    });
});
$(document).on('click','#btnEditGenre',function(e){
    var name=$('#genre_form_name').val();
    var id=$('#hidden-id').val();
    var res=$.ajax({
        url:"/genres/editGenre",
        type:"POST",
        data:{
            id:id,
            name:name,
        },
        dataType:"json"
    });
    res.done(function(data){
        alert(data);        
        window.location.href = '/genres';
    });
    res.fail(function(jqXHR,textStatus){
        //console.log(textStatus);
    });
});

