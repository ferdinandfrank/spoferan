<template>
    <div class="wizard">
        <div class="navigation">
            <div class="navigation-item" v-for="(step, index) in steps"
                 :class="{'active': step.active, 'disabled': step.disabled, 'selected': step.selected}">
                <div class="navigation-item-content">
                    <h4 @click="setStep(index)" class="title">
                        <i v-if="step.selected && !step.active" class="fa fa-fw fa-check-circle-o"></i>
                        <i v-if="step.active" class="fa fa-fw fa-user-circle"></i>
                        <i v-if="!step.selected && !step.active" class="fa fa-fw fa-circle-o"></i>
                        {{ index + 1}}. {{ step.title }}
                    </h4>
                    <p v-if="step.selectedTitle" class="subtitle">{{ step.selectedTitle }}</p>
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
            <a @click="activeStep++" class="button is-success" v-if="showNextButton">
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
            stepProps: {
                type: Array,
                default: function () {
                    return [];
                }
            },

            step: {
                type: Number,
                default: 0
            },
        },

        data() {
            return {
                steps: [],
                activeStep: this.step,
                selected: [],
                labels: {
                    prev: "Zurück",
                    next: "Weiter"
                }
            }
        },

        computed: {
            showNextButton: function () {
                return this.activeStep < this.steps.length - 1 && this.steps[this.activeStep].selected
            }
        },

        mounted: function () {
            this.$nextTick(function () {
                this.initSteps();
                this.initActiveStep();
            })
        },

        watch: {
            activeStep: function (index, prevIndex) {
                let step = this.steps[index];
                let prevStep = this.steps[prevIndex];

                if (index != prevIndex) {
                    this.hideSection(prevIndex);
                    prevStep.active = false;
                }

                this.showSection(index);
                step.active = true;
                step.disabled = false;

                window.eventHub.$emit('wizard_step_changed', step, prevStep);
            },
        },

        methods: {
            initSteps: function () {
                $(this.$el).children('.wizard-section').each((index, section) => {
                    let stepProps = this.stepProps[index];

                    let title = null;
                    let titleWrapper = $(section).find('.wizard-title').first();
                    if (titleWrapper.length) {
                        title = titleWrapper.html();
                    }

                    let key = index;
                    if (stepProps && stepProps.key) {
                        key = stepProps.key;
                    } else {
                        let sectionId = $(section).attr('id');
                        if (sectionId) {
                            key = sectionId;
                        }
                    }

                    let selectedKey = getParameterByName(key);
                    if (stepProps && stepProps.selectedKey) {
                        selectedKey = stepProps.selectedKey;
                    }

                    let selectedTitle = null;
                    if (stepProps && stepProps.selectedTitle) {
                        selectedTitle = stepProps.selectedTitle;
                    }

                    this.steps.push({
                        index: index,
                        key: key,
                        title: title,
                        active: false,
                        disabled: selectedKey == null,
                        selected: selectedKey != null,
                        selectedTitle: selectedTitle,
                        selectedKey: selectedKey
                    });

                    $(section).hide();
                })
            },

            initActiveStep: function () {
                let activeStep = 0;
                for (let i = this.steps.length - 1; i >= 0; i--) {
                    let step = this.steps[i];
                    if (step.selected) {
                        activeStep = i + 1;
                        break;
                    }
                }

                this.activeStep = activeStep;
                this.showSection(activeStep);
                this.steps[activeStep].active = true;
                this.steps[activeStep].disabled = false;
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
            },

            select: function (selectedKey, selectedTitle) {
                let currentStep = this.steps[this.activeStep];
                currentStep.selectedTitle = selectedTitle;
                currentStep.selectedKey = selectedKey;
                currentStep.selected = true;
                this.activeStep++;
                this.selected[currentStep.key] = selectedKey;
                updateHrefParamsWithData(this.selected);
            }
        }
    }
</script>