<template>
    <input :id="name + '-input'"
           type="hidden"
           :name="name"
           v-model="submitValue"
           :disabled="disabled"
           ref="input">
</template>

<script>
    import formInputMixin from '../../mixins/FormInputMixin';
    export default{
        mixins: [formInputMixin],

        watch: {

            value: function (value) {
                this.submitValue = value;
            },

            submitValue: function (value, oldValue) {
                this.inputChanged();
                this.valueChanged = value !== oldValue;
            }
        },
    }
</script>
