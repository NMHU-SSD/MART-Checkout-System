//https://tempusdominus.github.io/bootstrap-4/Usage
$('#start').datetimepicker({
  timeZone: 'America/Denver',
  daysOfWeekDisabled: [0, 6],
  icons: {
    time: "fas fa-clock",
    date: "fas fa-calendar-alt",
    up: "fas fa-arrow-up",
    down: "fas fa-arrow-down"
  },
  stepping: 5,
  disabledHours: [ 1, 2, 3, 4, 5, 6, 7, 8, 18, 19, 20, 21, 22, 23, 24], //6-8am
  enabledHours: [ 9, 10, 11, 12, 13, 14, 15, 16, 17], //9 - 5pm,
  minDate: moment(),
  minTime: moment(),
  useCurrent: true
});
$('#end').datetimepicker({
  timeZone: 'America/Denver',
  daysOfWeekDisabled: [0, 6],
  icons: {
    time: "fas fa-clock",
    date: "fas fa-calendar-alt",
    up: "fas fa-arrow-up",
    down: "fas fa-arrow-down"
  },
  stepping: 5,
  disabledHours: [ 1, 2, 3, 4, 5, 6, 7, 8, 18, 19, 20, 21, 22, 23, 24], //6pm-8am
  enabledHours: [ 9, 10, 11, 12, 13, 14, 15, 16, 17], //9 - 5
  minDate: moment(),
  minTime: moment(),
  //useCurrent: false //Important! See issue #1075
});
$("#start").on("change.datetimepicker", function (e) {
  $('#end').datetimepicker('minDate',e.date);
});
$("#end").on("change.datetimepicker", function (e) {
  $('#start').datetimepicker('maxDate', e.date);
});
