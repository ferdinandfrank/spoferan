<template>
    <div class="radio-wrapper" ref="inputWrapper" :class="{ 'has-error': invalid && !valid, 'has-success': valid && submitValue }" >
        <input :id="name + '-' + value + '-input'"
               type="radio"
               ref="input"
               :value="submitValue"
               :name="submitName"
               :checked="checked"
        />
        <label :for="name + '-' + value + '-input'" v-if="showLabel" ref="inputLabel" :data-message="labelMessage">
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
            submitValue: function (val) {
                val = $('input[name=' + this.submitName + ']:checked').val();
                this.setValueOnForm(val);
            },

            value: function (val) {
                this.submitValue = val;
            }
        },

        mounted: function () {
            this.$nextTick(function () {
                $(this.$refs.input).on('change', () => {
                    let val = $('input[name=' + this.submitName + ']:checked').val();
                    window.eventHub.$emit(this.name + '-input-changed', val);
                    this.setValueOnForm(val);
                });
            })
        },
    }

</script>
