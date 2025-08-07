<?php
/* Template Name: Invite Template */
get_header();
?>

<section class="invite-candidate-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Invite Candidate</h2>
                <form id="invitationForm">
                    <input type="hidden" name="action" value="send_invitation">
                    <?php wp_nonce_field('invite_candidate_nonce', 'security'); ?>

                    <label for="candidateName">Candidate Name:</label>
                    <input type="text" id="candidateName" name="candidateName" required><br><br>
                    
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required><br><br>
                    
                    <label for="jobTitle">Job Title:</label>
                    <input type="text" id="jobTitle" name="jobTitle" required><br><br>
                    
                    <button type="submit">Send Invitation</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
