<template>
    <div class="wizard">
        <div class="navigation">
            <div class="navigation-item" v-for="(step, index) in steps"
                 :class="{'active': step.active, 'disabled': step.disabled, 'selected': step.selected}">
                <div class="navigation-item-content">
                    <h4 @click="setStep(index)" class="title">{{ index + 1}}. {{ step.title }}</h4>
                    <p v-if="step.selectedTitle" class="subtitle">{{ step.selectedTitle }}</p>
                    <i v-if="step.selected" class="fa fa-fw fa-check"></i>
                </div>
            </div>
        </div>
        <slot></slot>
        <div class="actions">
            <a @click="activeStep--" class="button" v-if="activeStep > 0">
                <span class="icon is-small">
                <i class="fa fa-fw fa-chevron-left"></i>
                </span>
                <span>{{ labels.prev }}</span>
            </a>
            <a @click="activeStep++" class="button is-success" v-if="activeStep < steps.length - 1">
                <span>{{ labels.next }}</span>
                <span class="icon is-small">
                    <i class="fa fa-fw fa-chevron-right"></i>
                </span>
            </a>
        </div>
    </div>
</template>

<script>
    export default{
        props: {
            step: {
                type: Number,
                default: 0
            },
        },

        data() {
            return {
                steps: [],
                activeStep: this.step,
                labels: {
                    prev: "Zurück",
                    next: "Weiter"
                }
            }
        },

        mounted: function () {
            this.$nextTick(function () {
                this.initSteps();
            })
        },

        watch: {
            activeStep: function (index, prevIndex) {
                this.hideSection(prevIndex);
                this.steps[prevIndex].active = false;
                this.steps[prevIndex].selected = true;

                this.showSection(index);
                this.steps[index].active = true;
                this.steps[index].disabled = false;
            },
        },

        methods: {
            initSteps: function () {
                $(this.$el).children('.wizard-section').each((index, section) => {
                    let title = null;
                    let titleWrapper = $(section).find('.wizard-title').first();
                    if (titleWrapper.length) {
                        title = titleWrapper.html();
                    }

                    let isActive = this.activeStep == index;
                    if (!isActive) {
                        $(section).hide();
                    }

                    this.steps.push({
                        index: index,
                        title: title,
                        active: isActive,
                        disabled: !isActive,
                        selected: false,
                        selectedTitle: null
                    });
                })
            },

            getSection: function (index) {
                return $(this.$el).children('.wizard-section').eq(index);
            },

            hideSection: function (index) {
                this.getSection(index).hide("slow");
            },

            showSection: function (index) {
                this.getSection(index).show("slow");
            },

            setStep: function (index) {
                if (!this.steps[index].disabled && !this.steps[index].active) {
                    this.activeStep = index;
                }
            }
        }
    }
</script>