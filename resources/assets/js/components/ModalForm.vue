<template>
    <div class="modal">
        <div class="modal-background"></div>
        <form class="modal-content" :action="submitAction" :method="submitMethod" @submit.prevent="submit">
            <header class="modal-card-head">
                <p class="modal-card-title">{{ title }}</p>
                <button class="delete" @click="hide()"></button>
            </header>
            <section class="modal-card-body">
                <slot></slot>
            </section>
            <footer class="modal-card-foot">
                <button class="button" @click.prevent="hide()">{{ cancelText }}</button>
                <button type="submit" class="button is-success">
                    <span>
                        <span class="icon is-small">
                            <icon icon="fa fa-fw fa-plus"></icon>
                        </span>
                        <span>{{ saveText }}</span>
                    </span>
                </button>
            </footer>
        </form>
    </div>
</template>

<script>
    import extendedAjaxFormMixin from '../../vendor/vue-forms/js/mixins/ExtendedAjaxFormMixin';
    import modalMixin from './mixins/ModalMixin';

    export default {
        mixins: [extendedAjaxFormMixin, modalMixin]
    }
</script>