jQuery(document).ready(function($) {
    // Debug initialization
    console.log('NELX Google Meet JS loaded successfully');
    console.log('AJAX URL:', nelxGoogleMeet.ajax_url);
    console.log('Nonce:', nelxGoogleMeet.nonce);
    
    // Check if required elements exist
    if ($('#nelx_google_meet_email').length) {
        console.log('Google Meet email input found');
    } else {
        console.error('Google Meet email input NOT found');
    }
    
    if ($('#nelx_connect_google').length) {
        console.log('Connect Google button found');
    } else {
        console.warn('Connect Google button NOT found');
    }
    
    if ($('#nelx_disconnect_google').length) {
        console.log('Disconnect Google button found');
    } else {
        console.warn('Disconnect Google button NOT found');
    }

    // Auto-save email when user clicks outside the input field
    $('#nelx_google_meet_email').on('blur', function() {
        console.log('Email input blur event triggered');
        var email = $(this).val().trim();
        
        if (!email) {
            console.log('Email input is empty, skipping save');
            return;
        }
        
        if (!isValidEmail(email)) {
            console.warn('Invalid email format:', email);
            showMessage('Please enter a valid email address', 'error');
            return;
        }
        
        console.log('Saving email via blur event:', email);
        saveEmail(email);
    });
    
    // Also save on Enter key press
    $('#nelx_google_meet_email').on('keypress', function(e) {
        if (e.which === 13) { // Enter key
            console.log('Enter key pressed in email input');
            e.preventDefault();
            var email = $(this).val().trim();
            
            if (!email || !isValidEmail(email)) {
                console.warn('Invalid email on Enter key:', email);
                showMessage('Please enter a valid email address', 'error');
                return;
            }
            
            console.log('Saving email via Enter key:', email);
            saveEmail(email);
        }
    });
    
    // Handle Google Connect button click
    $(document).on('click', '#nelx_connect_google', function(e) {
        console.log('Connect Google button clicked');
        e.preventDefault();
        var url = $(this).attr('href');
        
        console.log('OAuth URL:', url);
        
        if (url === '#') {
            console.error('Invalid OAuth URL - integration not configured');
            showMessage('Google integration is not properly configured. Please contact administrator.', 'error');
            return;
        }
        
        // Open in new window for OAuth flow
        var authWindow = window.open(url, 'google_auth', 'width=600,height=700,scrollbars=yes');
        
        // Check if the window was blocked
        if (!authWindow || authWindow.closed || typeof authWindow.closed === 'undefined') {
            console.error('Popup window blocked by browser');
            showMessage('Popup window was blocked. Please allow popups for this site and try again.', 'error');
        } else {
            console.log('OAuth popup window opened successfully');
            showMessage('Opening Google authentication window...', 'info');
        }
    });
    
    // Disconnect Google account
    $(document).on('click', '#nelx_disconnect_google', function() {
        console.log('Disconnect Google button clicked');
        
        if (!confirm('Are you sure you want to disconnect your Google account? This will prevent Google Meet creation for your appointments.')) {
            console.log('Disconnect cancelled by user');
            return;
        }
        
        var button = $(this);
        button.prop('disabled', true).text('Disconnecting...');
        
        console.log('Initiating disconnect AJAX request');
        
        $.ajax({
            url: nelxGoogleMeet.ajax_url,
            type: 'POST',
            data: {
                action: 'disconnect_google',
                nonce: nelxGoogleMeet.nonce
            },
            success: function(response) {
                console.log('Disconnect AJAX success:', response);
                
                if (response.success) {
                    console.log('Google account disconnected successfully');
                    showMessage(response.data.message, 'success');
                    setTimeout(function() {
                        console.log('Reloading page after successful disconnect');
                        location.reload();
                    }, 1500);
                } else {
                    console.error('Disconnect failed:', response.data);
                    showMessage(response.data.message, 'error');
                    button.prop('disabled', false).text('Disconnect Google');
                }
            },
            error: function(xhr, status, error) {
                console.error('Disconnect AJAX error:', {
                    status: status,
                    error: error,
                    responseText: xhr.responseText,
                    statusCode: xhr.status
                });
                showMessage('An error occurred while disconnecting. Please try again.', 'error');
                button.prop('disabled', false).text('Disconnect Google');
            },
            complete: function() {
                console.log('Disconnect AJAX request completed');
            }
        });
    });
    
    // Save email function
    function saveEmail(email) {
        console.log('saveEmail function called with:', email);
        
        // Show saving indicator
        var inputField = $('#nelx_google_meet_email');
        var originalBorder = inputField.css('border-color');
        inputField.css('border-color', '#0073aa').css('background-color', '#f8f9fa');
        
        console.log('Initiating save email AJAX request');
        
        $.ajax({
            url: nelxGoogleMeet.ajax_url,
            type: 'POST',
            data: {
                action: 'save_google_meet_email',
                email: email,
                nonce: nelxGoogleMeet.nonce
            },
            beforeSend: function() {
                console.log('AJAX request started - saving email');
                showMessage('Saving email...', 'info');
            },
            success: function(response) {
                console.log('Save email AJAX success:', response);
                
                if (response.success) {
                    console.log('Email saved successfully');
                    var fullMessage = response.data.message;
                    if (response.data.description) {
                        fullMessage += '<br><small>' + response.data.description + '</small>';
                    }
                    showMessage(fullMessage, 'success');
                    inputField.css('border-color', '#28a745').css('background-color', '#f8fff9');
                    
                    // Reset border color after delay
                    setTimeout(function() {
                        inputField.css('border-color', originalBorder).css('background-color', '');
                    }, 2000);
                } else {
                    console.error('Email save failed:', response.data);
                    showMessage(response.data.message, 'error');
                    inputField.css('border-color', '#dc3545').css('background-color', '#fff5f5');
                }
            },
            error: function(xhr, status, error) {
                console.error('Save email AJAX error:', {
                    status: status,
                    error: error,
                    responseText: xhr.responseText,
                    statusCode: xhr.status
                });
                showMessage('An error occurred while saving. Please try again.', 'error');
                inputField.css('border-color', originalBorder).css('background-color', '');
            },
            complete: function() {
                console.log('Save email AJAX request completed');
            }
        });
    }
    
    // Email validation
    function isValidEmail(email) {
        var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        var isValid = regex.test(email);
        console.log('Email validation result for "' + email + '":', isValid);
        return isValid;
    }
    
    // Show message
    function showMessage(message, type) {
        console.log('Showing message:', type, message);
        
        var messageDiv = $('.nelx-message');
        if (messageDiv.length === 0) {
            console.error('Message div (.nelx-message) not found in DOM');
            // Create message div if it doesn't exist
            $('.nelx-google-meet-settings').append('<div class="nelx-message" style="display: none;"></div>');
            messageDiv = $('.nelx-message').last();
        }
        
        messageDiv.removeClass('success error info').addClass(type).html(message).stop().slideDown(200);
        
        // Only auto-hide success and info messages
        if (type === 'success' || type === 'info') {
            console.log('Setting auto-hide timer for', type, 'message');
            setTimeout(function() {
                console.log('Hiding message');
                messageDiv.slideUp(200);
            }, type === 'success' ? 5000 : 3000);
        }
    }
    
    // Check for URL parameters to show messages (like after OAuth redirect)
    var urlParams = new URLSearchParams(window.location.search);
    console.log('URL parameters:', Object.fromEntries(urlParams.entries()));
    
    if (urlParams.has('google_auth')) {
        console.log('Google auth parameter found:', urlParams.get('google_auth'));
        
        if (urlParams.get('google_auth') === 'success') {
            console.log('Google auth successful - showing success message');
            showMessage('✅ Successfully connected to Google! Your account is now ready for Google Meet integration.', 'success');
            
            // Clean URL without page reload
            var newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
            console.log('Cleaning URL from:', window.location.href, 'to:', newUrl);
            window.history.replaceState({}, document.title, newUrl);
        }
    }
    
    // Handle OAuth callback from popup window (if any)
    if (typeof window.opener !== 'undefined' && window.opener !== null) {
        console.log('Window has opener - might be OAuth popup');
        
        try {
            // Check if this is an OAuth callback
            if (window.location.search.includes('code=') || window.location.search.includes('error=')) {
                console.log('OAuth callback detected in popup');
                window.opener.postMessage({
                    type: 'google_oauth_callback',
                    url: window.location.href
                }, '*');
                console.log('Posted message to opener, closing window');
                window.close();
            }
        } catch (e) {
            console.log('Not an OAuth popup window or message failed:', e.message);
        }
    }
    
    // Listen for messages from popup windows
    window.addEventListener('message', function(event) {
        console.log('Message received from:', event.origin, 'data:', event.data);
        
        if (event.data && event.data.type === 'google_oauth_callback') {
            console.log('Google OAuth callback message received');
            // Handle the callback if needed
        }
    });
    
    // Debug: Log all AJAX requests for this page
    $(document).ajaxComplete(function(event, xhr, settings) {
        if (settings.url.includes('admin-ajax.php')) {
            console.log('AJAX Completed:', {
                url: settings.url,
                data: settings.data,
                status: xhr.status,
                statusText: xhr.statusText
            });
        }
    });
    
    // Debug: Log AJAX errors globally
    $(document).ajaxError(function(event, xhr, settings, thrownError) {
        if (settings.url.includes('admin-ajax.php')) {
            console.error('AJAX Error:', {
                url: settings.url,
                data: settings.data,
                status: xhr.status,
                error: thrownError,
                responseText: xhr.responseText
            });
        }
    });
});