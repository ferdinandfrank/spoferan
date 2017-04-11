<template>
    <form :action="submitAction" :method="submitMethod" @submit.prevent="submit">
        <slot></slot>
    </form>
</template>

<script>
    import ajaxFormMixin from '../mixins/AjaxFormMixin';

    export default {
        mixins: [ajaxFormMixin]
    }

</script>
