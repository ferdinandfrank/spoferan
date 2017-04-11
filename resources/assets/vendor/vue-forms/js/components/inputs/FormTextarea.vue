<template>
    <div class="form-group" ref="inputWrapper" :class="{ 'has-error': hasError, 'has-success': hasSuccess, 'has-addon-left': iconLeft, 'has-addon-right': showHelp || submitIcon || iconRight }">
        <textarea :id="name + '-input'"
                  :name="name"
                  v-model="submitValue"
                  class="form-control"
                  :class="icon ? 'has-addon' : ''"
                  :disabled="disabled"
                  :placeholder="showPlaceholder ? placeholder : ''"
                  ref="input"
                  @input="validateOn == 'input' ? inputChanged() : ''"
                  @change="validateOn == 'change' ? inputChanged() : ''"
                  @focus="activate"
                  @blur="deactivate"></textarea>

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
    }

</script>
