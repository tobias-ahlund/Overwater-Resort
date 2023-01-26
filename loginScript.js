// Magnus V - this is added to control the visibility of the login-field:

const loginHeader = document.querySelector('.login-content span');
const dropDownForm = document.querySelector('.drop-down-field');

loginHeader.addEventListener('click', () => {
  dropDownForm.classList.toggle('active');
});

// --- --- --- ---

// Sends user back to index.php on OKbutton click.
const OKbutton = document.querySelector('.OK-button');
const userNamePasswordFailMessage = document.querySelector(
  '.user-name-password-fail'
);

if (OKbutton && userNamePasswordFailMessage) {
  OKbutton.addEventListener('click', () => {
    userNamePasswordFailMessage.classList.add('hide');
    document.location = '../../index.php';
  });
}
