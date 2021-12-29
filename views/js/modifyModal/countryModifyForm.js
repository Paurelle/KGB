
$(document).ready(function(){
    $("select.country").change(function(){
       select = $(this).children("option:selected").val();

      $.ajax({
         type:"POST", 	        
         url:"models/Country.php",  
         dataType: "json",
         data:"valeur="+select+"&type="+"ajaxRequest",
         success:function(data){
            countryModify(data.country, data.nationality);
         }
      })
    });
  });
 
  function countryModify(country, nationality) {
    document.getElementsByName('countryModify')[0].placeholder=country;
    document.getElementsByName('countryModify')[0].value = country;

    document.getElementsByName('nationalityModify')[0].placeholder=nationality;
    document.getElementsByName('nationalityModify')[0].value = nationality;
    if (select == "default") {
       document.querySelector('.countryModify').style.display = "none";
    } else {
       document.querySelector('.countryModify').style.display = "block";
    }
 }
 