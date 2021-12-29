

$(document).ready(function(){
    $("select.target").change(function(){
       select = $(this).children("option:selected").val();

       
      if (select == "default") {
         document.querySelector('.targetModify').style.display = "none";
      } else {
         document.querySelector('.targetModify').style.display = "block";
      }

      $.ajax({
         type:"POST", 	        
         url:"models/Target.php",  
         dataType: "json",
         data:"valeur="+select+"&type="+"ajaxRequest",
         success:function(data){
            targetModify(data.name, data.lastname, data.birthdate, data.country, data.codeName);
         }
      })
    });
  });
 
  function targetModify(name, lastname, birthDate, country, codeName) {
    
    document.getElementsByName('modifyNameTarget')[0].placeholder=name;
    document.getElementsByName('modifyNameTarget')[0].value = name;

    document.getElementsByName('modifyLastnameTarget')[0].placeholder=lastname;
    document.getElementsByName('modifyLastnameTarget')[0].value = lastname;

    document.getElementsByName('modifyBirthDateTarget')[0].placeholder=birthDate;
    document.getElementsByName('modifyBirthDateTarget')[0].value = birthDate;

   document.getElementById("modifyCountryTarget_"+country).selected= "true";
   
    document.getElementsByName('modifyCodeTarget')[0].placeholder=codeName;
    document.getElementsByName('modifyCodeTarget')[0].value = codeName;


 }
 