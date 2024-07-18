jQuery(document).ready(function($) {
    // Function to populate quick edit with custom field data
    function setNoindexQuickEdit() {
        var post_id = inlineEditPost.getId(this);
        var noindex = $('#post-' + post_id).find('.column-noindex').text().trim() === 'Yes' ? 1 : 0;
        
        // Set the value in the quick edit field
        $('input[name="noindex"]', '.inline-edit-row').prop('checked', noindex);
    }

    // Attach the function to the quick edit button
    $('body').on('click', 'a.editinline', setNoindexQuickEdit);
});
