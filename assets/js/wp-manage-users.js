/* global wp */

window.wp = window.wp || {};

( function( $ ) {

    /**
     * Create an object.
     */
    window.ManageUsers = {
        /**
         * Method to load all an events.
         *
         * @return void
         */
        start: function () {

            // Setup globals.
            this.setupGlobals();

            // Listen to events ("Add hooks!").
            this.setupListeners();
        },

        /**
         * Defined the global.
         *
         * @return void
         */
        setupGlobals: function () {
            this.tmplUserDetails = wp.template( 'wpmu-user-details' );
        },

        /**
         * Add an events.
         *
         * @return void
         */
        setupListeners: function () {

            // When load the window fire event.
            $( window ).on( 'load', this.onLoadWindow.bind( this ) );

            // Fetch user information.
            $( document ).on( 'click', '.user-list-table table td a', this.fetchUserDetails.bind( this ) );

            // Reset the content on close the modal.
            $( '#userDetailModal' ).on('hidden.bs.modal', this.onCloseUserModal.bind( this ) );
        },

        /**
         * Load all the events when load the window.
         *
         * @return void
         */
        onLoadWindow: function () {

            setTimeout(
                function() {
                    $( '.user-list-table table' ).removeClass( 'loading' ).addClass( 'loaded' );
                    $( '.user-list-table table tr.loader' ).remove();
                },
                600
            );
        },

        /**
         * Perform the operation when close the modal.
         *
         * @return void
         */
        onCloseUserModal: function () {
            $( '.user-details .user-detail-data' ).html( '' );
            $( '.user-details .user-detail-loading' ).addClass( 'loading' ).removeClass( 'loaded' );
        },

        /**
         * Fetch the user details.
         *
         * @return void
         */
        fetchUserDetails: function ( e ) {
            e.preventDefault();

            // Define the variables;
            var $el     = $( e.target ),
                self    = this,
                user_id = $el.data( 'user-id' ),
                data    = {
                    user: {},
                    message: ''
                };

            // Open modal.
            $( '#userDetailModal' ).modal( 'show' );

            // Send ajax request to fetch the data.
            $.ajax(
                {
                    url: wpmu_object.admin_url,
                    type: 'POST',
                    data: {
                        action: 'wpmu_user_details',
                        id: user_id,
                        __nonce: wpmu_object.user.nonce
                    },
                    success: function( response ) {

                        // Handle successful response.
                        if ( response.success ) {
                            data.user = response.data;
                        } else {
                            data.message = response.data;
                        }

                        // Load data to modal.
                        setTimeout(
                            function() {
                                $( '.user-details .user-detail-data' ).html( self.tmplUserDetails( data ) );
                                $( '.user-details .user-detail-loading' ).removeClass( 'loading' ).addClass( 'loaded' );
                            },
                            600
                        );

                    },
                    error: function() {

                        // Handle an error message.
                        data.message = wpmu_object.user.error;

                        // Load data to modal.
                        setTimeout(
                            function() {
                                $( '.user-details .user-detail-data' ).html( self.tmplUserDetails( data ) );
                                $( '.user-details .user-detail-loading' ).removeClass( 'loading' ).addClass( 'loaded' );
                            },
                            600
                        );
                    }
                }
            );

        }

    }

    // Launch ManageUsers.
    window.ManageUsers.start();

}( jQuery ) );
