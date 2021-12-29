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

//fix nombre élement
function addForm() {
    for (let index = 1; index <= 30; index+=3) {
        document.querySelector("#form"+index).style.display = "block";
        document.querySelector("#form"+(index+1)).style.display = "none";
        document.querySelector("#form"+(index+2)).style.display = "none";
    }
}

function modifyForm() {
    for (let index = 1; index <= 30; index+=3) {
        document.querySelector("#form"+index).style.display = "none";
        document.querySelector("#form"+(index+1)).style.display = "block";
        document.querySelector("#form"+(index+2)).style.display = "none";
    }
}

function deleteForm() {
    for (let index = 1; index <= 30; index+=3) {
        document.querySelector("#form"+index).style.display = "none";
        document.querySelector("#form"+(index+1)).style.display = "none";
        document.querySelector("#form"+(index+2)).style.display = "block";
    }
}
