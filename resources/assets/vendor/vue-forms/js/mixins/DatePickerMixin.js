module.exports = {
    props: {
        // The value of the date picker.
        // See property 'submitDate'.
        date: {
            type: String,
            default: ''
        },

        // The minimum date to select.
        minDate: {
            type: String,
        },

        // The maximum date to select.
        maxDate: {
            type: String,
        },

        // The range of the date picker, i.e. which dates can be selected.
        // Valid values: 'all', 'past' (Before today), 'future' (After today)
        range: {
            type: String,
            default: 'all'
        }
    },


    data: function () {
        return {

            // The format of the date
            format: 'DD.MM.YYYY'
        }
    },

    methods: {
        /**
         * Resets the value of the input.
         */
        reset: function () {
            this.submitValue = this.value;
            $(this.$refs.input).val(this.value);
            this.inputChanged();
        },

        /**
         * Clears the value of the input.
         */
        clear: function () {
            this.submitValue = '';
            $(this.$refs.input).val('');
            this.inputChanged();
        },
    }
};

