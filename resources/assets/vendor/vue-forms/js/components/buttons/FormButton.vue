<template>
    <button type="button" class="button" :class="[size ? 'is-' + size : '', color ? 'is-' + color : '']" @click="submit">
        <slot></slot>
    </button>
</template>

<script>

    import ajaxFormMixin from '../../mixins/AjaxFormMixin';
    import removeElementMixin from '../../mixins/RemoveElementMixin';

    export default {

        mixins: [ajaxFormMixin, removeElementMixin],

        props: {

            // The color class of the button.
            color: {
                type: String,
                default: 'error'
            },

            // The size class of the button.
            size: {
                type: String
            },

            // The method to use for the submit.
            // See computed property: 'submitMethod'
            method: {
                type: String,
                default: 'delete'
            },
        },

        computed: {

            // The submit button of the form. Used to show a loader as soon as the submit request is pending.
            submitButton: function () {
                return $(this.$el);
            },
        },

        methods: {

            /**
             * Will be called if the form has been successfully submitted.
             */
            onSuccess: function () {
                this.removeElement();
            }
        }
    }
</script>
#
