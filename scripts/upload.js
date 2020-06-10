
let uploadButton = document.getElementById("upload");

function enable(){
	uploadButton.disabled = false;
	uploadButton.style.opacity = "1"; 
}

Webcam.set({
	height: 400,
	width: 600,
	image_format: "jpeg",
	jpeg_quality: 90
});

Webcam.attach("#cameraShot");

function takePhoto(){
		Webcam.snap( function(data_uri) {
                // display results in page
                Webcam.upload( data_uri, '../System/uploadShot.php', function(code, text) {
                    document.getElementById('showImage').innerHTML = '<img id="capturedPic" src="'+data_uri+'"/>';
                } );    
            } );

		enable();
}
