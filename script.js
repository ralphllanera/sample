const startingMinutes = 5;
let time= startingMinutes * 60;

const countdownEl= document.getElementById('countdown');
setInterval(updateCountdown, 1000);


function updateCountdown(){
	const minutes = Math.floor(time/60);
	let seconds =  time % 60;

	seconds = seconds <10 ? '0' + seconds  : seconds;

	countdownEl.innerHTML = `${minutes}: ${seconds}`;
	time--;
	//time = time < 0 ? 0 : time;
	
	if (time === -1) {
		time = time < 0 ? 0 : time;
		alert("try again");
		window.location.href="login.php"

	}
	else{
		time = time < 0 ? 0 : time;
	}

}