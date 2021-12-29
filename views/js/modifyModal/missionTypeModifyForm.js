
$(document).ready(function(){
    $("select.missionType").change(function(){
       select = $(this).children("option:selected").val();

      $.ajax({
         type:"POST", 	        
         url:"models/MissionType.php",  
         dataType: "json",
         data:"valeur="+select+"&type="+"ajaxRequest",
         success:function(data){
            missionTypeModify(data.missionType);
         }
      })
    });
  });
 
  function missionTypeModify(country, nationality) {
    document.getElementsByName('missionTypeModify')[0].placeholder=country;
    document.getElementsByName('missionTypeModify')[0].value = country;

    if (select == "default") {
       document.querySelector('.missionTypeModify').style.display = "none";
    } else {
       document.querySelector('.missionTypeModify').style.display = "block";
    }
 }
 