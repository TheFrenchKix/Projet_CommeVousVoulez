jQuery( document ).ready(function() {

    jQuery('#formulaire').on('submit', function(e) {
        e.stopPropagation();
        e.preventDefault();

        let formData = new FormData();

        jQuery('#formulaire').find('input, textarea, select').each( function(i){
            let id = jQuery(this).attr('id');
            if (typeof id !== 'undefined'){
                formData.append(id, jQuery(this).val());
            }
        });

        formData.append('action', 'pl');
        formData.append('security', PLscript.security);

        jQuery("#loading").show();

        jQuery.ajax({
            url: PLscript.ajax_url,
            xhrFields: {
                withCredentials: true
            },
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            type: 'post',
            success: function(rs, textStatus, jqXHR) {
                jQuery("#loading").hide();
                window.location.replace("choix-voyage-step-select");
                return false;                
            }
        })

    });

});