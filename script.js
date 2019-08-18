// Generate a random number within a given range
function randomNumber(min, max) {  
  return Math.floor(Math.random() * (max - min) + min); 
} 

var songs = ['Аре на бас', ' G.O.A.T.', 'Излизам за по ено', 'Ше дойде ли с мен', 'Ни стаа', 'Много думи', 'Хайде да спрем', 'Хиляди белези', 'Пълен напред', 'Земай', 'Малко е грозно', 'Хора, хора', 'Знам ко прая', 'Плъх', 'И тва е']

document.getElementById('song').innerHTML = songs[randomNumber(0, songs.length - 1)];

// Shows the menu page when everything has loaded
let stateCheck = setInterval(() => {
  if (document.readyState === 'complete') {
    clearInterval(stateCheck);

    // Remove loading div
    document.getElementById('loadingWrapper').style.display = 'none';

    // Display the Logo and menu
    document.getElementById('logo').style.display = 'block';
    document.getElementById('menuID').style.display = 'block';
  }
}, 100);

// Hide body 
function bodyDisguise () {
  document.body.style.backgroundImage = 'none';
  document.body.style.backgroundColor = 'black';
}

function showBody () {
  document.body.style.backgroundColor = 'none';

  if(screen.width <= 700) {
    document.body.style.backgroundImage = 'url(\'images/index/aIMG_2182_mobile.jpg\')';
  }

  if (window.matchMedia("(orientation: landscape)").matches) {
    document.body.style.backgroundImage = 'url(\'images/index/aIMG_2182_landscape.jpg\')';
 }
}

// About
var aboutButton = document.getElementById('about');

var aboutModal = document.getElementById('aboutWrapper');

function openAboutWindow() {
  // bodyDisguise();

  aboutModal.style.visibility = 'visible';
  aboutModal.classList.add("enterAnimation");
  document.getElementById('aboutMeTextWrapper').style.display = 'block';
  document.getElementById('closeAbout').style.display = 'block';
}

aboutButton.addEventListener('click', openAboutWindow);

var aboutCloseButton = document.getElementById('closeAbout');

// Music
var musicButton = document.getElementById('music');

var musicModal = document.getElementById('musicWrapper');

function openMusicWindow() {
  musicModal.style.visibility = 'visible';
  musicModal.classList.add("enterMusicAnimation");
  document.getElementById('blackBackgroundWrapper').style.display = 'block';
}

musicButton.addEventListener("click", openMusicWindow);

var musicCloseButton = document.getElementById('closeMusic');

// Video
var videoButton = document.getElementById('video');

var videoModal = document.getElementById('videoWrapper');

function openVideoWindow() {
  videoModal.style.visibility = 'visible';
  videoModal.classList.add("enterVideoAnimation");
  document.getElementById('blackVideoWrapper').style.display = 'block';

}

videoButton.addEventListener("click", openVideoWindow);

var videoCloseButton = document.getElementById('closeVideo');

// Close function
function close() {
  // showBody();

  // About  - hide modal and remove animation
  aboutModal.style.visibility = 'hidden';
  aboutModal.classList.remove("enterAnimation");

  // Music - hide modal and remove animation
  musicModal.style.visibility = 'hidden';
  musicModal.classList.remove("enterMusicAnimation");
  document.getElementById('blackBackgroundWrapper').style.display = 'none';

  // Video - hide modal and remove animation 
  videoModal.style.visibility = 'hidden';
  videoModal.classList.remove("enterVideoAnimation");
  document.getElementById('blackVideoWrapper').style.display = 'none';
}

// Click to close
aboutCloseButton.addEventListener('click', close);
musicCloseButton.addEventListener('click', close);
videoCloseButton.addEventListener('click', close);

