<template>
    <div class="message-box" :class="type ? 'is-' + type : ''">
        <div v-if="title" class="message-box-header">
            <p>{{ title }}</p>
            <button class="delete" @click="removeElement"></button>
        </div>
        <div class="message-box-content">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    import removeElementMixin from '../../vendor/vue-forms/js/mixins/RemoveElementMixin';

    export default{

        mixins: [removeElementMixin],

        props: {

            // The title of the message box. No header will be shown if no title is set.
            title: {
                type: String
            },

            // The type of the message box.
            // Valid values: 'success', 'danger', 'warning', 'primary', 'secondary'
            type: {
                type: String
            }
        },

        mounted() {
            this.$nextTick(function () {
                this.removeSelector = this.remove ? this.remove : this.$el;
            });
        },
    }
</script>