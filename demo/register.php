<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>TestCaseA</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5/css/all.min.css">
<script src="../live2d.min.js"></script>
<style>
html, body {
	height: 100%;
}
body {
	display: flex;
	align-items: center;
	justify-content: center;
	padding-top: 40px;
	padding-bottom: 40px;
	background-color: #f5f5f5;
}
.form-signin {
	width: 100%;
	max-width: 330px;
	padding: 15px;
	margin: 0 auto;
}
.form-signin .checkbox {
	font-weight: 400;
}
.form-signin .form-control {
	position: relative;
	box-sizing: border-box;
	height: auto;
	padding: 10px;
	font-size: 16px;
}
.form-signin .form-control:focus {
	z-index: 2;
}
.form-signin input[type=text] {
	margin-bottom: -1px;
	border-bottom-right-radius: 0;
	border-bottom-left-radius: 0;
}
.form-signin input[type=password] {
	margin-bottom: 10px;
	border-top-left-radius: 0;
	border-top-right-radius: 0;
}
#stage {
	position: relative;
}
#stage img {
	width: 100%;
	margin-bottom: 20px;
	border-radius: 20px;
}
#stage button {
	position: absolute;
	width: 2em;
	height: 2em;
	border-radius: 50%;
}
#inner {
	position: relative;
	background-color: #999;
	clip-path: circle(120px at center);
}
#cover {
	position: absolute;
	background-color: #CB3837;
	width: 100%;
	height: 100%;
	bottom: 10%;
	transition: all 1s;
	box-shadow: 0 0 0 5px rgba(0, 0, 0, .1);
}
#text {
	position: absolute;
	bottom: 30%;
	font-size: 2em;
	left: 50%;
	transform: translateX(-50%);
	opacity: 0.4;
	font-weight: bold;
}
#detail {
	position: absolute;
	background: rgba(255, 255, 255, .1);
	width: 100%;
	height: 10px;
	bottom: 0;
}
#handle {
	position: absolute;
	background: #ccc;
	bottom: -2px;
	box-shadow: 0 1px 0 1px rgba(0, 0, 0, .1);
	height: 8px;
	left: 50%;
	margin-left: -15px;
	width: 30px;
	cursor: pointer;
}
#info {
	left: 40px;
	bottom: 20px;
}
#refresh {
	right: 40px;
	bottom: 20px;
}
#live2d {
	cursor: grab;
	height: 300px;
	width: 300px;
}
#live2d:active {
	cursor: grabbing;
}
</style>
</head>
<body class="text-center">
<form class="form-signin" action="register.php" method="post">
	<div id="stage">
		<div id="inner">
			<div id="cover">
				<div id="text">
					<span style="color: cyan;">MIMI</span><span style="color: white;">POWERED</span>
				</div>
				<div id="detail"></div>
				<div id="handle"></div>
			</div>
			<canvas class="mb-4" id="live2d" width="800" height="800"></canvas>
		</div>
		<button class="btn btn-link" id="info"><i class="fa fa-lg fa-info"></i></button>
		<button class="btn btn-link" id="refresh"><i class="fa fa-lg fa-sync-alt"></i></button>
	</div>
	<h1 class="h3 mb-3 fw-normal">Đăng Ký</h1>
	<label for="room" class="sr-only">Đăng Ký</label>
	<input type="text" name="username" id="username" value="" class="form-control" placeholder="Username" required autofocus>
	<label for="pass" class="sr-only">Đăng Ký</label>
	<input type="password" name="password" id="password" value="" class="form-control" placeholder="Password" required>
    <label for="email" class="sr-only">Email</label>
    <input type="email" name="email" id="email" value="" class="form-control" placeholder="Email" required autofocus>
	<div class="d-grid">
		<button class="btn btn-lg btn-primary" type="submit" name="dangky">Đăng Ký</button>
	</div>
	<?php require 'action.php';?>
	<p class="mt-5 mb-3 text-muted">Copyleft &copy; Mimi 2023</p>
</form>
<script>

window.addEventListener("load", () => {
	"use strict";
/*Check clip-path*/
	if (!CSS.supports("clip-path", "circle(120px at center)")) {
		document.getElementById("stage").innerHTML = '<img src="../assets/screenshot-1.png">';
		return;
	}

	const apiPath = "https://live2d.fghrsh.net/api";
	let state = 0, loading = false,
		modelId = localStorage.getItem("modelId"),
		modelTexturesId = localStorage.getItem("modelTexturesId");
	if (modelId === null) {
		modelId = 1;
		modelTexturesId = 53;
	}
	loadModel(modelId, modelTexturesId);

	function loadModel(modelId, modelTexturesId) {
		localStorage.setItem("modelId", modelId);
		if (modelTexturesId === undefined) modelTexturesId = 0;
		localStorage.setItem("modelTexturesId", modelTexturesId);
		loadlive2d("live2d", `${apiPath}/get/?id=${modelId}-${modelTexturesId}`, null);
		console.log("live2d", `Mẫu${modelId}-${modelTexturesId} Tải về hoàn tất`);
		setTimeout(() => {
			coverPosition("80%");
			state = 2;
		}, 2000);
	}

	function loadRandModel() {
		const modelId = localStorage.getItem("modelId"),
			modelTexturesId = localStorage.getItem("modelTexturesId");
		fetch(`${apiPath}/rand_textures/?id=${modelId}-${modelTexturesId}`)
			.then(response => response.json())
			.then(result => {
				loadModel(modelId, result.textures.id);
				setTimeout(() => {
					state = 2;
					coverPosition("80%");
					loading = false;
				}, 1000);
			});
	}

	function loadOtherModel() {
		const modelId = localStorage.getItem("modelId");
		fetch(`${apiPath}/switch/?id=${modelId}`)
			.then(response => response.json())
			.then(result => {
				loadModel(result.model.id);
			});
	}

	function coverPosition(pos) {
		document.getElementById("cover").style.bottom = pos;
	}

	document.getElementById("info").addEventListener("click", () => {
		fetch("")
			.then(response => response.json())
			.then(result => {
				alert("「" + result.hitokoto + "」——" + result.from);
			});
	});

	document.getElementById("refresh").addEventListener("click", () => {
		if (loading) return;
		state = 0;
		coverPosition("10%");
		loading = true;
		setTimeout(loadRandModel, 1000);
	});

	document.getElementById("handle").addEventListener("click", () => {
		if (state === 1) {
			state = 2;
			coverPosition("80%");
		}
		else if (state === 2) {
			state = 1;
			coverPosition("20%");
		}
	});

	document.querySelector("input[type=password]").addEventListener("focus", () => {
		if (state === 2) {
			state = 1;
			coverPosition("20%");
		}
	});
	document.querySelector("input[type=password]").addEventListener("blur", () => {
		if (state === 1) {
			state = 2;
			coverPosition("80%");
		}
	});
});
</script>
</body>
</html>
