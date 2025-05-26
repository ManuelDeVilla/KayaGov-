// Profile Page Specific JavaScript

// DOM Elements
const editButton = document.getElementById('edit-button');
const saveButton = document.getElementById('save-button');
const profileForm = document.getElementById('profile-form');
const profileInputs = profileForm.querySelectorAll('input');
const avatarEditButton = document.querySelector('.edit-button');

// Initial form data
let initialFormData = {};

// Store initial values
profileInputs.forEach(input => {
  initialFormData[input.name] = input.value;
});

// Enable form editing
function enableEditing() {
  profileInputs.forEach(input => {
    input.removeAttribute('readonly');
  });
  
  saveButton.disabled = false;
  editButton.disabled = true;
  
  // Focus the first input
  profileInputs[0].focus();
  
  // Update avatar edit button
  avatarEditButton.textContent = 'Change Photo';
}

// Disable form editing
function disableEditing() {
  profileInputs.forEach(input => {
    input.setAttribute('readonly', true);
  });
  
  saveButton.disabled = true;
  editButton.disabled = false;
  
  // Update avatar edit button
  avatarEditButton.textContent = 'Edit';
}

// Handle form submission
function handleSave(e) {
  e.preventDefault();
  
  // Validate the form
  if (!validateForm()) {
    return;
  }
  
  // Show loading state
  saveButton.innerHTML = '<span class="loading-spinner"></span> Saving...';
  saveButton.disabled = true;
  
  // Simulate API call
  setTimeout(() => {
    // Update the initial values with new ones
    profileInputs.forEach(input => {
      initialFormData[input.name] = input.value;
    });
    
    // Show success message
    showSuccessMessage();
    
    // Reset form state
    saveButton.innerHTML = 'Save';
    disableEditing();
  }, 1500);
}

// Form validation
function validateForm() {
  let isValid = true;
  
  // Remove any existing error messages
  document.querySelectorAll('.error-message').forEach(el => el.remove());
  document.querySelectorAll('.form-group.error').forEach(el => el.classList.remove('error'));
  
  // Validate each field
  profileInputs.forEach(input => {
    const formGroup = input.closest('.form-group');
    
    // Basic required validation
    if (!input.value.trim()) {
      isValid = false;
      formGroup.classList.add('error');
      
      const errorMessage = document.createElement('div');
      errorMessage.className = 'error-message';
      errorMessage.textContent = 'This field is required.';
      formGroup.appendChild(errorMessage);
    }
    
    // Email validation
    if (input.type === 'email' && input.value.trim()) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(input.value.trim())) {
        isValid = false;
        formGroup.classList.add('error');
        
        const errorMessage = document.createElement('div');
        errorMessage.className = 'error-message';
        errorMessage.textContent = 'Please enter a valid email address.';
        formGroup.appendChild(errorMessage);
      }
    }
    
    // Phone validation
    if (input.type === 'tel' && input.value.trim()) {
      const phoneRegex = /^\+?\d{1,4}[-.\s]?\(?\d{1,3}\)?[-.\s]?\d{1,4}[-.\s]?\d{1,4}[-.\s]?\d{1,9}$/;
      if (!phoneRegex.test(input.value.trim())) {
        isValid = false;
        formGroup.classList.add('error');
        
        const errorMessage = document.createElement('div');
        errorMessage.className = 'error-message';
        errorMessage.textContent = 'Please enter a valid phone number.';
        formGroup.appendChild(errorMessage);
      }
    }
  });
  
  return isValid;
}

// Show success message
function showSuccessMessage() {
  // Remove existing success message if any
  const existingMessage = document.querySelector('.success-message');
  if (existingMessage) {
    existingMessage.remove();
  }
  
  // Create success message
  const successMessage = document.createElement('div');
  successMessage.className = 'success-message';
  successMessage.innerHTML = `
    <svg viewBox="0 0 24 24">
      <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path>
    </svg>
    <span>Profile updated successfully!</span>
  `;
  
  // Insert before the form
  profileForm.parentNode.insertBefore(successMessage, profileForm);
  
  // Remove the message after 5 seconds
  setTimeout(() => {
    successMessage.remove();
  }, 5000);
}

// Reset form to initial values
function resetForm() {
  profileInputs.forEach(input => {
    input.value = initialFormData[input.name];
  });
  
  // Remove any error messages
  document.querySelectorAll('.error-message').forEach(el => el.remove());
  document.querySelectorAll('.form-group.error').forEach(el => el.classList.remove('error'));
}

// Handle cancel button (ESC key)
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape' && !editButton.disabled) {
    resetForm();
    disableEditing();
  }
});

// Avatar interaction
function setupAvatarInteraction() {
  const avatarImage = document.querySelector('.avatar-image');
  
  // Create upload overlay
  const uploadOverlay = document.createElement('div');
  uploadOverlay.className = 'upload-overlay';
  uploadOverlay.innerHTML = `
    <svg class="upload-icon" viewBox="0 0 24 24">
      <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"></path>
    </svg>
  `;
  avatarImage.appendChild(uploadOverlay);
  
  // Add file input for image upload
  const fileInput = document.createElement('input');
  fileInput.type = 'file';
  fileInput.accept = 'image/*';
  fileInput.className = 'image-upload';
  avatarImage.appendChild(fileInput);
  
  // Handle avatar click when not in edit mode
  avatarEditButton.addEventListener('click', function() {
    if (this.textContent === 'Edit') {
      enableEditing();
    } else {
      fileInput.click();
    }
  });
  
  // Handle file selection
  fileInput.addEventListener('change', function() {
    if (this.files && this.files[0]) {
      const reader = new FileReader();
      
      reader.onload = function(e) {
        // Replace placeholder with actual image
        const img = document.createElement('img');
        img.src = e.target.result;
        img.style.width = '100%';
        img.style.height = '100%';
        img.style.objectFit = 'cover';
        
        // Replace SVG placeholder with image
        const placeholder = avatarImage.querySelector('.avatar-placeholder');
        if (placeholder) {
          placeholder.remove();
        }
        
        // Remove any existing image
        const existingImg = avatarImage.querySelector('img');
        if (existingImg) {
          existingImg.remove();
        }
        
        avatarImage.insertBefore(img, avatarImage.firstChild);
      };
      
      reader.readAsDataURL(this.files[0]);
    }
  });
}

// Event Listeners
if (editButton) {
  editButton.addEventListener('click', enableEditing);
}

if (saveButton) {
  saveButton.addEventListener('click', handleSave);
}

if (profileForm) {
  profileForm.addEventListener('submit', handleSave);
}

// Initialize profile page
document.addEventListener('DOMContentLoaded', function() {
  if (document.querySelector('.profile-container')) {
    setupAvatarInteraction();
  }
});