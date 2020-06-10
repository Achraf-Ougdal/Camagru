
function liked(id){

	let label = document.getElementById(id);

	if(label.className == "liked"){
		label.className = "unliked";
	}
	else{
		label.className="liked";
	}

	$("#empty").load("../System/like.php",{
		idImage:id
	});

}


function commented(id){

	let text = document.getElementById("comment"+id).value;

	$("#empty").load("../System/comment.php",{
		idImage:id,
		commentText:text
	});

	document.getElementById("comment"+id).value = "";

}