
$(document).ready(function(){
    $("select.admin").change(function(){
       select = $(this).children("option:selected").val();

      $.ajax({
         type:"POST", 	        
         url:"models/Admin.php",  
         dataType: "json",
         data:"valeur="+select+"&type="+"ajaxRequest",
         success:function(data){
            adminModify(data.name, data.lastname, data.email);
         }
      })
    });
  });
 
  function adminModify(name, lastname, email) {
    document.getElementsByName('nameModify')[0].placeholder=name;
    document.getElementsByName('nameModify')[0].value = name;

    document.getElementsByName('lastnameModify')[0].placeholder=lastname;
    document.getElementsByName('lastnameModify')[0].value = lastname;

    document.getElementsByName('emailModify')[0].placeholder=email;
    document.getElementsByName('emailModify')[0].value = email;

    if (select == "default") {
       document.querySelector('.adminModify').style.display = "none";
    } else {
       document.querySelector('.adminModify').style.display = "block";
    }
 }
 