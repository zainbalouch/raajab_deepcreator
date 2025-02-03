jQuery(document).ready(function ($) {
    // Show modal if reg_is_first_login is 1
    if ($('#felan-first-login-modal').length) {
        setTimeout(function() {
            $('#felan-first-login-modal').show();
        }, 1000);
        }

    // Close modal
    $('.felan-close-modal').on('click', function () {
        $('#felan-first-login-modal').hide();
    });

    // Save profile image
    $('#ium-save-profile-image').on('click', function () {
        const avatarUrl = $('#avatar_url').val();
        const avatarId = $('#avatar_id').val();
        const userId = $('#user_id').val();
        const redirect_url = $('#redirect_url').val();

        if (!avatarUrl || !avatarId) {
            alert('Please upload a profile image.');
            return;
        }

        // Get freelancer data
        var author_avatar_image_id = avatarId;
        var author_avatar_image_url = avatarUrl;
        var user_id = userId;

        
        
        // Submit data
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: felan_avatar_vars.ajax_url,
            data: {
                action: "freelancer_submit_ajax",
                author_avatar_image_id: author_avatar_image_id,
                author_avatar_image_url: author_avatar_image_url,
                user_id: user_id,
                ium_is_first_login: 0,
            },
            beforeSend: function () {
                $('#ium-save-profile-image').prop('disabled', true);
                $('#ium-save-profile-image').html('<i class="fal fa-spinner fa-spin"></i> Saving...');
            },
            success: function (response) {
                console.log(response);
                if (response.success === true) {
                    window.location.href = redirect_url;
                } else {
                    alert('Error saving profile data.');
                }
            },
            error: function () {
                alert('Error saving profile data.');
            },
            complete: function() {
                $('#ium-save-profile-image').prop('disabled', false);
                $('#ium-save-profile-image').html('Save and Continue');
            }
        });

    });
});