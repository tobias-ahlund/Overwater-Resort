![](https://media2.giphy.com/media/3otPoBnTKMSXegX2fK/giphy.gif?cid=ecf05e47xty2pulrdr3hrnu30v0dhyxokursu0olqe2v7pz0&ep=v1_gifs_search&rid=giphy.gif&ct=g)

# About

A project where I made a web page for a fictional hotel. 

# Overwater Resort

Established in the 80's. Located on the island of Isla de los Monos which is as real as its archipelago Yrgopelagio. 

# Instructions

Visit the hotel's web page and make a reservation.

# Code review

1. script.js:59-141 - These click events are very similar in their action. You could use a function instead which accepts the value of the selected room and have it act accordingly. To do this you would have to add a class for the calender contents, nav buttons and containers so that you can fetch all of the calendars to an array. Once you have that you can add an click event for all the nav buttons that sends a number (0,1 or 2 depending on room) and have a function that removes all the active buttons and calendars, then activates the pressed button Eg.
````
//Fetch all the calendars, calendar contents and the navigation buttons in 3 queries
const calendars = document.querySelectorAll('.calendar');
const calendarsContent = document.querySelectorAll('.calendar-content');
const navButtons = document.querySelectorAll('.nav-select');

//Add a const that keeps track of the current active room
const activeCalendars = [false, false, false];

//Then add a function that clears out the classes and activates the new selected room
const toggleCalendar = (calendarIndex) => {
    let index = 0;
    activeCalendars.forEach((calendar) => {
        if (calendar) {
        calendars[index].classList.add('hide');
        calendarsContent[index].classList.add('hide');
        navButtons[index].classList.remove('nav-room-item-selected');
        calendarActive[index] = false;
        }
    index++;
  });
  
  calendars[calendarIndex].classList.remove('hide');
  calendarsContent[calendarIndex].classList.remove('hide');
  navButtons[calendarIndex].classList.remove('hide');
  navButtons[calendarIndex].classList.add('nav-room-item-selected');
  activeCalendars[calendarIndex] = true;
}
````
  Then you add an click event to all navigation buttons that trigger the above function (not tested however hopefully gives an idea on how this could work) by sending a index between 0, 1 and 2 depending on room clicked. There is no 'nav(budget,standard or luxury)Item' as the ````budget````,````standard```` and ````luxury```` elements are already fetched in 'navButtons'. There are surely better ways of doing this, however this is one potential way of doing it.

2. index.php:121 - Action calls "index.php" however the request is sent and begins running in "checkTransferCode.php", making it hard to follow. (having an 'bookingFunctions.php' file would be helpful here).
3. roomCheck.php:65-71 - The discount is always 1 so instead of checking if the "$totalCost" is above a certain amount, check that the "$days" are above 1. And remove all 'else-if's.
4. showBookings(budget, standard, luxury).php - These are php files only containing one function, these could be placed in one php file and have the same effect and be easier to follow and access. It could be named something like "showBookings.php".
5. moneyTransfer.php, receipt.php, roomCheck.php, bookingConfirmed.php - These together execute the checks and booking for the hotel. Having split all these functions makes it harder to follow especially when they connect as much as they do. I would recommend moving the contents to a new file perhaps named "bookingFunctions.php". As bookingConfirmed.php, receipt.php and moneyTransfer.php all only contain 1 function.
6. header.css: 17, 20, 22 - There are three borders followed by 'border: none'
7. footer.css - 'footer' has two background-colors.
8. calendar.css: 6-7 - You could use 'repeat()' here.
Eg
```` grid-template-columns: repeat(6, 1fr);````
9. bookings.css:1-3 - '.hide' could be moved to 'style.css' instead.
10. hero.css: 17-20 - There are 2 'max-width'.
