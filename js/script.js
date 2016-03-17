$(document).ready(function() {

	$("#sss").on("input", function() {
	// allow numbers, a comma or a dot
	$(this).val($(this).val().replace(/[^0-9,\.]+/, ''));
});

	//delete confirmation
	$(document).on("click", "#delete", function(event) {
        var x = confirm("Are you sure you want to delete?");
        if (x){
            $(this).prev('button').remove();
        }else{
            event.preventDefault();
            return false;
        }
    });

 	//search condition
   /* $("#searchBtn").bind('click',function(event){
        var n = $("#search").val();
        if(!isNaN(parseFloat(n)) && isFinite(n)) {
        }else{
            event.preventDefault();
            return false;
        }

    });*/


	//count request payroll
	function getCount() {
        $.ajax({
          type: "GET",
          url: "/count"
      })
        .done(function( data ) {
          $('#reqcount').html(data);
          setTimeout(getCount, 10000);
      });}

        getCount();

	//delete employee time record
	$(document).on("click", "#deleteA", function(event) {
        var x = confirm("Are you sure you want to delete?");
        if (x){
            $(this).prev('button').remove();
        }else{
            event.preventDefault();
            return false;
        }
    });


});
