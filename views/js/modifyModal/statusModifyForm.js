
$(document).ready(function(){
    $("select.status").change(function(){
       select = $(this).children("option:selected").val();

      $.ajax({
         type:"POST", 	        
         url:"models/Status.php", 
         dataType: "json",
         data:"valeur="+select+"&type="+"ajaxRequest",
         success:function(data){
            statusModify(data.status);
         }
      })
    });
  });
 
  function statusModify(status) {
    document.getElementsByName('statusModify')[0].placeholder=status;
    document.getElementsByName('statusModify')[0].value = status;
    if (select == "default") {
       document.querySelector('.statusModify').style.display = "none";
    } else {
       document.querySelector('.statusModify').style.display = "block";
    }
 }
 