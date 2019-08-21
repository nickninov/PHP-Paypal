// Click the arrow to scroll down - About Modal
$('#downArrowAbout').click(function() {
  event.preventDefault();
  $('#aboutText').animate({
    scrollTop: "+=100px"
  }, 250);
});


// Click the arrow to scroll up - About Modal
$('#upArrowAbout').click(function() {
    event.preventDefault();
    $('#aboutText').animate({
      scrollTop: "-=100px"
    }, 250);
  });

// Click the arrow to scroll down - Dates Modal
$('#downArrow').click(function() {
  event.preventDefault();
  $('#datesSection').animate({
    scrollTop: "+=100px"
  }, 250);
});

// Click the arrow to scroll up - Dates Modal
$('#upArrow').click(function() {
    event.preventDefault();
    $('#datesSection').animate({
      scrollTop: "-=100px"
    }, 250);
  });


