// delete-confirm.js - Fixed version
(function() {
    'use strict';
    
    console.log('Delete confirm script loading...');
    
    // Track which forms have listeners
    const formsWithListeners = new WeakMap();
    
    // Custom confirm function
    function showCustomConfirm(title, message, confirmText, cancelText) {
        return new Promise((resolve) => {
            const overlay = document.createElement('div');
            overlay.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 99998;
                display: flex;
                justify-content: center;
                align-items: center;
            `;
            
            const modal = document.createElement('div');
            modal.style.cssText = `
                background: white;
                border-radius: 10px;
                padding: 20px;
                max-width: 500px;
                width: 90%;
                z-index: 99999;
                box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            `;
            
            const modalId = 'modal-' + Date.now();
            modal.innerHTML = `
                <div style="border-bottom: 2px solid #dc3545; padding-bottom: 10px; margin-bottom: 15px;">
                    <h4 style="color: #dc3545; margin: 0;">
                        <i class="fas fa-trash me-2"></i>${title}
                    </h4>
                </div>
                
                <div style="margin-bottom: 20px;">
                    ${message}
                </div>
                
                <div style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" id="cancel-${modalId}" 
                        style="padding: 8px 20px; background: #6c757d; color: white; 
                               border: none; border-radius: 5px; cursor: pointer;">
                        <i class="fas fa-times me-1"></i>${cancelText}
                    </button>
                    <button type="button" id="confirm-${modalId}"
                        style="padding: 8px 20px; background: #dc3545; color: white; 
                               border: none; border-radius: 5px; cursor: pointer;">
                        <i class="fas fa-trash me-1"></i>${confirmText}
                    </button>
                </div>
            `;
            
            overlay.appendChild(modal);
            document.body.appendChild(overlay);
            
            // Cleanup function
            const cleanup = (result) => {
                if (overlay.parentNode) {
                    document.body.removeChild(overlay);
                }
                resolve(result);
            };
            
            // Add listeners
            document.getElementById(`cancel-${modalId}`).onclick = () => cleanup(false);
            document.getElementById(`confirm-${modalId}`).onclick = () => cleanup(true);
            
            // ESC key
            const escHandler = (e) => e.key === 'Escape' && cleanup(false);
            document.addEventListener('keydown', escHandler);
            
            // Overlay click
            overlay.onclick = (e) => e.target === overlay && cleanup(false);
        });
    }
    
    // Form handler - SIMPLIFIED
    async function handleFormSubmit(event) {
        console.log('Form submit intercepted');
        
        // Prevent default behavior
        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();
        
        const form = event.target;
        const productName = form.getAttribute('data-product-name');
        const productId = form.getAttribute('data-product-id');
        
        console.log('Showing confirm for:', productName);
        
        try {
            const confirmed = await showCustomConfirm(
                'Delete Product',
                `Are you sure you want to delete "<strong>${productName}</strong>" (ID: #${productId})?<br><br>
                 <div style="background: #fff3cd; color: #856404; padding: 10px; border-radius: 5px; border: 1px solid #ffeaa7;">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    This action cannot be undone!
                 </div>`,
                'Delete',
                'Cancel'
            );
            
            if (confirmed) {
                console.log('Confirmed - submitting form');
                // Remove our event listener temporarily
                form.removeEventListener('submit', handleFormSubmit);
                // Submit the form
                form.submit();
            } else {
                console.log('Cancelled by user');
                // Re-add the event listener if cancelled
                setTimeout(() => {
                    if (!formsWithListeners.has(form)) {
                        form.addEventListener('submit', handleFormSubmit);
                        formsWithListeners.set(form, true);
                    }
                }, 100);
            }
        } catch (error) {
            console.error('Error:', error);
            // Re-add listener on error
            setTimeout(() => {
                if (!formsWithListeners.has(form)) {
                    form.addEventListener('submit', handleFormSubmit);
                    formsWithListeners.set(form, true);
                }
            }, 100);
        }
    }
    
    // Initialize - DO NOT CLONE/REPLACE FORMS
    function initDeleteHandlers() {
        console.log('Initializing delete handlers...');
        
        const forms = document.querySelectorAll('.delete-form');
        console.log('Found', forms.length, 'delete forms');
        
        forms.forEach(form => {
            // Check if this form already has our listener
            if (formsWithListeners.has(form)) {
                console.log('Form already has listener:', form.getAttribute('data-product-name'));
                return;
            }
            
            // Remove any existing submit listeners (but keep the form)
            const oldForm = form.cloneNode(false); // Clone without children
            const attributes = form.getAttributeNames();
            
            // Copy all attributes
            attributes.forEach(attr => {
                oldForm.setAttribute(attr, form.getAttribute(attr));
            });
            
            // Copy all children
            while (form.firstChild) {
                oldForm.appendChild(form.firstChild);
            }
            
            // Replace form in DOM
            form.parentNode.replaceChild(oldForm, form);
            
            // Add our listener to the new form
            const currentForm = oldForm;
            currentForm.addEventListener('submit', handleFormSubmit);
            formsWithListeners.set(currentForm, true);
            
            console.log('Handler added to form for:', currentForm.getAttribute('data-product-name'));
        });
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(initDeleteHandlers, 100);
        });
    } else {
        setTimeout(initDeleteHandlers, 100);
    }
    
    // Re-initialize if content changes (for dynamic pages)
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes.length) {
                setTimeout(initDeleteHandlers, 200);
            }
        });
    });
    
    observer.observe(document.body, { childList: true, subtree: true });
})();