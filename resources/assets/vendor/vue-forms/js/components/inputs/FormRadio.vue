<template>
    <div class="radio-wrapper" ref="inputWrapper" :class="{ 'has-error': invalid && !valid, 'has-success': valid && submitValue }" >
        <input :id="name + '-' + value + '-input'"
               type="radio"
               ref="input"
               :value="value"
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
                }

            },
        }
    }

</script>
