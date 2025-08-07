jQuery(document).ready(function($) {
    // Show invitation form when button is clicked
    $('#inviteCandidateBtn').click(function(e) {
        e.preventDefault();
        $('#invitationModal').fadeIn();
    });

    // Handle form submission
    $('#invitationForm').submit(function(event) {
        event.preventDefault();

        var candidateName = $('#candidateName').val();
        var email = $('#email').val();
        var jobTitle = $('#jobTitle').val();

        // Prepare data for AJAX request
        var formData = {
            'candidateName': candidateName,
            'email': email,
            'jobTitle': jobTitle,
            'action': 'send_invitation' // Action to identify the AJAX request on the server-side
        };

        // Send AJAX request
        $.ajax({
            type: 'POST',
            url: ajaxurl, // WordPress AJAX handler URL
            data: formData,
            success: function(response) {
                // Handle successful response (optional)
                console.log(response); // Log response to console
                alert('Invitation sent successfully!'); // Display success message (optional)
                $('#invitationModal').fadeOut(); // Close modal after successful submission
            },
            error: function(error) {
                // Handle error response (optional)
                console.error('Error:', error); // Log error to console
                alert('Error sending invitation. Please try again.'); // Display error message (optional)
            }
        });
    });
});
