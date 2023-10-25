// Get all "Quick View" buttons
const quickViewButtons = document.querySelectorAll('.quick-view');

// Add a click event listener to each "Quick View" button
quickViewButtons.forEach(button => {
    button.addEventListener('click', () => {
        // Get the data-product-id attribute value
        const productId = button.getAttribute('data-product-id');

        // Find the corresponding "modal-box" element
        const modalBox = document.querySelector(`.modal-box[data-product-id="${productId}"]`);

        // Update the style of the "modal-box" element to make it display as "block"
        modalBox.style.display = 'block';

        // Get the "close" element within the modal box
        const closeButton = modalBox.querySelector('.close');

        // Add a click event listener to the "close" element
        closeButton.addEventListener('click', () => {
            // Set the style of the modal box to "display: none" to hide it
            modalBox.style.display = 'none';
        });
    });
});