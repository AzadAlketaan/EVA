

$(document).ready(function(){
    $('input[id^="internalorder"]').click(function() {
        
        
        var address_id = document.getElementById("address_id");
        var externalorder = document.getElementById("externalorder[]");
        var Time = document.getElementById("Time");
      
        if (this.checked) {
            externalorder.checked = false; 
            Time.disabled = true;
            address_id.disabled = true;                               
            externalorder.disabled = true;    
            text.style.display = "block";
        }else{
            address_id.disabled = false;
            externalorder.disabled = false;
            Time.disabled = false;
            text.style.display = "none";
        }
    });
      
});

$(document).ready(function(){
    $('input[id^="externalorder"]').click(function() {
        
        
        var address_id = document.getElementById("address_id");
        var internalorder = document.getElementById("internalorder[]");
        var Time = document.getElementById("Time");
        var reservation_id = document.getElementById("reservation_id");

        if (this.checked) {
            internalorder.checked = false; 
            internalorder.disabled = true; 

            Time.disabled = false;

            reservation_id.disabled = true;

            address_id.disabled = false;                               
               
            text.style.display = "none";
        }else{
            internalorder.disabled = false; 

            reservation_id.disabled = false;
        
        }
    });
      
});

window.onload = function() {
        
    var Time = document.getElementById("Time");    
    var reservation_id = document.getElementById("reservation_id");
    var address_id = document.getElementById("address_id");
    
    var externalorder = document.getElementById("externalorder[]");
    var internalorder = document.getElementById("internalorder[]");
     
  
    if (internalorder.checked) {
        externalorder.checked = false; 
        Time.disabled = true;
        address_id.disabled = true;                               
        externalorder.disabled = true;    
        text.style.display = "block";     
    }
    if(externalorder.checked)
    {        
        internalorder.checked = false; 
        internalorder.disabled = true; 

        Time.disabled = false;

        reservation_id.disabled = true;

        address_id.disabled = false;                               
               
        text.style.display = "none";

    }
    
        
}