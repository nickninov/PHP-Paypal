// Click the arrow to scroll down
$('#downArrow').click(function() {
  event.preventDefault();
  $('#datesSection').animate({
    scrollTop: "+=100px"
  }, 250);
});

// Click the arrow to scroll up
$('#upArrow').click(function() {
    event.preventDefault();
    $('#datesSection').animate({
      scrollTop: "-=100px"
    }, 250);
  });


