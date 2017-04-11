
let formInputMixin = require('./FormInputMixin');
module.exports = {
    mixins: [formInputMixin],

    props: {

        // The event, when the value of the input shall be validated and updated on the parent form.
        // Valid values: 'input', 'change'
        validateOn: {
            type: String,
            default: 'input'
        },

        // The minimum length of the input value.
        minLength: {
            type: Number
        },

        // The maximum length of the input value.
        maxLength: {
            type: Number
        },

        // States if the input shall be treated as a confirmation input and needs to have a corresponding input with the same value.
        // Ex.: If the name of this input is 'foo_confirmation', the input with the name 'foo' must have the same value.
        confirmed: {
            type: Boolean
        },

        // States if a placeholder shall be shown on the input.
        showPlaceholder: {
            type: Boolean,
            default: false
        },

        // The icon to show left to the input field.
        iconLeft: {
            type: String
        },

        // The icon to show right to the input field.
        iconRight: {
            type: String
        },

        // The icon to show next to the input field, which will be used to submit the parent form.
        // If no icon is set, the parent form can not be submitted through this input.
        submitIcon: {
            type: String
        },
    },

    computed: {

        // The placeholder text of the input, based upon the property 'name' or the property 'langKey', if it is set.
        placeholder: function () {
            let langKey = this.name;
            if (this.langKey) {
                langKey = this.langKey + '.' + this.name;
            }
            return this.$t('placeholder.' + langKey);
        },

        // The text to show to the user, if the confirmation input does not have the same value as this input.
        confirmedMessage: function () {
            let confirmNameLength = this.name.length - '_confirmation'.length;
            let confirmName = this.name.substring(0, confirmNameLength);
            return this.getLocalizedErrorMessage('confirmed', {'attribute': confirmName});
        },

        // States if the max length counter shall be shown on the input.
        showMaxLengthCounter: function () {
            return this.maxLength && !this.showMinLengthCounter;
        },

        // States if the min length counter shall be shown on the input.
        showMinLengthCounter: function () {
            return this.minLength && this.submitValue.length < this.minLength;
        },
    },

    methods: {

        /**
         * Checks if the current value of the input is valid and
         * updates the input's label, based on the input's value.
         */
        checkInput: function () {
            if (this.checkRequired()
                && this.checkComponentSpecific()
                && this.checkMinLength()
                && this.checkMaxLength()
                && this.checkConfirmed()) {
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
         * Checks if the input's value is valid regarding the property 'maxLength'.
         * If not an error message will be shown on the input.
         *
         * @returns {boolean}
         */
        checkMaxLength: function () {
            if (this.maxLength && this.submitValue.length > this.maxLength) {
                this.errorMessage = this.getLocalizedErrorMessage('max.string', {max: this.maxLength, 'attribute': this.name});
                return false;
            }
            return true;
        },

        /**
         * Checks if the input's value is valid regarding the property 'minLength'.
         * If not an error message will be shown on the input.
         *
         * @returns {boolean}
         */
        checkMinLength: function () {
            if (this.minLength && this.submitValue.length < this.minLength) {
                this.errorMessage = this.getLocalizedErrorMessage('min.string', {min: this.minLength, 'attribute': this.name});
                return false;
            }
            return true;
        },

        /**
         * Checks if the input's value is valid regarding the property 'confirmed'.
         * If not an error message will be shown on the input.
         *
         * @returns {boolean}
         */
        checkConfirmed: function () {
            if (this.confirmed) {
                let confirmNameLength = this.name.length - '_confirmation'.length;
                let confirmName = this.name.substring(0, confirmNameLength);
                let confirmInput = $(this.$refs.input).parents('form').first().find(':input[name=' + confirmName + ']').first();
                if (confirmInput.val() !== this.submitValue) {
                    this.errorMessage = this.confirmedMessage;
                    return false;
                }
            }
            return true;
        }
    }
};

