
var choice = [];

$(document).ready(function(){
   //$('#mStashSelecte option[value="56487"]').prop('selected', true);
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
            choice = missionModify(data.title, data.description, data.codeName, data.startDate, data.endDate, data.country, data.speciality, data.typeMission, data.statut,
               data.stash, data.agent, data.contact, data.target, choice[0], choice[1], choice[2], choice[3]);
         }
      })
    });
  });
 
function missionModify(title, description, codeName, startDate, endDate, country, speciality, typeMission, statut, 
   stash, agent, contact, target, stashChoice, agentChoice, contactChoice, targetChoice) {
   
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
   
   if (stashChoice != null)  {
      for (let index = 0; index < stashChoice.length; index++) {
         document.getElementById("modifyMissionStash_"+stashChoice[index]).checked = false;
      }
   }
   if (agentChoice != null)  {
      for (let index = 0; index < agentChoice.length; index++) {
         document.getElementById("modifyMissionAgent_"+agentChoice[index]).checked = false;
      }
   }
   if (contactChoice != null)  {
      for (let index = 0; index < contactChoice.length; index++) {
         document.getElementById("modifyMissionContact_"+contactChoice[index]).checked = false;
      }
   }
   if (targetChoice != null)  {
      for (let index = 0; index < targetChoice.length; index++) {
         document.getElementById("modifyMissionTarget_"+targetChoice[index]).checked = false;
      }
   }


   for (let index = 0; index < stash.length; index++) {
      document.getElementById("modifyMissionStash_"+stash[index]).checked = true;
   }
   
   for (let index = 0; index < agent.length; index++) {
      document.getElementById("modifyMissionAgent_"+agent[index]).checked = true;
   }

   for (let index = 0; index < contact.length; index++) {
      document.getElementById("modifyMissionContact_"+contact[index]).checked = true;
   }

   for (let index = 0; index < target.length; index++) {
      document.getElementById("modifyMissionTarget_"+target[index]).checked = true;
   }

   let element = [stash, agent, contact, target];
   return element;
 }
