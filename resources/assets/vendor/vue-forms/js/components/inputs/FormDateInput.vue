<template>
    <div class="form-input" ref="inputWrapper" :class="{ 'has-error': invalid && !valid, 'has-success': valid && submitValue, 'has-addon-left': icon, 'has-addon-right': showHelp }">
        <input :id="name + '-input'"
               type="text"
               :name="name"
               class="datetimepicker"
               :placeholder="label"
               :disabled="disabled"
               ref="input"
               @focus="activate"
               @blur="deactivate">

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
                });
            })
        },
    }
</script>
