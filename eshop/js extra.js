<script>

$(document).ready(function(){ $("#surnamn").focusout(function(){
  $.getJSON("kunder.json", function(result){ console.log(result); $.each(result, function(key, value){ console.log("Nyckel : " + key + " har värdet " + value); if ($("#surnamn").val() == value['firstName'])
  { $("#lastnamn").val(value.lastName); } }); }); }); });
  
  $("button").click(function()
  {
  $.getJSON('<?php echo get_bloginfo('template_directory'); ?>/eshop/kategorier.json', function(data)
  { loop(data); }); }); function loop(obj)
  { $.each(obj, function(key, val) { if(val && typeof val === "object") { loop(val); } if(key == "Kategorinamn") { $("#div1").append("<h1>Kategorinamn : " + val + "</h1>"); $("#div1").append("<p>En elev : " + obj.kategorier[0].kategorinamn + "</p>"); } }); }
  
  
  
  $(document).ready(function(){ 
   $("#category").keyup(function(){ 
   var searchField = $('#category').val();
   var regex = new RegExp('^' + searchField, "i");
   var output = '<div>'; 
   $.getJSON('<?php echo get_bloginfo('template_directory'); ?>/eshop/kategorier.json', function(data){ 
   $.each(data, function(key, val) 
   { 
    
   if (val.firstName.search(regex) != -1) 
   { 
    console.log(val.firstName); 
   output += '<div>' + val.firstName + '</div>'; 
   } 
    output += '</div>'; 
   $('#result').html(output); 
   });
   });
  }); 
  });
  




  /*
function loadJSON()
{
var xmlhttp = new XMLHttpRequest();
var url = "< ?php echo get_bloginfo('template_directory'); ?>/eshop/kategorier.json";
xmlhttp.onreadystatechange = function() {
if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
var obj = JSON.parse(xmlhttp.responseText);
document.getElementById("div").innerHTML = obj.kategorier[3].Kategorinamn;
}
}
xmlhttp.open("GET", url, true);
xmlhttp.send();
}
*/







    <div id="div"></div>
<button type="button" id="button" onclick="loadJSON()">Update Details </button>