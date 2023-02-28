jQuery( document ).ready(function() {

    jQuery('.deleted').on('click', function(e) {
    
        e.stopPropagation();
        e.preventDefault();

        var _this = jQuery(this);

        let formData = new FormData();
        formData.append('action', 'remove');
        formData.append('security', inssetscript.security);
        formData.append('id',_this.data('id'));

        jQuery.ajax({
            url: ajaxurl,
            xhrFields: {
                withCredentials: true
            },
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            type: 'post',
            success: function(response) {
                _this.closest('tr').fadeOut('slow');
                jQuery('.delete-confirmation').removeClass('hidden');
                console.log(response);
                return false;
            }
        });

        return;
    });

    jQuery('.slider').on('change', function(e) {

        let formData = new FormData();
        
        // Empêche le reload de la page
        e.stopPropagation();
        e.preventDefault();
        
        formData.append('action', 'updatenote');
        formData.append('security', inssetscript.security);

        let id = jQuery(this).attr('id');
        let value = jQuery(this).val();
        formData.append('note', value);
        formData.append('id', id);

        jQuery('.valNote-'+id).html(value);

        let thisItem = jQuery(this).closest('tr');
    
        // Requête ajax qui utilise les données de la variable 'formData'
        jQuery.ajax({
    
            url: ajaxurl,
            xhrFields: {
                withCredentials: true
            },
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            type: 'post',
    
            success: function(rs) {

                thisItem.fadeOut();
                thisItem.fadeIn();

                return false;
            },
    
        });
        
    });

    jQuery('.majeur').on('change', function(e) {

        let formData = new FormData();
        
        // Empêche le reload de la page
        e.stopPropagation();
        e.preventDefault();
        
        formData.append('action', 'updatemajeur');
        formData.append('security', inssetscript.security);

        let id = jQuery(this).attr('id');
        let value = 0;
        if (jQuery(this).is(':checked'))
        {
            value = 1
        }else { value = 0 }
        formData.append('majeur', value);
        formData.append('id', id);

        let thisItem = jQuery(this).closest('tr');
    
        // Requête ajax qui utilise les données de la variable 'formData'
        jQuery.ajax({
    
            url: ajaxurl,
            xhrFields: {
                withCredentials: true
            },
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            type: 'post',
    
            success: function(rs) {
                thisItem.fadeOut();
                thisItem.fadeIn();
                return false;
            },
    
        });
        
    });

    jQuery('#btnUpdateCountry').on('click', function(e) {
    
        e.stopPropagation();
        e.preventDefault();

        var _this = jQuery('#countries');
        var results = _this.val();
        
        let formData = new FormData();
        formData.append('action', 'activecountries');
        formData.append('security', inssetscript.security);
        formData.append('countries', results);

        console.log(results)

        jQuery.ajax({
            url: ajaxurl,
            xhrFields: {
                withCredentials: true
            },
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            type: 'post',
            success: function(response) {
                jQuery('.confirm-message').removeClass('hidden');
                return false;
            }
        });

        return;
    });
});