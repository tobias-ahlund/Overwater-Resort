// Magnus V. - This button makes the add-feature-forma visible:
const addFeatureButton = document.getElementById('add-new-feature');
const addFeatureForm = document.querySelector(
  '.feature-handler-wrapper .drop-down-field'
);

// Magnus V. - The two buttons on the add-feature-form: One submit- and one reset(cancel)-button:
const cancelButton = document.querySelector('#cancel-button');

addFeatureButton.addEventListener('click', () => {
  addFeatureForm.classList.toggle('active');
});

cancelButton.addEventListener('click', () => {
  addFeatureForm.classList.toggle('active');
});
