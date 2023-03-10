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
                window.location.replace("choix-voyage-step-select?id="+rs);
                return false;                
            }
        })

    });

    jQuery('#formulaire-select').on('submit', function(e) {
        e.stopPropagation();
        e.preventDefault();

        let formData = new FormData();

        jQuery('#formulaire-select').find('select').each( function(i){
            let id = jQuery(this).attr('id');
            if (typeof id !== 'undefined'){
                let val = jQuery(this).val();
                if (val !== 'defaut')
                {
                    formData.append('select-'+id, jQuery(this).val());
                }
            }
        });

        var userid = window.location.href.slice(window.location.href.indexOf('=')).split('=');
        
        formData.append('id',userid[1]);
        formData.append('action', 'pl-second');
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

                window.location.replace("choix-voyage-step-final?id="+userid[1]);
                return false;                
            }
        })

    });

    jQuery('#formulaire-select select').on('change', function(e) {

        e.stopPropagation();
        e.preventDefault();
        
        let formData = new FormData(); 

        let id = jQuery(this).attr('id');
        formData.append('id', id);

        let val = jQuery(this).val();
        formData.append('val', val);

        if (val !== "defaut"){

            formData.append('country', val);
            let nextid = parseInt(id) + 1;
            jQuery(".btnSub").removeAttr('disabled');
            jQuery("#" + nextid).removeAttr('disabled');

            for(var i=1; i<=5; i++){
                if (i != id)
                {
                    jQuery("#"+ i +" option[value="+ val +"]").remove();
                }
            }

        }else{

            let nextid = parseInt(id) + 1;
            
            for(var i=nextid; i<=5; i++){
                jQuery("#" + i).attr('disabled', 'disabled');
                jQuery("#" + i).val("defaut").change();
            }

        }

    });

    jQuery('#formulaire-final').on('submit', function(e) {
        
        e.stopPropagation();
        e.preventDefault();

        jQuery("#loading").show();
        jQuery("#loading").hide();

        var userid = window.location.href.slice(window.location.href.indexOf('=')).split('=');

        window.location.replace("choix-voyage?id="+userid[1]);

    });

});