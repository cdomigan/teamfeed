<html>
	<head>
		<style>
			body {
				font-family: arial;
			}
		</style>
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="apple-mobile-web-app-capable" content="yes">
	</head>
	<body>
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script>
            var canvas = document.getElementById('canvas');
            var photo = document.getElementById('photo');
            var preview = document.getElementById('preview');
            var startbutton = document.getElementById('captureButton');
            var urlParams = new URLSearchParams(window.location.search);
            var user = urlParams.get('user');
            var view = urlParams.get('view');
            var facetime = {
                office: 'cdomigan+ipad@gmail.com',
				cdomigan: 'cdomigan@gmail.com'
			};

            function loop(time) {
                console.log('Loop');
                takepicture();
                setTimeout(loop, time, time);
            }

            function startup() {
                console.log('startup');
                canvas = document.getElementById('canvas');
                photo = document.getElementById('photo');
                loop(5000);
//                startbutton = document.getElementById('captureButton');						startbutton.addEventListener('click', function(ev){
//                    takepicture();
//                    ev.preventDefault();
//                }, false);
            }

            navigator.getUserMedia  = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;

            var video = document.createElement('video');
            video.style.width =  '640px';
            video.style.height = '480px';
            video.setAttribute('autoplay', '');
            video.setAttribute('muted', '');
            video.setAttribute('playsinline', '');

            var facingMode = "user";

            var constraints = {
                audio: false,
                video: {
                    facingMode: facingMode
                }
            }

            navigator.mediaDevices.getUserMedia(constraints).then(function success(stream) {
                video.srcObject = stream;
            });

            document.body.appendChild(video);

            //			video.addEventListener('click', function() {
            //				if (facingMode == "user") {
            //					facingMode = "environment";
            //				} else {
            //					facingMode = "user";
            //				}
            //
            //				constraints = {
            //					audio: false,
            //					video: {
            //						facingMode: facingMode
            //					}
            //				}
            //
            //				navigator.mediaDevices.getUserMedia(constraints).then(function success(stream) {
            //					video.srcObject = stream;
            //				});
            //			});



            function clearphoto() {
                var context = canvas.getContext('2d');
                context.fillStyle = "#AAA";
                context.fillRect(0, 0, canvas.width, canvas.height);

                var data = canvas.toDataURL('image/png');
                photo.setAttribute('src', data);
            }

            function takepicture() {
                var context = canvas.getContext('2d');
                context.drawImage(video, 0, 0, 640, 480);
                var data = canvas.toDataURL('image/png');
                var random = Math.floor(Math.random() * 1000);

                photo.setAttribute('src', 'getImage.php?user='+view+'&bust='+random);
                $.post('upload.php', {image: data, user: user}, function() {
                    console.log('Uploaded');
				});
            }
			$(document).ready(function() {
				startup();
				$("#viewing").html("viewing <b>"+view+"</b>");
                $("#photo").click(function() {
                    window.open('facetime:'+facetime[view], '_self');
                });
            })
		</script>
		<h1>Prima Software TeamFeed</h1>
		<canvas id="canvas" width="640" height="480" style="display:none;"></canvas>
		<div class="output" style="position: absolute; background: black; top: 0; left: 0; width: 100%; height: 100%;">

			<img id="photo" style="width: 100%;" alt="The screen capture will appear in this box." />
		</div>
		<div id="viewing" style="position: absolute; top: 0; left: 0; background: lightblue; padding: 20px; font-size: 22px;" />
	</body>
</html>