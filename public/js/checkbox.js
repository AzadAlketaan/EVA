$(document).ready(function(){
    $('input[id^="check"]').click(function() {
        var inputFields = document.querySelectorAll('input[id^="check"]');
        nbIF = inputFields.length;
        nbIFf = inputFields.length;

    if(this.checked) {        
        debugger;
            for(var iIF = 0; iIF < nbIF; iIF++) {    
                if(inputFields[iIF].checked){
                    for(var iIFf = 0; iIFf < nbIFf; iIFf++)
                    {
                        if(!inputFields[iIFf].checked)
                        inputFields[iIFf].disabled = true;
                    }                  
                }   
                }
     }else{
        debugger;
        for(var iIF = 0; iIF < nbIFf; iIF++)
        {
            inputFields[iIF].disabled = false;
        }       
            
          
    }
         
    
        
           
    });
      
       });

