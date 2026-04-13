const sidebar = document.getElementById("sidebar");
const main = document.getElementById("main");
const overlay = document.getElementById("overlay");
const toggleBtn = document.getElementById("menuToggle");

toggleBtn.addEventListener("click", function(){

if(window.innerWidth <= 768){

sidebar.classList.toggle("active");
overlay.classList.toggle("active");

}else{

sidebar.classList.toggle("collapsed");
main.classList.toggle("expanded");

}

});

overlay.addEventListener("click", function(){

sidebar.classList.remove("active");
overlay.classList.remove("active");

});

window.addEventListener("resize", function(){

if(window.innerWidth > 768){

sidebar.classList.remove("active");
overlay.classList.remove("active");

}

});