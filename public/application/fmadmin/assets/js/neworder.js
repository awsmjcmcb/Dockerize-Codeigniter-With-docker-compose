
   function getData() {
   setInterval(function(){ 
        $.ajax( {
              type: "GET",                 
               url: "neworder.php",                 
                          success: function(data) {
                          var arr = $.parseJSON(data);  
                             
                 $('#neworder').html(arr); 
                                  
 
               },// success                

        })// ajax
    }, 1000);
    }
    getData();

 