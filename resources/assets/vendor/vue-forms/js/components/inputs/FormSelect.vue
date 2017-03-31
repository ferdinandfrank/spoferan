<template>
    <div class="form-input" ref="inputWrapper" :class="{ 'has-error': hasError, 'has-success': hasSuccess, 'has-addon-left': icon, 'has-addon-right': showHelp }">
        <select :id="name + '-input'"
                :name="submitName"
                @focus="activate"
                @blur="deactivate"
                ref="input"
                :disabled="disabled"
                :multiple="multiple"
                :title="label">
            <option value>{{ label }}</option>
            <slot></slot>
        </select>

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

    </div>
</template>

<script>
    import formInputMixin from '../../mixins/TextFormInputMixin';
    export default{
        mixins: [formInputMixin],
        props: {
            // True, if multiple values can be selected.
            multiple: {
                type: Boolean,
                default: false
            },

            // The predefined value of the input.
            // See data: 'submitValue'
            value: {
                type: Array|String|Number
            }
        },

        data: function () {
            return {
                input: '',
                hasChanged: false
            }
        },

        computed: {
            // The name of the input. Will also be the name of the value, when the form gets submitted.
            // Info: This value is based upon the 'name' property.
            submitName: function () {
                if (this.multiple) {
                    return this.name + '[]';
                }
                return this.name;
            },

            // States if a success layout shall be shown on the input.
            hasSuccess: function () {
                if (this.valid && this.submitValue && this.hasChanged) {
                    return typeof this.submitValue === 'string' || typeof this.submitValue === 'number' || this.submitValue.length > 0
                }
                return false;
            },

            // States if an error layout shall be shown on the input.
            hasError: function () {
                return this.invalid && !this.valid;
            },

            // The label text of the input, based upon the property 'name' or the property 'langKey', if it is set.
            label: function () {
                let langKey = this.name;
                if (this.langKey) {
                    langKey = this.langKey + '.' + this.name;
                }
                langKey = 'input.select.' + langKey;
                let label = this.$t(langKey);

                if (label === langKey) {
                    label = titleCase(this.name);
                }

                return label;
            },
        },

        mounted() {
            this.$nextTick(function () {
                this.input = $(this.$refs.input);

                this.input.select2();

                if (this.value != null) {
                    this.input.val(this.value);
                }

                if (!this.input.val()) {
                    this.input.val(this.input.find('option:first-child').val());
                    $(this.$el).find('.select2-chosen').addClass('label');
                }

                this.submitValue = this.input.val();

                this.input.trigger('change');

                this.input.on("change", () => {
                    this.submitValue = this.input.val();
                    this.hasChanged = true;
                    if (this.submitValue === '') {
                        $(this.$el).find('.select2-chosen').addClass('label');
                    } else {
                        $(this.$el).find('.select2-chosen').removeClass('label');
                    }
                });
            });
        },

        methods: {
            /**
             * Resets the input's value.
             */
            reset: function () {
                this.submitValue = this.value;
                this.input.select2().select2('val',this.value);
                this.labelMessage = null;
                this.invalid = false;
                this.valid = !this.required || this.value;
            },

            /**
             * Clears the input's value.
             */
            clear: function () {
                this.submitValue = null;
                this.input.select2().select2('val',null);
                this.labelMessage = null;
                this.invalid = false;
                this.valid = !this.required;
            },
        }
    }
</script>
