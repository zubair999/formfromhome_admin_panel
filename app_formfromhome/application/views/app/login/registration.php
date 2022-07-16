<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="cleartype" content="on">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<title>Form From Home App Registration</title>
	<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
	<style type="text/css">
		* {
		  margin: 0;
		  padding: 0;
		  box-sizing: border-box;
		}

		body {
		  margin: 0;
		  padding: 0;
		  overflow-x: hidden;
		  font-family: 'Montserrat', sans-serif;
		}

		:root{
			--primaryBlueColor:#2196f3;
			--input-placeholder-clr:#000;
		}

		.ln_1i{
			display: flex;
			justify-content: center;
			align-items: center;
			height: 70vh;
			width: 80%;
			margin:auto;
		}
		h1 {
	text-align: center;
	margin-bottom: 10px;
	color: var(--primaryBlueColor);
	line-height: 0.8;
	font-size: 21px;
	position: relative;
	top: -25px;
}
	input[type="email"], input[type="password"] {
	border: 0;
	border-bottom: 1px solid var(--primaryBlueColor);
	width: 100%;
	padding: 5px;
	font-family: 'Montserrat', sans-serif;
	/*margin-bottom: 11px;*/
	background: linear-gradient(to right, #FFF, #EEF4FF);
}
		input[type="submit"] {
	text-decoration: none;
	color: #fff;
	background: #56CCF2;
	background: -webkit-linear-gradient(to right, #2F80ED, #56CCF2);
	background: linear-gradient(to right, #2F80ED, #56CCF2);
	text-align: center;
	letter-spacing: .5px;
	-webkit-transition: background-color .2s ease-out;
	transition: background-color .2s ease-out;
	cursor: pointer;
	border: none;
	border-radius: 2px;
	display: inline-block;
	height: 30px;
	line-height: 30px;
	padding: 0 16px;
	text-transform: uppercase;
	width: 100%;
	margin-top: 10px;
	border-radius: 10px;
	font-weight: 700;
}
		div:first-child div:first-child{
			width: inherit;
			margin:auto;
		}
		div:first-child div:nth-child(2),div:nth-child(3){
			margin-bottom: 10px;
			width: 100%;
		}
		.ln_li ~ div {
			background: red;
	padding: 50px 20px;
	box-shadow: 0 0 10px 0px rgb(218, 218, 234);
	border-radius: 20px;
	position: relative;
	top: 30px;
		}

		::placeholder {
		  /* Chrome, Firefox, Opera, Safari 10.1+ */
		  color: var(--input-placeholder-clr);
		  opacity: 1;
		  font-size: 15px;
		  letter-spacing: 1.2px;
		  font-weight: 500;
		  font-family: 'Montserrat', sans-serif;
		  /* Firefox */
		}
		input{
			font-size: 15px;
		  letter-spacing: 1.2px;
		  font-weight: 500;
		  font-family: 'Montserrat', sans-serif;
		}
		.holder {
		  position: absolute;
		  width: 100%;
		  height: 100%;
		  left: 50%;
		  top: 50%;
		  transform: translate(-50%, -50%);
		  background: linear-gradient(to right, #FFF, #EEF4FF);
		  z-index: 1;
		}
		.loader {
		  position: absolute;
		  width: 50px !important;
		  height: 50px;
		  left: 50%;
		  top: 50%;
		  transform: translateX(-50%) translateY(-50%);
		  perspective: 120px;
		  transform-style: preserve-3d;
		}
		.loader::before {
	content: "";
	position: absolute;
	left: 50%;
	top: 50%;
	width: 100%;
	height: 100%;
	background-color: #333;
	border-radius: 10%;
	transform: translateX(-50%) translateY(-50%);
	animation: loader 2s infinite;
	background: url('https://formfromhome.com/resources/app/images/loader/1.png');
	background-size: 50px 50px;
}
		@keyframes loader {
		  0% {
		    transform: translateX(-50%) translateY(-50%) rotate(0);
		  }
		  50% {
		    transform: translateX(-50%) translateY(-50%) rotateY(180deg);
		  }
		  100% {
		    transform: translateX(-50%) translateY(-50%) rotateY(180deg)  rotateX(180deg);
		  }
		}
		.n1_j {
	height: 100px;
	background: #56CCF2;
	background: -webkit-linear-gradient(to right, #2F80ED, #56CCF2);
	background: linear-gradient(to right, #2F80ED, #56CCF2);

	border-bottom-left-radius: 20px;
	border-bottom-right-radius: 20px;
	padding:10px;
}
h2 {
	color: #fff;
	text-align: center;
	line-height: .9;
	font-weight: 700;
}
.ln_1i {
	position: relative;
	top: -16px;
	background: #fff;
	border-radius: 20px;
	width: 90% !important;
	padding: 15px;
	box-shadow: 0 0 3px 2px rgba(219, 219, 219, 0.5);
	background: #E0EAFC;
	background: -webkit-linear-gradient(to right, #CFDEF3, #E0EAFC);
	background: linear-gradient(to right, #FFF, #EEF4FF);
}
.kl_w2 {
	font-size: 10px;
	padding: 0 10px;
}

.warningMsg {
    border-radius: 5px;
    width: auto;
    height: auto;
    text-align: center;
    background: rgba(0, 0, 0, 0.8);
    color: #fff;
    position: absolute;
    top: 54px;
    right: 43px;
    z-index: 10;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 16px;
    opacity: 0;
    animation: hideNotification;
    animation-duration: 6s;
    padding: 13px;
}

@keyframes hideNotification {

    from,
    30%,
    75%,
    90%,
    to {
        -webkit-animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
        animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
    }

    0% {
        opacity: 0;
        -webkit-transform: translate3d(-200px, 0, 0);
        transform: translate3d(-200px, 0, 0);
    }

    15% {
        opacity: 1;
        -webkit-transform: translate3d(15px, 0, 0);
        transform: translate3d(15px, 0, 0);
    }

    20% {
        opacity: 1;
        -webkit-transform: translate3d(0px, 0, 0);
        transform: translate3d(0px, 0, 0);
    }

    75% {
        -webkit-transform: translate3d(0px, 0, 0);
        transform: translate3d(0px, 0, 0);
        opacity: 1;
    }

    90% {
        -webkit-transform: translate3d(0px, 0, 0);
        transform: translate3d(0px, 0, 0);
        opacity: 1;
    }

    to {
        -webkit-transform: translate3d(0, 0, 0);
        transform: translate3d(0, 0, 0);
    }
}

.btn{
	text-decoration: none;
	text-decoration: none;
	color: #fff;
	background: #56CCF2;
	background: -webkit-linear-gradient(to right, #2F80ED, #56CCF2);
	background: linear-gradient(to right, #2F80ED, #56CCF2);
	text-align: center;
	letter-spacing: .5px;
	-webkit-transition: background-color .2s ease-out;
	transition: background-color .2s ease-out;
	cursor: pointer;
	border: none;
	border-radius: 2px;
	display: inline-block;
	height: 30px;
	line-height: 30px;
	padding: 0 16px;
	text-transform: uppercase;
	width: 100%;
	margin-top: 10px;
	border-radius: 10px;
	font-weight: 700;
}

	</style>
</head>
<body>
	<div class="holder" id="holder">
  	<div class="loader"></div>
	</div>
	<div class="n1_j">
		<h2>Form</h2> <h2>From</h2><h2>Home</h2>
	</div>
	<div class="ln_1i">
		<div>
			<div><h1><?= $page_title; ?></h1></div>
			<?php echo form_open('register', array('method'=>'post')); ?>
			<div>
				<input type="email" name="loginid" placeholder="Email">
				<span class="txt-danger kl_w2"><?= form_error('loginid') ?></span>
			</div>
			<div>
				<input type="password" name="pass" placeholder="Password">
				<span class="txt-danger kl_w2"><?= form_error('pass') ?></span>
			</div>
			<div>
				<input type="submit" name="submit1" value="Register">
			</div>
			<div style="text-align: center;">or</div>
			<div>
				<a href="<?php echo base_url('app-login'); ?>" class="btn">Login</a>
			</div>
			<?php echo form_close(); ?>
		</div>

	</div>

	<?php
	  if($this->session->flashdata('notification')){
     	?>
	      <div class="warningMsg">
	        <p><?php echo ucwords($this->session->flashdata('notification')); ?></p>
	      </div>
     	<?php
	  }
	?>

	<script type="text/javascript">
		window.addEventListener('load', function() {
			setTimeout(function(){
				console.log("helloo");
				document.getElementById("holder").style.display = "none";
			}, 700);
		});
	</script>
</body>
</html>
