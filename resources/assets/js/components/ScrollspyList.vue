<template>
    <ul data-gumshoe>
        <slot></slot>
    </ul>
</template>

<script>
    export default{
        props: {
            offset: {
                type: Number,
                default: 80
            },
        },

        mounted: function () {
            this.$nextTick(function () {
                $(this.$el).find('a').attr('data-scroll', '');

                gumshoe.init({
                    selector: '[data-gumshoe] a', // Default link selector (must use a valid CSS selector)
                    selectorHeader: '[data-gumshoe-header]', // Fixed header selector (must use a valid CSS selector)
                    container: window, // The element to spy on scrolling in (must be a valid DOM Node)
                    offset: this.offset, // Distance in pixels to offset calculations
                    activeClass: 'is-active', // Class to apply to active navigation link and it's parent list item
                    callback: function (nav) {} // Callback to run after setting active link
                });

                smoothScroll.init({
                    selector: '[data-scroll]', // Selector for links (must be a class, ID, data attribute, or element tag)
                    selectorHeader: null, // Selector for fixed headers (must be a valid CSS selector) [optional]
                    speed: 500, // Integer. How fast to complete the scroll in milliseconds
                    easing: 'easeInOutCubic', // Easing pattern to use
                    offset: this.offset, // Integer. How far to offset the scrolling anchor location in pixels
                    callback: function ( anchor, toggle ) {} // Function to run after scrolling
                });
            })
        },

    }
</script>

<style>

</style>
