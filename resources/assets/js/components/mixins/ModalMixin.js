module.exports = {
    props: {
        title: {
            type: String
        },
        labels: {
            type: Object,
            default: function () {
                return {
                    save: '',
                    cancel: ''
                };
            }
        },
    },

    computed: {
        saveText: function () {
            return this.labels.save ? this.labels.save : this.$t('action.save');
        },
        cancelText: function () {
            return this.labels.cancel ? this.labels.cancel : this.$t('action.cancel');
        },
    },

    methods: {
        show: function () {
            $(this.$el).addClass('is-active');
        },

        hide: function () {
            $(this.$el).removeClass('is-active');
        },
    }
};

