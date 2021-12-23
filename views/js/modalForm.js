const modalBtns = [...document.querySelectorAll(".grid-panel-items")];
modalBtns.forEach(function(btn){
    btn.onclick = function() {
        const modal = btn.getAttribute('data-modal');
        document.getElementById(modal).style.display = "block";
        addForm();
    }
});
      
const closeBtns = [...document.querySelectorAll(".close")];
    closeBtns.forEach(function(btn){
    btn.onclick = function() {
        const modal = btn.closest('.modal');
        modal.style.display = "none";
    }
});
      
window.onclick = function(event) {
    if (event.target.className === "modal") {
        event.target.style.display = "none";
    }
}

function addForm() {
    document.querySelector("#form1").style.display = "block";
    document.querySelector("#form2").style.display = "none";
    document.querySelector("#form3").style.display = "none";
}

function modifyForm() {
    document.querySelector("#form1").style.display = "none";
    document.querySelector("#form2").style.display = "block";
    document.querySelector("#form3").style.display = "none";
}

function deleteForm() {
    document.querySelector("#form1").style.display = "none";
    document.querySelector("#form2").style.display = "none";
    document.querySelector("#form3").style.display = "block";
}