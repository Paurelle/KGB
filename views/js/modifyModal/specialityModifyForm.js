
$(document).ready(function(){
   $("select.speciality").change(function(){
      select = $(this).children("option:selected").val();

      if (select == "default") {
         document.querySelector('.specialityModify').style.display = "none";
      } else {
         document.querySelector('.specialityModify').style.display = "block";
      }

     $.ajax({
        type:"POST", 	        
        url:"models/Speciality.php",  
        dataType: "json",
        data:"valeur="+select+"&type="+"ajaxRequest",
        success:function(data){
         specialityModify(data.speciality);
        }
     })
   });
 });

 function specialityModify(speciality) {
   document.getElementsByName('specialityModify')[0].placeholder=speciality;
   document.getElementsByName('specialityModify')[0].value = speciality;
   
}
