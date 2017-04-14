let formInputMixin = require('./FormInputMixin');
module.exports = {

    mixins: [formInputMixin],

    props: {
        // The predefined value of the checkbox.
        value: {
            type: Boolean,
            default: false
        },
    },

    data: function () {
        return {

            // The value which will be submitted.
            submitValue: this.value ? 1 : 0,
        }
    },

    watch: {

        submitValue: function (value) {
            if (value === true) {
                this.submitValue = 1;
            } else if (value === false) {
                this.submitValue = 0;
            }
            this.inputChanged();
        }
    },

    methods: {
        /**
         * Toggles the submit value.
         */
        toggleValue: function () {
            this.submitValue = !this.submitValue;
        },
    }

};

