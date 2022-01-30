

$(document).ready(function(){
    $('input[id^="publicaddress"]').click(function() {
        
        var publicaddress = document.querySelectorAll('input[id^="publicaddress"]');
        var user_id = document.getElementById("user_id");
        var restaurant_id = document.getElementById("restaurant_id");
        
        if (this.checked) {
           // alert("uncheck");
           user_id.disabled = true;
           restaurant_id.disabled = true;      
        }else{
            user_id.disabled = false;
           restaurant_id.disabled = false;
        }
           
    });
      
});

window.onload = function() {
        
    var publicaddress = document.getElementById("publicaddress");
    var user_id = document.getElementById("user_id");
    var restaurant_id = document.getElementById("restaurant_id");
   
    if (publicaddress.checked) {
        //alert("uncheck");
       user_id.disabled = true;
       restaurant_id.disabled = true;      
    }else{
        user_id.disabled = false;
       restaurant_id.disabled = false;
    }
       
}