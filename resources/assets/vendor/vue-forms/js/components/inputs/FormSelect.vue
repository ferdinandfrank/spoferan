<template>
    <div class="form-input" ref="inputWrapper" :class="{ 'has-error': hasError, 'has-success': hasSuccess, 'has-addon-left': iconLeft, 'has-addon-right': showHelp || submitIcon || iconRight }">
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

        <div v-if="iconLeft" class="icon icon-left">
            <icon :icon="iconLeft"></icon>
        </div>

        <div v-if="iconRight && !submitIcon" class="icon icon-right">
            <icon :icon="iconRight"></icon>
        </div>

        <button type="submit" v-if="submitIcon" class="icon icon-right"
                :style="{cursor: hasSuccess ? 'pointer' : 'not-allowed'}">
            <icon :icon="submitIcon"></icon>
        </button>

        <div v-if="showHelp" class="help icon icon-right">
            <div v-if="helpTooltip" class="tooltip tooltip-left">
                <icon icon="fa fa-fw fa-question"></icon>
                <span class="tooltip-text">{{ helpTooltip }}</span>
            </div>
            <icon v-if="helpPath" @click="openHelp()" icon="fa fa-fw fa-question"></icon>
        </div>
        <span class="info" v-if="hasError">{{ errorMessage }}</span>
        <span class="info" v-if="hasSuccess">{{ successMessage }}</span>

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

        watch: {

            /**
             * Updated the selected value when the submit value gets changed.
             *
             * @param value The new value.
             */
            value: function (value) {
                this.input.select2().select2('val', value);
            }
        },

        mounted() {
            this.$nextTick(function () {
                this.input = $(this.$refs.input);

                this.input.select2();

                if (this.value !== null) {
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
                    this.inputChanged();
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
                this.input.select2().select2('val', this.value);
                this.inputChanged();
            },

            /**
             * Clears the input's value.
             */
            clear: function () {
                this.submitValue = null;
                this.input.select2().select2('val', null);
                this.inputChanged();
            },
        }
    }
</script>
