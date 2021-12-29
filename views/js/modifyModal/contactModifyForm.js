

$(document).ready(function(){
    $("select.contact").change(function(){
       select = $(this).children("option:selected").val();

       if (select == "default") {
         document.querySelector('.contactModify').style.display = "none";
      } else {
         document.querySelector('.contactModify').style.display = "block";
      }
      $.ajax({
         type:"POST", 	        
         url:"models/Contact.php",  
         dataType: "json",
         data:"valeur="+select+"&type="+"ajaxRequest",
         success:function(data){
            contactModify(data.name, data.lastname, data.birthdate, data.country, data.codeName);
         }
      })
    });
  });
 
  function contactModify(name, lastname, birthDate, country, codeName) {
    
    document.getElementsByName('modifyNameContact')[0].placeholder=name;
    document.getElementsByName('modifyNameContact')[0].value = name;

    document.getElementsByName('modifyLastnameContact')[0].placeholder=lastname;
    document.getElementsByName('modifyLastnameContact')[0].value = lastname;

    document.getElementsByName('modifyBirthDateContact')[0].placeholder=birthDate;
    document.getElementsByName('modifyBirthDateContact')[0].value = birthDate;

   document.getElementById("modifyCountryContact_"+country).selected= "true";
   
    document.getElementsByName('modifyCodeContact')[0].placeholder=codeName;
    document.getElementsByName('modifyCodeContact')[0].value = codeName;

 }
 