let specialityChoice = [];

$(document).ready(function(){
    $("select.agent").change(function(){
       select = $(this).children("option:selected").val();
      $.ajax({
         type:"POST", 	        
         url:"models/Agent.php",  
         dataType: "json",
         data:"valeur="+select+"&type="+"ajaxRequest",
         success:function(data){
            specialityChoice = agentModify(data.name, data.lastname, data.birthdate, data.country, data.speciality, specialityChoice, data.code);
         }
      })
    });
  });
 
  function agentModify(name, lastname, birthDate, country, speciality, specialityChoice, code) {
   
    document.getElementsByName('modifyNameAgent')[0].placeholder=name;
    document.getElementsByName('modifyNameAgent')[0].value = name;

    document.getElementsByName('modifyLastnameAgent')[0].placeholder=lastname;
    document.getElementsByName('modifyLastnameAgent')[0].value = lastname;

    document.getElementsByName('modifyBirthDateAgent')[0].placeholder=birthDate;
    document.getElementsByName('modifyBirthDateAgent')[0].value = birthDate;

   document.getElementById("modifyCountryAgent_"+country).selected= "true";

   for (let index = 0; index < specialityChoice.length; index++) {
      document.getElementById("modifySpecialityAgent_"+specialityChoice[index]).checked = false;
   }

   for (let index = 0; index < speciality.length; index++) {
      document.getElementById("modifySpecialityAgent_"+speciality[index]).checked = true;
   }
   

    document.getElementsByName('modifyCodeAgent')[0].placeholder=code;
    document.getElementsByName('modifyCodeAgent')[0].value = code;

    if (select == "default") {
       document.querySelector('.agentModify').style.display = "none";
    } else {
       document.querySelector('.agentModify').style.display = "block";
       return speciality;
    }

    
 }
 