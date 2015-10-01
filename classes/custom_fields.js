jQuery(function() {
        var _custom_media = true,
            _orig_send_attachment = wp.media.editor.send.attachment;
            
        jQuery('.uploader .button.remove').click(function(e) {
            var button = jQuery(this);
            var id = button.attr('id').replace('remove-', '');
            jQuery("#"+id).val('');
            jQuery("#image-"+id).attr('src', '').hide();
            jQuery(this).hide();
        });
        jQuery('.uploader .button.upload').click(function(e) {
            var send_attachment_bkp = wp.media.editor.send.attachment;
            var button = jQuery(this);
            var id = button.attr('id').replace('button-', '');
            _custom_media = true;
            wp.media.editor.send.attachment = function(props, attachment){
                if ( _custom_media ) {
                    console.log(attachment);
                    jQuery("#"+id).val(attachment.id);
                    jQuery("#image-"+id).attr('src', attachment.url).show();
                    jQuery("#remove-"+id).show();
                } else {
                    return _orig_send_attachment.apply( this, [props, attachment] );
                };
            }
    
            wp.media.editor.open(button);
            return false;
        });
    
        jQuery('.add_media').on('click', function(){
            _custom_media = false;
        });
        
});

var orderer = {
    values: {},
    
    init: function(orderer_id, target_id) {
        jq_target = jQuery('#' + target_id);
        jq_orderer = jQuery('#' + orderer_id + ' tbody');
        
        jq_target.find('option').each(function() {
            jq_orderer.find('#' + orderer_id + '-' + jQuery(this).val()).find('th').html(jQuery(this).text());
        });
        
        jq_target.change(function() {
            target_ids = jq_target.val();
            jq_orderer.find('input').each(function() {
                index = jQuery(this).attr('name').split('[')[1].split(']')[0];
                orderer.values[index] = jQuery(this).val();
            });
            jq_orderer.empty();
            if (target_ids) {
                for (i = 0; i < target_ids.length; i++) {
                    value = '';
                    if (orderer.values[target_ids[i]])
                        value = orderer.values[target_ids[i]];
                    input = jQuery('<tr><th>' + jQuery('[value="' + target_ids[i] + '"]').text() + '</th><td><input type="text" name="' + orderer_id + '[' + target_ids[i] +']" value="' + value + '" /></td></tr>');
                    jq_orderer.append(input);
                }
            }
        });
    }
}