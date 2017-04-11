<template>
    <div class="radio-wrapper" ref="inputWrapper" :class="{ 'has-error': hasError, 'has-success': hasSuccess }" >
        <input :id="name + '-' + value + '-input'"
               type="radio"
               ref="input"
               :value="value"
               v-model="submitValue"
               :name="name"
               :checked="checked"
        />
        <label :for="name + '-' + value + '-input'" v-if="showLabel" ref="inputLabel">
            <slot></slot>
            <span v-if="showHelp" class="tooltip">
                <i @click="openHelp" class="fa fa-fw fa-question help"></i>
                <span v-if="helpTooltip" class="tooltip-text">{{ helpTooltip }}</span>
            </span>
        </label>
    </div>
</template>

<script>
    import formInputMixin from '../../mixins/FormInputMixin';
    export default{
        mixins: [formInputMixin],

        props: {
            // States if the radio input is checked / selected.
            checked: {
                type: Boolean,
                default: false
            },
        },

        watch: {

        },

        mounted: function () {
            this.$nextTick(function () {
                this.updateValue();
                $(this.$refs.input).on('change', () => {
                    this.updateValue();
                });
            })
        },

        methods: {

            updateValue: function () {
                let checkedRadio = $('input[name=' + this.submitName + ']:checked');
                if (checkedRadio.length) {
                    this.submitValue = checkedRadio.val();
                    this.inputChanged();
                }

            },
        }
    }

</script>
