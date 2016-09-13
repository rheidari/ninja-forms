define([], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'forms' ), 'submit:response', this.actionSubmit );
		},

		actionSubmit: function( response ) {
			if ( _.size( response.errors ) == 0 && 'undefined' != typeof response.data.actions ) {
				if ( 'undefined' != typeof response.data.actions.success_message && '' != response.data.actions.success_message ) {
					jQuery( '#nf-form-'+response.data.form_id+'-cont .nf-response-msg' ).html( response.data.actions.success_message );
				}
			}
		}

	});

	return controller;
} );
