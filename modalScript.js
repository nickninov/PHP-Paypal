// Generate a random number within a given range
function randomNumber(min, max) {  
  return Math.floor(Math.random() * (max - min) + min); 
} 

// Array with all the songs from the album - Хиляди Белези
var songs = ['Аре на бас', ' G.O.A.T.', 'Излизам за по ено', 'Ше дойде ли с мен', 'Ни стаа', 'Много думи', 'Хайде да спрем', 'Хиляди белези', 'Пълен напред', 'Земай', 'Малко е грозно', 'Хора, хора', 'Знам ко прая', 'Плъх', 'И тва е']

// Display a random song from the array
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

// ---------------------------------------------------------------------------------
// About
var aboutButton = document.getElementById('about');

var aboutModal = document.getElementById('aboutWrapper');

function openAboutWindow() {
  aboutModal.style.visibility = 'visible';
  aboutModal.classList.add("enterAnimation");
  document.getElementById('aboutMeTextWrapper').style.display = 'block';
  document.getElementById('closeAbout').style.display = 'block';
}

aboutButton.addEventListener('click', openAboutWindow);

var aboutCloseButton = document.getElementById('closeAbout');

// ---------------------------------------------------------------------------------
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

// ---------------------------------------------------------------------------------
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

// ---------------------------------------------------------------------------------
// Dates
var datesButton = document.getElementById('dates');

var datesModal = document.getElementById('datesWrapper');

function openDatesButton() {
  datesModal.style.visibility = 'visible';
  datesModal.classList.add("enterDatesAnimation");
}

datesButton.addEventListener("click", openDatesButton);

var datesCloseButton = document.getElementById("closeDates")

// ---------------------------------------------------------------------------------
// Close function
function close() {

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

  // Dates - hide modal and remove animation
  datesModal.style.visibility = 'hidden';
  datesModal.classList.remove("enterDatesAnimation");
}

// ---------------------------------------------------------------------------------
// Youtube API

var videoOne;
var videoTwo;
var videoThree;
var videoFour;
var videoFive;
var videoSix;

// Function is called when the API is ready to be used
function onYouTubePlayerAPIReady() {

  // videoOne
  videoOne = new YT.Player('videoOne', {
    events: {
      'onReady': onPlayerReady
    }
  });

  // videoTwo
  videoTwo = new YT.Player('videoTwo', {
    events: {
      'onReady': onPlayerReady
    }
  });

  // videoThree
  videoThree = new YT.Player('videoThree', {
    events: {
      'onReady': onPlayerReady
    }
  });

  // videoFour
  videoFour = new YT.Player('videoFour', {
    events: {
      'onReady': onPlayerReady
    }
  });

  // videoFive
  videoFive = new YT.Player('videoFive', {
    events: {
      'onReady': onPlayerReady
    }
  });

  // videoSix
  videoSix = new YT.Player('videoSix', {
    events: {
      'onReady': onPlayerReady
    }
  });
}

function onPlayerReady(event) {

  // Stop videos when X button is pressed and close the modal
  videoCloseButton.addEventListener("click", function() {
    videoOne.stopVideo();
    videoTwo.stopVideo();
    videoThree.stopVideo();
    videoFour.stopVideo();
    videoFive.stopVideo();
    videoSix.stopVideo();
    close();
  });
  
}

// Inject YouTube API script
var tag = document.createElement('script');
tag.src = "https://www.youtube.com/player_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

// ---------------------------------------------------------------------------------
// Click to close
aboutCloseButton.addEventListener('click', close);
musicCloseButton.addEventListener('click', close);
// videoCloseButton.addEventListener('click', close);
datesCloseButton.addEventListener('click', close);