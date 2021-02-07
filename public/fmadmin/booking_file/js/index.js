function onLoaderFunc()
{
  //$(".seatStructure *").prop("disabled", true);
  //$(".displayerBoxes *").prop("disabled", true);
}
function takeData()
{
  
  if (( $("#Username").val().length == 0 ) || ( $("#Numseats").val().length == 0 ) || ( $("#mobile").val().length == 0 ))
  {
  alert("Please Enter your Name and Mobile Number and No of Seats");
  }
  else
  {
   // $(".inputForm *").prop("disabled", true);
  //  $(".seatStructure *").prop("disabled", false);
	
	
    //document.getElementById("notification").innerHTML = "<b style='margin-bottom:0px;background:yellow;'>Please Select your Seats NOW!</b>";
	document.getElementById("notification").style.display="block";
	document.getElementById("seatsBlock").style.display="table"
	document.getElementById("submitBTN").style.display="block";
	
	//document.getElementsByClassName("empty").disabled = false;
	document.getElementsByClassName("reserved_seat").disabled = true;
	
  }
}

	//INSERT DATA
function addTextArea() { 
    
	if ($(".empty:checked").length == ($("#Numseats").val()))
    {
		
		$("#submitBTN").prop('disabled', true);
	
		$(".empty *").prop("disabled", true);
      
     var allNameVals = [];
     var allNumberVals = [];
     var allSeatsVals = [];
     var allMobileVals = [];
     var allEmailVals = [];
  
     //Storing in Array
     allNameVals.push($("#Username").val());
     allNumberVals.push($("#Numseats").val());
     allMobileVals.push($("#mobile").val());
     $('.empty:checked').each(function() {
       allSeatsVals.push($(this).val());
     });
	
     //Displaying 
     $('#nameDisplay').val(allNameVals);
     $('#NumberDisplay').val(allNumberVals);
     $('#seatsDisplay').val(allSeatsVals);
     $('#mobileDisplay').val(allMobileVals);
	 
	 
	 
		
		var seat_no="";
		var full_name=$("#Username").val();
		var no_of_seat=$("#Numseats").val();
		var mobile_number=$("#mobile").val();
		$('.empty:checked').each(function() {
		   seat_no=seat_no+$(this).val()+",";
		});
		
		$.ajax({
			url:"book_now.php",
			type:'post',
			data:{name:full_name,number:no_of_seat,mobile:mobile_number,seats:seat_no},
			success:function(){
				alert('Seat Booked Successfully !');
				window.location='manage_amit_mishra_event.php';
			}
		});
		
		
    }
  else
    {
      alert("Please select " + ($("#Numseats").val()) + " seats")
    }
  }



function myFunction() {
  alert($("input:checked").length);
}

/*
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
*/


$(":checkbox").click(function() {
  if ($("input:checked").length == ($("#Numseats").val())) {
  
	$(".empty").prop('disabled', true);
    $(':checked').prop('disabled', false);
	
		document.getElementsByClassName("reserved_seat").disabled = true;
  }
  else
    {
   
		 $(".empty").prop('disabled', false);
		document.getElementsByClassName("reserved_seat").disabled = true;
    }
});
