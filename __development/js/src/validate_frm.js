// JavaScript Document
// jQuery to validate contact form


$(document).ready(function()
{
	var myForm = $('.ui_frm_validate');

	myForm.validate({
			errorClass: "errormessage",
			onkeyup: false,
			errorClass: 'error',
			validClass: 'valid',
			/*rules: {
				frm_contact_name: { required: true },
				frm_contact_email: { required: true, email: true },
				frm_contact_message: { required: true },
			},*/
			errorPlacement: function(error, element)
			{
				// Set positioning based on the elements position in the form
				var elem = $(element),
					corners = ['left center', 'right center'],
					flipIt = elem.parents('span.right').length > 0;

				// Check we have a valid error message
				if(!error.is(':empty')) {
					// Apply the tooltip only if it isn't valid
					elem.filter(':not(.valid)').qtip({
						overwrite: false,
						content: error,
						position: {
							my: corners[ flipIt ? 0 : 1 ],
							at: corners[ flipIt ? 1 : 0 ],
							viewport: $(window)
						},
						show: {
							event: false,
							ready: true
						},
						hide: false,
						style: {
							classes: 'ui-tooltip-red ui-tooltip-rounded' // Make it red... the classic error colour!
						}
					})

					// If we have a tooltip on this element already, just update its content
					.qtip('option', 'content.text', error);
				}

				// If the error is empty, remove the qTip
				else { elem.qtip('destroy'); }
			},
			success: $.noop, // Odd workaround for errorPlacement not firing!
	})
});
