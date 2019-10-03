
  var dropdown = document.getElementsByClassName("dropdown-btn");
  var sidebar = document.getElementsByClassName("dropdown-container");
var i,hr;
var pu= window.location.pathname.split("/");
var pur = window.location.pathname.split("/").length;

purl=pu[pur-1];
for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
    this.classList.add("active");
    var dropdownContent = this.nextElementSibling;

    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
}
  
$(document).ready(function(){
    if($('div.sidenav  a').filter(function() {
       r =this.href.split("/");
       rl=this.href.split("/").length;
       hr = r[rl-1];
        //console.log(this.href.split("localhost:8000")[1]);
        
         return  hr == purl;
        
    }).length>0){
       $('div.sidenav  a').each(function(i){
        r =this.href.split("/");
        rl=this.href.split("/").length;
        hr = r[rl-1];
      
           if (hr == purl){
               this.classList.toggle("active");
               let item = this;
               $('div.dropdown-container a').each(function(i){
                   if(this==item){
                    sidebar[0].style.display="block";
                   }
               });
           }
       });
    }
   
    });