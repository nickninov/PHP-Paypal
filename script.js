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


// Close function
function close() {
  // About 
  aboutModal.style.visibility = 'hidden';
  aboutModal.classList.remove("enterAnimation");
  document.getElementById('aboutMeTextWrapper').style.display = 'none';
  document.getElementById('closeAbout').style.display = 'none';
}

// Click to close
aboutCloseButton.addEventListener('click', close);


