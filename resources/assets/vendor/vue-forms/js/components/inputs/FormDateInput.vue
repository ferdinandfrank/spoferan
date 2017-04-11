<template>
    <div class="form-input" ref="inputWrapper" :class="{ 'has-error': hasError, 'has-success': hasSuccess, 'has-addon-left': iconLeft, 'has-addon-right': showHelp || submitIcon || iconRight }">
        <input :id="name + '-input'"
               type="text"
               :name="submitName"
               class="datetimepicker"
               :placeholder="showLabel ? label : ''"
               :disabled="disabled"
               ref="input"
               @focus="activate"
               @blur="deactivate">

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
    import datePickerMixin from '../../mixins/DatePickerMixin';
    export default{
        mixins: [formInputMixin, datePickerMixin],

        mounted: function () {
            this.$nextTick(function () {
                $(this.$refs.input).datetimepicker({
                    locale: 'de',
                    format: 'DD.MM.YYYY',
                    defaultDate: this.submitValue
                });
                $(this.$refs.input).on("dp.change", (moment) => {
                    this.submitValue = moment.date.format("YYYY-MM-DD");
                    this.inputChanged();
                });
            })
        },
    }
</script>
