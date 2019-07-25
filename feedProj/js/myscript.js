var  counter =1;

$(document).ready(function(){
	
  $("#moreid").click(function(){	 
       $("#feedid"+counter).show();
       counter++;
	
       if(!($("#feedid"+counter).length)){
		$("#moreid").hide();
       }
  });
  
});
 
 
