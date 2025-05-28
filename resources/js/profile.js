// profile.js

document.addEventListener('DOMContentLoaded', () => {
  const editBtn = document.getElementById('edit-button');
  const saveBtn = document.getElementById('save-button');
  const form = document.getElementById('profile-form');

  // Get all input fields inside the form
  const inputs = form.querySelectorAll('input');

  editBtn.addEventListener('click', () => {
    // Remove readonly from inputs
    inputs.forEach(input => {
      input.removeAttribute('readonly');
    });

    // Enable Save button
    saveBtn.disabled = false;

    // Optionally disable the Edit button while editing
    editBtn.disabled = true;
  });

  // Optional: handle form submission (save)
  form.addEventListener('submit', (e) => {
    e.preventDefault();

    // Here you can send the form data via AJAX or submit normally

    // After saving, set inputs back to readonly and disable Save button
    inputs.forEach(input => {
      input.setAttribute('readonly', true);
    });
    saveBtn.disabled = true;
    editBtn.disabled = false;

    alert('Profile saved! (You can replace this with your save logic)');
  });
});
