function disableBtn() {
    var searchrestaurant = document.getElementById("search");
    //var searchzone = document.getElementById("searchzone");
    var checkboxarray = [];

    $.each($("input[name='filterarray[]']:checked"), function(){
        checkboxarray.push($(this).val());
    });
    
    //alert("My checkboxarray are: " + checkboxarray.join(", "));
    //alert("My checkboxarray are: " + checkboxarray);

    if(checkboxarray == '' )
    {
        searchrestaurant.disabled = false;
        //searchzone.disabled = false;
    }
    else if(checkboxarray != ''){
        searchrestaurant.disabled = true;
        //searchzone.disabled = true;
    }

  }