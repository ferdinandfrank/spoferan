module.exports = {

    props: {

        // The name of the input. Will also be the name of the value, when the form gets submitted.
        // See data: 'submitName'
        name: {
            type: String,
            required: true
        },

        // The predefined value of the input.
        // See data: 'submitValue'
        value: {
            default: ''
        },

        // The language key of the label.
        // See computed data: 'label'.
        langKey: {
            type: String
        },

        // True, if the input shall be disabled.
        disabled: {
            type: Boolean,
            default: false
        },

        // True if a label shall be shown for the input.
        showLabel: {
            type: Boolean,
            default: true
        },

        // States if the errors does not matter for a form submit. An error message will be shown, but the form
        // won't be prevented to submit.
        ignoreErrors: {
            type: Boolean,
            default: false
        },

        // Function to check if the input is valid. If it is invalid an error message,
        // based upon the property 'name' and 'langKey' will be shown to the user.
        // The function receives the current value of the input as first parameter
        // and a callback function as the second. This callback must return true,
        // if the input is valid and false otherwise.
        check: {
            type: Function
        },

        // States if a value on the input is required.
        required: {
            type: Boolean,
            default: false
        },

        // The path of the page to send the user if he clicks the help icon on the input.
        // No icon will be shown if this property and the property 'helpTooltip' isn't set.
        helpPath: {
            type: String
        },

        // The icon to show as the input's help.
        // No icon will be shown if the property 'helpPath' and the property 'helpTooltip' isn't set.
        helpIcon: {
            type: String,
            default: 'fa fa-fw fa-question'
        },

        // The tooltip to show if the user hovers over the help icon.
        // No icon will be shown if this property and the property 'helpPath' isn't set.
        helpTooltip: {
            type: String
        },

    },

    data: function () {
        return {

            // States if a help icon shall be displayed for the input.
            showHelp: this.helpPath || this.helpTooltip ? true : false,

            // The value which will be submitted.
            submitValue: this.value,

            // The error message to show for the input.
            errorMessage: null,

            // The success message to show for the input.
            successMessage: null,

            // States if the user edited the input
            valueChanged: false
        }
    },

    computed: {

        // The label text of the input, based upon the property 'name' or the property 'langKey', if it is set.
        label: function () {
            let langKey = this.name;
            if (this.langKey) {
                langKey = this.langKey + '.' + this.name;
            }
            langKey = 'input.' + langKey;
            let label = this.$t(langKey);

            if (label === langKey) {
                label = titleCase(this.name);
            }

            return label;
        },

        // States if the current input value is invalid.
        hasError: function () {
            return this.errorMessage && this.valueChanged;
        },

        // States if the current input value is valid.
        hasSuccess: function () {
            return !this.errorMessage && (this.valueChanged || !this.required);
        },

        // The name of the input. Will also be the name of the value, when the form gets submitted.
        submitName: function () {
            return this.name;
        }
    },

    mounted: function () {
        this.$nextTick(function () {
            this.checkInput();
            window.eventHub.$on('form-errors-changed', (errors) => {
                if (errors.hasOwnProperty(this.submitName)) {
                    if (errors[this.submitName] instanceof Object || errors[this.submitName] instanceof Array) {
                        this.errorMessage = errors[this.submitName][0];
                    } else {
                        this.errorMessage = errors[this.submitName];
                    }
                }
            });
        })
    },

    watch: {

        /**
         * Notifies the parent chain if the error message of the input changed.
         *
         * @param error The new error message.
         */
        errorMessage: function (error) {
            if (!this.ignoreErrors) {
                window.eventHub.$emit('input-error-changed', this.submitName, error);
            }
        },

        /**
         * Updated the submit value when the value prop gets changed.
         *
         * @param value The new value.
         */
        value: function (value) {
            this.submitValue = value;
            this.inputChanged();
        }
    },

    methods: {

        /**
         * Notifies the parent chain that the value of the input changed.
         */
        inputChanged: function () {
            this.valueChanged = this.submitValue !== this.value;
            window.eventHub.$emit('input-value-changed', this.submitName, this.submitValue);
            this.$emit('input', this.submitValue); // Necessary to update the data on the root instance
            this.checkInput();
        },

        /**
         * Activates the inputs editing style.
         */
        activate: function () {
            $(this.$refs.inputWrapper).addClass('active');
        },

        /**
         * Deactivates the inputs editing style.
         */
        deactivate: function () {
            $(this.$refs.inputWrapper).removeClass('active');
        },

        /**
         * Checks if the current value of the input is valid and
         * updates the input's label, based on the input's value.
         */
        checkInput: function () {
            if (this.checkRequired()
                && this.checkComponentSpecific()) {
                if (isFunction(this.check)) {
                    this.check(this.submitValue, (valid, errorMessage) => {
                        if (valid) {
                            this.errorMessage = null;
                        } else {
                            this.errorMessage = errorMessage;
                        }
                    });
                } else {
                    this.errorMessage = null;
                }
            }
        },

        /**
         * Checks if the input's value is valid regarding the property 'required'.
         * If not an error message will be shown on the input.
         *
         * @returns {boolean}
         */
        checkRequired: function () {
            if ((!this.submitValue || this.submitValue === '') && this.required) {
                this.errorMessage = this.getLocalizedErrorMessage('required', {'attribute': this.name});
                return false;
            }
            return true;
        },

        /**
         * Checks if the input's value is valid regarding the specific needs in an input component.
         *
         * @returns {boolean}
         */
        checkComponentSpecific: function () {
            return true;
        },

        /**
         * Opens the help page for the input.
         */
        openHelp: function () {
            if (this.helpPath) {
                window.open(this.helpPath, '_blank');
            }
        },

        /**
         * Resets the value of the input.
         */
        reset: function () {
            this.submitValue = this.value;
            this.inputChanged();
        },

        /**
         * Clears the value of the input.
         */
        clear: function () {
            this.submitValue = '';
            this.inputChanged();
        },

        /**
         * Gets the localized error message for the specified error type.
         *
         * @param type The error key.
         * @param props The additional props to insert in the error message.
         * @param plain States if the lang key of the input shall be used to build the error key.
         * @returns {string}
         */
        getLocalizedErrorMessage: function (type = null, props = null, plain = false) {
            let langKey = '';
            if (this.langKey && !plain) {
                langKey = this.langKey + '.';
            }

            let key = 'validation.' + langKey;
            let defaultKey = key;
            if (type) {
                key = 'validation.' + langKey + type;
                defaultKey = 'validation.' + type;
            }

            let text = this.$t(key, props);
            if (text === key) {
                text = this.$t(defaultKey, props);
            }

            return text;
        },
    }
};

