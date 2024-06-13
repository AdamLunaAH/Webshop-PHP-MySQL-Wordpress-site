<?php 
/* Template Name: example page */
	require "eshopfunctions.php";

  // creates the product list
  if (!isset($_SESSION['admin']) ) {
		header("location: wordpress/ebutik/administration_login/");
		exit();} 










?>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>


<script>

$(function() {
  $('#search-input').autocomplete({
    source: function(request, response) {
      $.ajax({
        url: '<?php echo get_bloginfo('template_directory'); ?>/eshop/admin_product_search.php',
        dataType: 'json',
        data: {
          term: request.term
        },
        success: function(data) {
          response($.map(data, function(item) {
            return {
              label: item.Produktnamn,
              value: item.Produktnamn
            }
          }));
        }
      });
    },
    minLength: 2
  });
});




/*
$('jsonSearch').focus();
    $('jsonSearch').autocomplete({
      source: function(request, response) {
        $.getJSON("< ?php echo get_bloginfo('template_directory'); ?>/eshop/produkter.json", {query:request.term},response);
      },
        minLenght: 1,
        select: function(event, ui) {

        },
    })
*/





/*
$( function() {
	$.getJSON("< ?php echo get_bloginfo('template_directory'); ?>/eshop/produkter.json", function(data) {
		autoComplete = [];
		for (var i = 0, len = data.length; i < len; i++) {
			autoComplete.push(data[i].name + ", " + data[i].iata);
		}
		$( "#tags" ).autocomplete({
			source: autoComplete
		});
	});
});*/



</script>

<?php get_header();?>
<main id="main">
  
  <div class="col-1 col-s-1"></div>
<div class="row"><div class="col-10 col-s-10">



  
  <!-- product list -->
  <h2>Updatera sida med text från JSON</h2>
  <div class="ui-widget">
	<label for="tags">Tags: </label>
	<input id="tags">
</div>

<div>
  <label>Sök produktnummer och produktnamn:</label>
  <input id="jsonSearch">
</div><br><br>
<input type="text" id="search-input">
<br><br><br>
<a href="<?php echo get_bloginfo('template_directory'); ?>/eshop/produkter.json">Link</a>

</div></div></main>
<?php get_footer();?>