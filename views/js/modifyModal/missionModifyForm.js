
  

$(document).ready(function(){
   $('#mStashSelecte option[value="56487"]').prop('selected', true);
    $("select.mission").change(function(){
       select = $(this).children("option:selected").val();

       if (select == "default") {
         document.querySelector('.missionModify').style.display = "none";
      } else {
         document.querySelector('.missionModify').style.display = "block";
         
      }
      
      $.ajax({
         type:"POST", 	        
         url:"models/Mission.php",  
         dataType: "json",
         data:"valeur="+select+"&type="+"ajaxRequest",
         success:function(data){
             missionModify(data.title, data.description, data.codeName, data.startDate, data.endDate, data.country, data.speciality, data.typeMission, data.statut, data.stash);
         }
      })
    });
  });
 
function missionModify(title, description, codeName, startDate, endDate, country, speciality, typeMission, statut, stash) {
   
    document.getElementsByName('modifyTitleMission')[0].placeholder=title;
    document.getElementsByName('modifyTitleMission')[0].value = title;

    document.getElementsByName('modifyDescriptionMission')[0].placeholder=description;
    document.getElementsByName('modifyDescriptionMission')[0].value = description;

    document.getElementsByName('modifyCodeNameMission')[0].placeholder=codeName;
    document.getElementsByName('modifyCodeNameMission')[0].value = codeName;

    document.getElementsByName('modifyStartDateMission')[0].placeholder=startDate;
    document.getElementsByName('modifyStartDateMission')[0].value = startDate;
    
    document.getElementsByName('modifyEndDateMission')[0].placeholder=endDate;
    document.getElementsByName('modifyEndDateMission')[0].value = endDate;

   document.getElementById("modifyCountryMission_"+country).selected= true;
   document.getElementById("modifySpecialityMission_"+speciality).selected= true;
   document.getElementById("modifyTypeMissionMission_"+typeMission).selected= true;
   document.getElementById("modifyStatusMission_"+statut).selected= true;

   for (let index = 0; index < stash.length; index++) {
      document.getElementById("modifyMissionStash_"+stash[index]).checked = true;
   }
 }