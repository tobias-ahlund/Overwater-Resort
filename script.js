const bookingSuccessButton = document.querySelector(".booking-success-button");
const bookingSuccess = document.querySelector(".booking-success"); 
const bookingFailButton = document.querySelector(".booking-fail-button");
const bookingFail = document.querySelector(".booking-fail");
const budgetRoomContent = document.querySelector(".budget-room-content");
const standardRoomContent = document.querySelector(".standard-room-content");
const luxuryRoomContent = document.querySelector(".luxury-room-content");
const budgetRoomCalendarContainer = document.querySelector(".budget-room-calendar-container");
const standardRoomCalendarContainer = document.querySelector(".standard-room-calendar-container");
const luxuryRoomCalendarContainer = document.querySelector(".luxury-room-calendar-container");
const budget = document.querySelector(".budget-select");
const budgetCalendar = document.querySelector(".budget-room-calendar");
const standard = document.querySelector(".standard-select");
const standardCalendar = document.querySelector(".standard-room-calendar");
const luxury = document.querySelector(".luxury-select");
const luxuryCalendar = document.querySelector(".luxury-room-calendar");
const navBudgetItem = document.querySelector(".budget-select");
const navStandardItem = document.querySelector(".standard-select");
const navLuxuryItem = document.querySelector(".luxury-select");
const roomSelect = document.getElementById("room");

// Hides message on button click.
if (bookingSuccessButton) {
    bookingSuccessButton.addEventListener("click", () => {
        bookingSuccess.classList.add("hide");
    });
}

// Hides message on button click.
if (bookingFailButton) {
    bookingFailButton.addEventListener("click", () => {
        bookingFail.classList.add("hide");
    });
}

// Shows budget hotel room content on page load. Hides standard and luxury content.
if (budget) {
    budget.classList.add("selected");
    standard.classList.remove("selected");
    luxury.classList.remove("selected");

    budgetRoomContent.classList.remove("hide");
    standardRoomContent.classList.add("hide");
    luxuryRoomContent.classList.add("hide");

    budgetRoomCalendarContainer.classList.remove("hide");
    standardRoomCalendarContainer.classList.add("hide");
    luxuryRoomCalendarContainer.classList.add("hide");

    budgetCalendar.classList.remove("hide");
    standardCalendar.classList.add("hide");
    luxuryCalendar.classList.add("hide");

    navBudgetItem.classList.add("nav-room-item-selected");
}

// Shows budget hotel room content when selected. Hides standard and luxury content.
if (budget) {
    budget.addEventListener("click", () => {
        budget.classList.add("selected");
        standard.classList.remove("selected");
        luxury.classList.remove("selected");

        budgetRoomContent.classList.remove("hide");
        standardRoomContent.classList.add("hide");
        luxuryRoomContent.classList.add("hide");

        budgetRoomCalendarContainer.classList.remove("hide");
        standardRoomCalendarContainer.classList.add("hide");
        luxuryRoomCalendarContainer.classList.add("hide");

        budgetCalendar.classList.remove("hide");
        standardCalendar.classList.add("hide");
        luxuryCalendar.classList.add("hide");

        navBudgetItem.classList.add("nav-room-item-selected");
        navStandardItem.classList.remove("nav-room-item-selected");
        navLuxuryItem.classList.remove("nav-room-item-selected");

        if (roomSelect) {
            roomSelect.selectedIndex = 0;
        }
    });
}

// Shows standard hotel room content when selected. Hides budget and luxury content.
if (standard) {
    standard.addEventListener("click", () => {
        budget.classList.remove("selected");
        standard.classList.add("selected");
        luxury.classList.remove("selected");

        budgetRoomContent.classList.add("hide");
        standardRoomContent.classList.remove("hide");
        luxuryRoomContent.classList.add("hide");

        budgetRoomCalendarContainer.classList.add("hide");
        standardRoomCalendarContainer.classList.remove("hide");
        luxuryRoomCalendarContainer.classList.add("hide");

        budgetCalendar.classList.add("hide");
        standardCalendar.classList.remove("hide");
        luxuryCalendar.classList.add("hide");

        navBudgetItem.classList.remove("nav-room-item-selected");
        navStandardItem.classList.add("nav-room-item-selected");
        navLuxuryItem.classList.remove("nav-room-item-selected");

        if (roomSelect) {
            roomSelect.selectedIndex = 1;
        }
    });
}

// Shows luxury hotel room content when selected. Hides budget and standard content.
if (luxury) {
    luxury.addEventListener("click", () => {
        budget.classList.remove("selected");
        standard.classList.remove("selected");
        luxury.classList.add("selected");

        budgetRoomContent.classList.add("hide");
        standardRoomContent.classList.add("hide");
        luxuryRoomContent.classList.remove("hide");

        budgetRoomCalendarContainer.classList.add("hide");
        standardRoomCalendarContainer.classList.add("hide");
        luxuryRoomCalendarContainer.classList.remove("hide");

        budgetCalendar.classList.add("hide");
        standardCalendar.classList.add("hide");
        luxuryCalendar.classList.remove("hide");

        navBudgetItem.classList.remove("nav-room-item-selected");
        navStandardItem.classList.remove("nav-room-item-selected");
        navLuxuryItem.classList.add("nav-room-item-selected");

        if (roomSelect) {
            roomSelect.selectedIndex = 2;
        }
    });
}

// Hides message on button click.
const OKbutton = document.querySelector(".OK-button");
const transferCodeFail = document.querySelector(".transfer-code-check");

if (OKbutton && transferCodeFail) {
    OKbutton.addEventListener("click", () => {
        transferCodeFail.classList.add("hide");
    });
}

// Hides message on button click.
const receipt = document.querySelector(".receipt");
const receiptButton = document.querySelector(".receipt button");

if (receiptButton && receipt) {
    receiptButton.addEventListener("click", () => {
        receipt.classList.add("hide");
    });
}