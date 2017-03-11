<template>
    <form :action="submitAction" :method="submitMethod" @submit.prevent="openStripe">
        <slot></slot>
    </form>
</template>

<script>
    import extendedAjaxFormMixin from '../../vendor/vue-forms/js/mixins/ExtendedAjaxFormMixin';

    export default {
        mixins: [extendedAjaxFormMixin],

        props: {
            action: {
                type: String,
                required: true
            },
            method: {
                type: String,
                required: true,
                default: "POST"
            },
            stripe: {
                type: Object,
                default: function () {
                    return {
                        name: 'Event',
                        description: null,
                        amount: 0
                    }
                }
            },
            directSubmit: {
                type: Boolean,
                default: false
            }
        },

        data() {
            return {
                stripeHandler: null,
                stripeData: this.stripe
            }
        },

        mounted() {
            this.$nextTick(function () {
                if (!this.directSubmit) {
                    this.stripeHandler = StripeCheckout.configure({
                        key: Laravel.stripeKey,
                        email: Laravel.user.email,
                        image: this.stripeData.image,
                        locale: "auto",
                        token: (token) => {
                        this.form['stripeToken'] = token.id;
                    this.form['stripeEmail'] = token.email;

                    this.submit();
                }
                })
                }
            });
        },

        methods: {
            openStripe: function () {
                if (!this.directSubmit) {
                    this.stripeHandler.open({
                        name: this.stripeData.name,
                        description: this.stripeData.description,
                        image: this.stripeData.image,
                        zipCode: true,
                        amount: this.stripeData.amount
                    });
                } else {
                    this.submit();
                }
            }
        }
    }
</script>