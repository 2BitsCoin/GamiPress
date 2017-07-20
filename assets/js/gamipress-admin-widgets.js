(function($) {
    var gamipress_widget_select2_post_defaults = {
        ajax: {
            url: ajaxurl,
            dataType: 'json',
            delay: 250,
            type: 'POST',
            data: function( params ) {
                return {
                    q: params.term,
                    action: 'gamipress_get_achievements_options'
                };
            },
            processResults: function( results, page ) {
                if( results === null ) {
                    return { results: [] };
                }

                var formatted_results = [];

                results.data.forEach(function(item) {
                    formatted_results.push({
                        id: item.ID,
                        text: item.post_title,
                    });
                });

                return { results: formatted_results };
            }
        },
        theme: 'default gamipress-select2',
        placeholder: gamipress_admin_widgets.id_placeholder,
        allowClear: true,
        multiple: false
    };

    var gamipress_widget_select2_post_multiples = $.extend( true, {}, gamipress_widget_select2_post_defaults, { multiple: true } );

    var gamipress_widget_select2_achievement_types = {
        theme: 'default gamipress-select2',
        placeholder: gamipress_admin_widgets.post_type_placeholder,
        allowClear: true,
        multiple: true
    };

    var gamipress_widget_select2_users = {
        ajax: {
            url: ajaxurl,
            dataType: 'json',
            delay: 250,
            type: 'POST',
            data: function( params ) {
                return {
                    q: params.term,
                    action: 'gamipress_get_users'
                };
            },
            processResults: function( results, page ) {
                if( results === null ) {
                    return { results: [] };
                }

                var formatted_results = [];

                results.data.forEach(function(item) {
                    formatted_results.push({
                        id: item.ID,
                        text: item.user_login,
                    });
                });

                return { results: formatted_results };
            }
        },
        theme: 'default gamipress-select2',
        placeholder: gamipress_admin_widgets.user_placeholder,
        allowClear: true,
        multiple: false
    };

    $( 'select[id^="widget-gamipress"][id$="[id]"]:not(.select2-hidden-accessible)' ).select2( gamipress_widget_select2_post_defaults );
    $( 'select[id^="widget-gamipress"][id$="[include]"]:not(.select2-hidden-accessible), select[id^="widget-gamipress"][id$="[exclude]"]:not(.select2-hidden-accessible)' ).select2( gamipress_widget_select2_post_multiples );
    $( 'select[id^="widget-gamipress_achievements"][id$="[type]"]:not(.select2-hidden-accessible), select[id^="widget-gamipress_points_types"][id$="[type]"]:not(.select2-hidden-accessible), select[id^="widget-gamipress_points"][id$="[type]"]:not(.select2-hidden-accessible)' ).select2( gamipress_widget_select2_achievement_types );
    $( 'select[id^="widget-gamipress"][id$="[user_id]"]:not(.select2-hidden-accessible)' ).select2( gamipress_widget_select2_users );

    // Initialize on widgets area
    $(document).on('widget-updated widget-added', function(e, widget) {
        widget.find( 'select[id^="widget-gamipress"][id$="[id]"]:not(.select2-hidden-accessible)' ).select2( gamipress_widget_select2_post_defaults );
        widget.find( 'select[id^="widget-gamipress"][id$="[include]"]:not(.select2-hidden-accessible), select[id^="widget-gamipress"][id$="[exclude]"]:not(.select2-hidden-accessible)' ).select2( gamipress_widget_select2_post_multiples );
        widget.find( 'select[id^="widget-gamipress_achievements"][id$="[type]"]:not(.select2-hidden-accessible), select[id^="widget-gamipress_points_types"][id$="[type]"]:not(.select2-hidden-accessible), select[id^="widget-gamipress_points"][id$="[type]"]:not(.select2-hidden-accessible)' ).select2( gamipress_widget_select2_achievement_types );
        widget.find( 'select[id^="widget-gamipress"][id$="[user_id]"]:not(.select2-hidden-accessible)' ).select2( gamipress_widget_select2_users );
    });
})(jQuery);