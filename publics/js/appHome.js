$(document).ready(function() {
  
    $(document.body).on('click', "#commentaire",function() {
        var a = $(this).data("id");
        $(".formComment"+a).toggleClass("showCommentForm");
        $(".formComment"+a).hide("0.5s");
        $(".showCommentForm").show("0.5s");
	});
	// $(document.body).on('click', "#like",function() {
	// 	// e.preventDefault();
	// 	// $(this).toggleClass("liked");
	// 	// $(".like").css("color", "red");
	// 	// $(".liked").css("color", "green");

	// 	// $.ajax({
	// 		// alert(baseURL+"index.php/welcome/like/");
	// 		// type: 'post' ,
	// 		// data: $(this).serialize() ,
	// 	// })
	// 	// .done(function(data) {
	// 	// 	console.log(data);
	// 	// 	location.href = PROJECT_ROOT+"Manager" ;
	// 	// })
	// 	// .fail(function(errorMessage) {
	// 	// 	console.log(errorMessage) ;
	// 	// })
	// });

});