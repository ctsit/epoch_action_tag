$(function() {
    $('body').on('dialogopen', function(event, ui) {
        var $popup = $(event.target);
        if ($popup.prop('id') !== 'action_tag_explain_popup') {
            // That's not the popup we are looking for...
            return false;
        }

        // Aux function that checks if text matches the @NOW string.
        var isReadOnlySurveyLabelColumn = function() {
            return $(this).text() === '@NOW';
        }

        // Getting @NOW row from action tags help table.
        var $default_action_tag = $popup.find('td').filter(isReadOnlySurveyLabelColumn).parent();
        if ($default_action_tag.length !== 1) {
            return false;
        }

        var tag_name = '@NOW-EPOCH';
        var descr = 'Writes the current Epoch time (aka Unix time) into a field. It works similarly to @NOW, but instead of returning a string, @NOW-EPOCH returns an integer, which can be used to set calculated fields or branching logic.';

        // Creating a new action tag row.
        var $new_action_tag = $default_action_tag.clone();
        var $cols = $new_action_tag.children('td');
        var $button = $cols.find('button');

        if ($button.length !== 0) {
            // Column 1: updating button behavior.
            $button.attr('onclick', $button.attr('onclick').replace('@NOW', tag_name));
        }

        // Columns 2: updating action tag label.
        $cols.filter(isReadOnlySurveyLabelColumn).text(tag_name);

        // Column 3: updating action tag description.
        $cols.last().html(descr);

        // Placing new action tag.
        $new_action_tag.insertAfter($default_action_tag);
    });
});
