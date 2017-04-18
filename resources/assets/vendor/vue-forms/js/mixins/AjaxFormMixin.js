let Form = require('./../helpers/Form');
let removeElementMixin = require('./RemoveElementMixin');
module.exports = {

    mixins: [removeElementMixin],

    props: {
        // The default submit action of the form.
        // See computed property: 'submitAction'
        action: {
            type: String,
            required: true
        },

        // The method to use for the submit.
        // See computed property: 'submitMethod'
        method: {
            type: String,
            required: true
        },

        // States if a confirm message shall be shown before the form is going to be submitted.
        // Note: There will always be a confirm message, if the method is set to 'delete'.
        // See computed property: 'showConfirm'
        confirm: {
            type: Boolean,
            default: false
        },

        // States if an alert message shall be shown after the request from the server has been received.
        // Note: There will always be an alert if an error occurred, no matter how this property is set.
        // To prevent an error alert set the 'alertError' property to false.
        // See computed property: 'showAlert'
        alert: {
            type: Boolean,
            default: true
        },

        // States if an error alert message shall be shown when the server responds with an error.
        alertError: {
            type: Boolean,
            default: true
        },

        // The lang key to identify the messages to show to the user on an alert or on a confirm alert.
        alertKey: {
            type: String,
            default: 'default'
        },

        // The name of the object this request is made for. Used for delete and update confirms.
        objectName: {
            type: String
        },

        // The type of the confirm alert to use when a confirm shall be shown.
        confirmType: {
            type: String,
            default: 'warning'
        },

        // The duration of the alert, that will be shown after the form has been submitted.
        alertDuration: {
            type: Number,
            default: 3000
        },

        // The suffix of the event names to call after the form has been submitted.
        callbackName: {
            type: String,
            default: 'ajaxForm'
        },

        // States if the form's inputs shall be cleared after the submit.
        clear: {
            type: Boolean,
            default: false
        },

        // States if the form's inputs shall be reset after the submit.
        reset: {
            type: Boolean,
            default: false
        },

        // The selector of the wrapper, where to append the response to.
        appendResponse: {
            type: String
        },

        // The selector of the wrapper, where to prepend the response to.
        prependResponse: {
            type: String
        },

        // The selector of the element, to replace with the response.
        replaceResponse: {
            type: String
        },

        // The link to redirect the user after the form was successfully submitted.
        // If this property is not set, no redirect will occur.
        redirect: {
            type: String
        },

        // If the form is used to create a new entity, this property is used to extract the route key of the created entity
        // and append it on the updateAction property, so a full update url for the entity will be created and the future
        // submit can successfully be treated as an update for the entity.
        objectKey: {
            type: String,
            default: 'id'
        },

        // The link to the details page of the created or edited entity to redirect the user after the form was successfully submitted.
        // If this property is not set, no redirect will occur.
        // Important: Because the key of the entity isn't known before its creation, set the objectKey property to the route key
        // of the entities model, so the key can be extracted from the response and the full update url for the entity can be created.
        detailRedirect: {
            type: String
        },

        // The html content (loader) to put in the submit button, while the form is submitting.
        loader: {
            type: String,
            default: '<i class="fa fa-fw fa-circle-o-notch fa-spin"></i>'
        },

        // The selector of the wrapper where to insert general error response messages from the server.
        // Error messages with the key of the data 'generalErrorKey' will be treated as general.
        errorWrapper: {
            type: String
        }
    },

    computed: {

        // The submit button of the form. Used to show a loader as soon as the submit request is pending.
        submitButton: function () {
            return $(this.$el).find('button[type=submit]');
        },

        // The reset button of the form. Used to reset the form.
        resetButton: function () {
            return $(this.$el).find('button[type=reset]');
        },

        // The title of the alert to show after the request from the server has been received.
        // Will be determined by the 'alertKey' property and the method of the next submit.
        // Will only be of used if the 'alert' property is set to true.
        alertTitle: function () {
            return this.getLocalizedAlertMessage('alert', 'title');
        },

        // The message of the alert to show after the request from the server has been received.
        // Will be determined by the 'alertKey' property and the method of the next submit.
        // Will only be of used if the 'alert' property is set to true.
        alertMessage: function () {
            if ((this.submitMethod === 'delete' || this.submitMethod === 'put')
                && this.objectName) {
                return this.getLocalizedAlertMessage('alert', 'content', {name: this.objectName});
            }

            return this.getLocalizedAlertMessage('alert', 'content');
        },

        // The title of the confirm alert to ask the user, if he really wants to submit the form.
        // Will be determined by the 'alertKey' property and the method of the next submit.
        // Will only be of used if the 'confirm' property is set to true.
        confirmTitle: function () {
            return this.getLocalizedAlertMessage('confirm', 'title');
        },

        // The message of the confirm alert to ask the user, if he really wants to submit the form.
        // Will be determined by the 'alertKey' property and the method of the next submit.
        // Will only be of used if the 'confirm' property is set to true.
        confirmMessage: function () {
            if ((this.submitMethod === 'delete' || this.submitMethod === 'put')
                && this.objectName) {
                return this.getLocalizedAlertMessage('confirm', 'content', {name: this.objectName});
            }

            return this.getLocalizedAlertMessage('confirm', 'content');
        },

        // The text of the confirm alert's ACCEPT button to ask the user, if he really wants to submit the form.
        // Will be determined by the 'alertKey' property and the method of the next submit.
        // Will only be of used if the 'confirm' property is set to true.
        confirmAccept: function () {
            return this.getLocalizedAlertMessage('confirm', 'accept');
        },

        // The text of the confirm alert's CANCEL button to ask the user, if he really wants to submit the form.
        // Will be determined by the 'alertKey' property and the method of the next submit.
        // Will only be of used if the 'confirm' property is set to true.
        confirmCancel: function () {
            return this.getLocalizedAlertMessage('confirm', 'cancel');
        },

        // States if a confirm message shall be shown before the submit.
        // Note: A confirm message will always be shown, if the method is set to 'delete'.
        showConfirm: function () {
            if (!this.confirm && this.submitMethod === 'delete') {
                return true;
            }
            return this.confirm;
        },

        // States if an alert message shall be shown after the submit.
        showAlert: function () {
            return this.alert;
        },
    },


    data() {
        return {

            // The url, where to send the form request.
            submitAction: this.action,

            // The method to use for the submit.
            submitMethod: this.method.toLowerCase(),

            // The content of the submit button to insert, after the form has been submitted and the loader has stopped.
            submitButtonContent: '',

            // The form instance containing the data to send.
            form: new Form(),

            // The child input components of the form.
            inputs: [],

            // The errors of the form inputs.
            errors: {},

            // States if any error exists on the form.
            hasError: false,

            // The key of a general error message from the server, that does not belong to a specific input.
            generalErrorKey: 'msg'
        }

    },

    watch: {

        /**
         * Watches the submit permission of the form, to enable or disable the submit button.
         *
         * @param hasError {@code true} if an error exists and a submit is not allowed, {@code false} otherwise.
         */
        hasError: function (hasError) {
            this.submitButton.prop('disabled', hasError);
        },
    },

    mounted: function () {
        this.$nextTick(function () {

            // Initializes the form inputs.
            this.initializeValues();

            // Save the content of the submit button to insert the original content of the button after the form has
            // been submitted and the loader has stopped.
            if (this.submitButton.length) {
                this.submitButtonContent = this.submitButton.html();
            }

            // Setup the listener for the reset button to reset the form on click.
            if (this.resetButton.length) {
                this.resetButton.on('click', (event) => {
                    event.preventDefault();
                    this.resetInputs();
                    this.submit();
                })
            }

            // Listen to child events
            window.eventHub.$on('input-value-changed', (name, value) => {

                // Check if the input is part of this form
                if ($(this.$el).find('[name=' + name + ']').length) {
                    this.form.set(name, value);

                    // Delete the general error
                    this.removeError(this.generalErrorKey);
                    $(this.errorWrapper).html('');
                }
            });
            window.eventHub.$on('input-error-changed', (name, error) => {

                // Check if the input is part of this form
                if (this.form.has(name)) {
                    this.setError(name, error);
                }
            });
        })
    },

    methods: {

        /**
         * Initializes the input values in the form object.
         */
        initializeValues: function () {
            getListOfChildren(this).forEach((child) => {
                if (child.submitName && child.hasOwnProperty('submitValue')) {
                    this.form.set(child.submitName, child.submitValue);
                    this.inputs.push(child);
                }
            });
        },

        /**
         * Adds a new input to the form.
         *
         * @param inputComponent
         */
        addInput: function (inputComponent) {
            if (inputComponent.name && inputComponent.submitValue) {
                this.form.set(inputComponent.name, inputComponent.submitValue);
                this.inputs.push(inputComponent);
            }
        },

        /**
         * Starts the form submitting process.
         */
        submit: function () {

            if (this.hasError) {
                window.eventHub.$emit('prevented_' + this.callbackName, this);
                return;
            }

            // Let the user confirm his submit action, if a confirm shall be shown.
            if (this.showConfirm) {
                showConfirm(
                    this.confirmType,
                    this.confirmTitle,
                    this.confirmMessage,
                    () => {
                        this.startLoader();
                        this.sendData();
                    },
                    null,
                    this.confirmAccept,
                    this.confirmCancel
                );
            } else {
                this.startLoader();
                this.sendData();
            }
        },

        /**
         * Shows the loader, if a loader shall be shown.
         */
        startLoader: function () {
            if (this.submitButton) {
                this.submitButtonContent = this.submitButton.html();
                this.submitButton.html(this.loader);
                this.submitButton.prop('disabled', true);
            }
        },

        /**
         * Stops the loader, if a loader is shown.
         */
        stopLoader: function () {
            if (this.submitButton) {
                this.submitButton.html(this.submitButtonContent);
                this.submitButton.prop('disabled', false);
            }
        },

        /**
         * Sends the data of the form to the server.
         */
        sendData: function () {

            // Let the parent chain know, that the submit will be processed.
            window.eventHub.$emit('submitting_' + this.callbackName, this);

            this.form.submit(this.submitMethod, this.submitAction)
                .then(response => {
                    this.handleResponse(true, response);
                })
                .catch(error => {
                    this.handleResponse(false, error);
                });
        },

        /**
         * Adds the specified error to the specified field. The field can be an object with error messages
         * to merge to the current error messages.
         *
         * @param field
         * @param error
         */
        setError: function (field, error) {
            if (typeof field === 'object') {
                Object.assign(this.errors, field);
                this.hasError = true;
            }else if (error === null) {
                this.removeError(field);
            } else {
                this.errors[field] = error;
                this.hasError = true;
            }
        },

        /**
         * Removes the error on the specified field.
         *
         * @param field
         */
        removeError: function (field) {
            delete this.errors[field];
            this.hasError = Object.keys(this.errors).length !== 0;
        },

        /**
         * Handles the response from the server after the form has been submitted.
         *
         * @param success {@code true} if the submit was successful, {@code false} otherwise.
         * @param response The response from the server.
         */
        handleResponse: function (success, response) {

            // Check the success type, show the corresponding alerts and call the corresponding callback methods.
            if (!success) {
                this.handleError(response);
            } else {

                if (this.showAlert) {
                    showAlert('success', this.alertTitle, this.alertMessage, this.alertDuration, () => {
                        this.handleSuccess(response);
                    });
                } else {
                    this.handleSuccess(response);
                }
            }

            // Stop the loader if an error occurred or if no redirect shall occur.
            if (!this.redirect || !success) {
                this.stopLoader();
            }

            // Call the callback to handle the after submit action directly on the page.
            // The callback has 4 parameters (+ the callback name):
            // - callbackName: The name of the event to listen to for the callback.
            // - success: {@code true} if the request was successful handled on the server, {@code false} otherwise.
            // - response: The response message retrieved from the server.
            // - method: The method that was used to proceed the request.
            // - component: The current instance of this component (useful to extract the form with 'component.$el'
            setTimeout(() => {
                // noinspection JSUnresolvedFunction
                window.eventHub.$emit('response_' + this.callbackName, success, response, this.submitMethod, this);
            }, (this.alertError && !success) || this.showAlert ? this.alertDuration : 0);
        },

        /**
         * Handles an error response from the server.
         *
         * @param response The response from the server.
         */
        handleError: function (response) {
            this.setError(response);

            // Notify the child inputs of the errors
            window.eventHub.$emit('form-errors-changed', response);

            // Set the general error
            if (this.errorWrapper && response.hasOwnProperty('msg')) {
                $(this.errorWrapper).html(response[this.generalErrorKey][0]);
            }

            this.showErrorAlert();
            this.onError(response);
        },

        /**
         * Handles the successful response from the server.
         *
         * @param response The response from the server.
         */
        handleSuccess: function (response) {
            if (this.submitMethod === 'get') {
                updateHrefParamsWithData(this.form.getSubmitData());
            }

            if (this.appendResponse) {
                appendData(this.appendResponse, response);
            }

            if (this.prependResponse) {
                prependData(this.prependResponse, response);
            }

            if (this.replaceResponse) {
                replaceData(this.replaceResponse, response);
            }

            // Clear the form inputs
            if (this.clear) {
                this.clearInputs();
            }

            // Reset the form inputs
            if (this.reset) {
                this.resetInputs();
            }

            this.removeElement();

            this.redirectUser(response);
            this.onSuccess(response);
        },

        /**
         * Redirects the user if a basic redirect or
         * a redirect to the details page of the created or edited object shall occur.
         */
        redirectUser: function (response) {
            let redirectURL = this.detailRedirect;
            if (redirectURL) {

                // Get the created key for the entity
                if (this.objectKey) {
                    let objectKey = response[this.objectKey];
                    if (!redirectURL.endsWith(objectKey)) {
                        if (!redirectURL.endsWith('/')) {
                            redirectURL += '/';
                        }
                        redirectURL += objectKey;
                    }
                }

                window.location.href = redirectURL;
            } else if (this.redirect) {
                window.location.href = this.redirect;
            }
        },

        /**
         * Shows an error message to the user after the form has been submitted and an error occurred on the server.
         */
        showErrorAlert: function () {

            // Check if an error message shall be shown to the user.
            if (this.alertError) {
                let msg = this.errors['msg'];

                // If no general error was found, just alert the first random one
                if (!msg) {
                    msg = this.errors[Object.keys(this.errors)[0]];
                }

                if (!msg) {
                    msg = this.getLocalizedAlertMessage('error', 'content', {name: this.objectName})
                }

                showAlert('error', this.getLocalizedAlertMessage('error','title', {name: this.objectName}), msg, this.alertDuration);
            }
        },

        /**
         * Clears the values of the form.
         */
        clearInputs: function () {
            this.inputs.forEach((child) => {
                if (typeof child.clear === 'function') {
                    child.clear();
                }
            });
            if (this.submitMethod === 'get') {
                updateHrefParamsWithData(this.form.getSubmitData());
            }
        },

        /**
         * Resets the values of the form.
         */
        resetInputs: function () {
            this.inputs.forEach((child) => {
                if (typeof child.reset === 'function') {
                    child.reset();
                }
            });
            if (this.submitMethod === 'get') {
                updateHrefParamsWithData(this.form.getSubmitData());
            }
        },

        /**
         * Gets the localization string for an alert type and a type and falls back to the default if necessary.
         *
         * @param alertType 'alert', 'error' or 'confirm'
         * @param type 'title', 'content', 'cancel' or 'accept'
         * @param params localization params
         * @returns {string}
         */
        getLocalizedAlertMessage: function (alertType, type, params = null) {
            let key = alertType + '.' + this.alertKey + '.' + this.submitMethod + '.' + type;
            let defaultKey = alertType + '.default.' + this.submitMethod + '.' + type;
            let text = this.$t(key, params);
            if (key === text) {
                text = this.$t(defaultKey, params);
            }

            return text;
        },

        /**
         * Will be called if the form was successfully submitted.
         *
         * @param response The response from the server.
         */
        onSuccess: function (response) {
        },

        /**
         * Will be called if an error occurred on the form submit.
         *
         * @param response The response from the server.
         */
        onError: function (response) {
        },
    }
};

