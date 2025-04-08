// Form validation
function validateForm() {
    const title = document.getElementById('title').value.trim();
    const description = document.getElementById('description').value.trim();
    const moodId = document.getElementById('mood_id').value;
    const imageUrl = document.getElementById('image_url').value.trim();

    // Required fields validation
    if (!title || !description || !moodId) {
        alert('Please fill in all required fields');
        return false;
    }

    // Image URL validation (if provided)
    if (imageUrl && !isValidUrl(imageUrl)) {
        alert('Please enter a valid image URL');
        return false;
    }

    return true;
}

// URL validation helper
function isValidUrl(string) {
    try {
        new URL(string);
        return true;
    } catch (_) {
        return false;
    }
}

// Auto-submit mood form when radio button is changed
document.addEventListener('DOMContentLoaded', function() {
    const moodForm = document.getElementById('moodForm');
    if (moodForm) {
        const radioButtons = moodForm.querySelectorAll('input[type="radio"]');
        radioButtons.forEach(radio => {
            radio.addEventListener('change', () => {
                moodForm.submit();
            });
        });
    }
});

// Show success/error messages
document.addEventListener('DOMContentLoaded', function() {
    const message = document.querySelector('.message');
    if (message) {
        setTimeout(() => {
            message.style.opacity = '0';
            setTimeout(() => {
                message.style.display = 'none';
            }, 600);
        }, 3000);
    }
});

// Image error handling
document.addEventListener('DOMContentLoaded', function() {
    const movieImages = document.querySelectorAll('.movie-card img');
    movieImages.forEach(img => {
        img.addEventListener('error', function() {
            this.src = 'default.jpg';
        });
    });
}); 