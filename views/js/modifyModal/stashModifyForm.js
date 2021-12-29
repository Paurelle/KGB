

$(document).ready(function(){
    $("select.stash").change(function(){
       select = $(this).children("option:selected").val();

       if (select == "default") {
         document.querySelector('.stashModify').style.display = "none";
      } else {
         document.querySelector('.stashModify').style.display = "block";
      }

      $.ajax({
         type:"POST", 	        
         url:"models/Stash.php",  
         dataType: "json",
         data:"valeur="+select+"&type="+"ajaxRequest",
         success:function(data){
            stashModify(data.code, data.adress, data.type, data.country);
         }
      })
    });
  });
 
  function stashModify(code, adress, type, country) {
    
    document.getElementsByName('modifyCodeStash')[0].placeholder=code;
    document.getElementsByName('modifyCodeStash')[0].value = code;

    document.getElementsByName('modifyAdressStash')[0].placeholder=adress;
    document.getElementsByName('modifyAdressStash')[0].value = adress;

    document.getElementsByName('modifyTypeStash')[0].placeholder=type;
    document.getElementsByName('modifyTypeStash')[0].value = type;

   document.getElementById("modifyCountryStash_"+country).selected= "true";

 }
 