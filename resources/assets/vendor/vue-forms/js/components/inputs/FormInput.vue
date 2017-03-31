<template>
    <div class="form-input" ref="inputWrapper" :class="{ 'has-error': hasError, 'has-success': hasSuccess, 'has-addon-left': icon, 'has-addon-right': showHelp }">
        <input :id="name + '-input'"
               type="text"
               :name="name"
               v-model="submitValue"
               :placeholder="label"
               :step="step"
               :disabled="disabled"
               ref="input"
               @focus="activate"
               @blur="deactivate"
               :title="label">

        <button type="submit" v-if="icon && addonSubmit" class="form-group-addon" :style="{cursor: valid ? 'pointer' : 'not-allowed'}">
            <icon :icon="icon"></icon>
        </button>

        <div v-if="icon && !addonSubmit" class="icon">
            <icon :icon="icon"></icon>
        </div>

        <div v-if="showHelp" class="help">
            <div v-if="helpTooltip" class="tooltip tooltip-left">
                <icon icon="fa fa-fw fa-question"></icon>
                <span class="tooltip-text">{{ helpTooltip }}</span>
            </div>
            <icon v-if="helpPath" @click="openHelp()" icon="fa fa-fw fa-question"></icon>
        </div>

        <span class="info" v-if="labelMessage">{{ labelMessage }}</span>

        <span class="counter" :class="submitValue.length > maxLength ? 'error' : 'success'" v-if="showMaxLengthCounter">
            {{ submitValue.length + '/' + maxLength }}
        </span>
        <span class="counter" :class="submitValue.length < minLength ? 'error' : 'success'" v-if="showMinLengthCounter">
            {{ submitValue.length + '/' + minLength }}
        </span>
    </div>
</template>

<script>
    import formInputMixin from '../../mixins/TextFormInputMixin';
    export default{
        mixins: [formInputMixin],
        props: {

            // The type of the input field.
            type: {
                type: String,
                default: 'text'
            },

            // The step to increase the value if the input's type is set to "number".
            step: ''
        },

        mounted() {
            this.$nextTick(function () {

                // Necessary, because of setting the type directly is not possible with vue.
                $(this.$refs.input).attr('type', this.type);
            })
        },

        methods: {

            /**
             * Checks if the input's value is valid regarding the property 'type'.
             *
             * @returns {boolean}
             */
            checkComponentSpecific: function () {
                if (this.type == 'email' && !isValidEmail(this.submitValue)) {
                    this.addError(this.getLocalizationString('email', {'attribute': this.name}, true));
                    return false;
                }
                return true;
            }
        }
    }
</script>
