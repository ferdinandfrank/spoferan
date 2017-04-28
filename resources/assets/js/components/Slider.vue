<template>
    <div class="slider columns">
        <div v-show="canNavigateLeft" class="action" @click="currentPosition--">
            <icon icon="fa fa-fw fa-chevron-left"></icon>
        </div>

        <slot></slot>

        <div v-show="canNavigateRight" class="action" @click="currentPosition++">
            <icon icon="fa fa-fw fa-chevron-right"></icon>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            // The number of items to show per slide.
            // [0] -> large screen
            // [1] -> medium screen
            // [2] -> small screen
            pageItems: {
                type: Array,
                default: function () {
                    return [3, 2, 1];
                }
            },

        },

        data() {
            return {
                items: [],
                currentPosition: 0,
                itemsPerPage: this.pageItems[0]
            }
        },

        computed: {
            canNavigateRight: function () {
                return this.currentPosition < this.items.length - this.itemsPerPage
            },
            canNavigateLeft: function () {
                return this.currentPosition > 0
            }
        },

        mounted() {
            this.$nextTick(function () {
                this.adaptItemsPerPage();
                $(window).resize(() => {
                    this.adaptItemsPerPage();
                });

                $(this.$el).children(':not(.action)').each((index, item) => {
                    $(item).wrap("<div class='column'></div>");
                    let wrapper = $(item).parent();

                    if (index < this.currentPosition || index + 1 > this.currentPosition + this.itemsPerPage) {
                        wrapper.hide();
                    }

                    this.items.push(wrapper);
                });
            });
        },

        watch: {
            currentPosition: function (position, prevPosition) {
                if (position !== prevPosition) {
                    if (position > prevPosition) {
                        this.items[prevPosition].hide();
                        this.items[prevPosition + this.itemsPerPage].show();
                    } else {
                        this.items[position + this.itemsPerPage].hide();
                        this.items[position].show();
                    }
                }
            },

            itemsPerPage: function (itemsPerPage, prevItemsPerPage) {
                if (itemsPerPage > prevItemsPerPage) {
                    this.items[this.currentPosition + prevItemsPerPage].show();
                } else if (prevItemsPerPage > itemsPerPage) {
                    this.items[this.currentPosition + itemsPerPage].hide();
                }
            }
        },

        methods: {
            adaptItemsPerPage: function () {
                let windowWidth = $(document).width();
                if (windowWidth >= breakpoints.widescreen) {
                    this.itemsPerPage = this.pageItems[0];
                } else if (windowWidth >= breakpoints.tablet) {
                    this.itemsPerPage = this.pageItems[1];
                } else {
                    this.itemsPerPage = this.pageItems[2];
                }
            },
        }

    }
</script>